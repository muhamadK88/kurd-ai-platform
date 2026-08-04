#!/usr/bin/env python3
import http.client
import sys
import threading
from http.server import BaseHTTPRequestHandler, ThreadingHTTPServer

WORKERS = [8001, 8002, 8003, 8004]
rr = 0
lock = threading.Lock()


def next_worker():
    global rr
    with lock:
        w = WORKERS[rr % len(WORKERS)]
        rr += 1
        return w


class Handler(BaseHTTPRequestHandler):
    protocol_version = 'HTTP/1.1'

    def _proxy(self):
        try:
            length = int(self.headers.get('Content-Length') or 0)
            body = self.rfile.read(length) if length else None
            host = self.headers.get('Host', 'localhost:8000')
            port = next_worker()
            conn = http.client.HTTPConnection('127.0.0.1', port, timeout=300)
            headers = {
                k: v for k, v in self.headers.items()
                if k.lower() not in ('connection', 'host', 'transfer-encoding')
            }
            conn.request(self.command, self.path, body=body, headers={**headers, 'Host': host})
            resp = conn.getresponse()
            data = resp.read()
            self.send_response(resp.status)
            for k, v in resp.getheaders():
                if k.lower() not in ('connection', 'transfer-encoding'):
                    self.send_header(k, v)
            self.send_header('Content-Length', str(len(data)))
            self.end_headers()
            self.wfile.write(data)
            conn.close()
        except Exception as e:
            import sys
            sys.stderr.write('PROXY ERROR: %r\n' % (e,))
            try:
                self.send_response(502)
                self.send_header('Content-Length', '0')
                self.end_headers()
            except Exception:
                pass

    def log_message(self, *args):
        pass


Handler.do_GET = Handler._proxy
Handler.do_POST = Handler._proxy
Handler.do_PUT = Handler._proxy
Handler.do_DELETE = Handler._proxy
Handler.do_OPTIONS = Handler._proxy
Handler.do_HEAD = Handler._proxy


def main():
    port = int(sys.argv[1]) if len(sys.argv) > 1 else 8000
    server = ThreadingHTTPServer(('0.0.0.0', port), Handler)
    server.serve_forever()


if __name__ == '__main__':
    main()
