<!-- ===== چاتبۆتی یاریدەدەری AI (Kurd AI) - Full Features ===== -->
<meta name="csrf-token" content="{{ csrf_token() }}">
<meta name="kurdai-user-id" content="{{ auth()->id() ?? '' }}">
<meta name="kurdai-user-admin" content="{{ auth()->user()?->is_admin ? '1' : '' }}">
<script type="application/json" id="kurdai-chat-firebase-config">{!! json_encode(config('kurdai.firebase'), 15) !!}</script>
<script data-kai-shared>
    /* pyodide is ~10MB - lazy-load it only when the user actually runs Python */
    if (!window.loadPyodide) {
        window.loadPyodide = function () {
            if (window.__pyPromise) return window.__pyPromise;
            window.__pyPromise = new Promise(function (resolve, reject) {
                var s = document.createElement('script');
                s.src = 'https://cdn.jsdelivr.net/pyodide/v0.23.4/full/pyodide.js';
                s.onload = function () {
                    try {
                        var factory = window.loadPyodide;
                        factory().then(resolve, reject);
                    } catch (e) { reject(e); }
                };
                s.onerror = function () { window.__pyPromise = null; reject(new Error('pyodide failed to load')); };
                document.head.appendChild(s);
            });
            return window.__pyPromise;
        };
    }
</script>
<script data-kai-shared>
    window.kurdaiEnsureLottie = function () {
        if (window.lottie) return true;
        var s = document.createElement('script');
        s.src = 'https://cdnjs.cloudflare.com/ajax/libs/lottie-web/5.13.0/lottie.min.js';
        s.async = true;
        document.head.appendChild(s);
        return true;
    };
</script>

<style>
    :root {
        --kw-b1: #2563eb;
        --kw-b2: #06b6d4;
        --kw-b3: #7c3aed;
        --kw-b4: #ec4899;
        --kw-b5: #38bdf8;
        --kw-grad: linear-gradient(120deg, #2563eb, #06b6d4, #7c3aed);
        --kw-bg: #0b1220;
        --kw-bg-2: #0e1628;
        --kw-glass: rgba(17, 25, 42, 0.72);
        --kw-glass-hi: rgba(17, 25, 42, 0.88);
        --kw-brd: rgba(122, 152, 214, 0.20);
        --kw-brd-hi: rgba(56, 189, 248, 0.45);
        --kw-ink: #eaf0ff;
        --kw-ink-soft: #93a2bf;
        --kw-ease: cubic-bezier(.22, 1, .36, 1);
        --kw-spring: cubic-bezier(.34, 1.56, .64, 1);
    }
    #kurdai-chat-btn {
        position: fixed; bottom: 24px; right: 24px; z-index: 9998;
        width: 72px; height: 72px; border-radius: 50%;
        background: radial-gradient(circle at 30% 25%, #1b2a4a, #0b1220 72%);
        border: 1px solid var(--kw-brd-hi); cursor: grab;
        box-shadow: 0 18px 44px rgba(0,0,0,0.45), 0 0 26px rgba(56,189,248,0.35);
        display: flex; align-items: center; justify-content: center; padding: 10px;
        backdrop-filter: blur(14px); -webkit-backdrop-filter: blur(14px);
        transition: transform 0.3s var(--kw-spring), box-shadow 0.3s; touch-action: none;
        animation: kurdaiBtnPulse 3.4s ease-in-out infinite;
    }
    #kurdai-chat-btn::before {
        content: ''; position: absolute; inset: -1px; border-radius: 50%;
        padding: 2px; -webkit-mask: linear-gradient(#000 0 0) content-box, linear-gradient(#000 0 0);
        -webkit-mask-composite: xor; mask-composite: exclude;
        background: conic-gradient(from 0deg, #2563eb, #06b6d4, #7c3aed, #ec4899, #2563eb);
        animation: kurdaiBtnSpin 8s linear infinite; pointer-events: none;
    }
    @keyframes kurdaiBtnSpin { to { transform: rotate(360deg); } }
    #kurdai-chat-btn:active { cursor: grabbing; }
    #kurdai-chat-btn.dragging { animation: none; transition: none; cursor: grabbing; transform: scale(1.05); box-shadow: 0 0 34px rgba(56,189,248,0.5); }
    #kurdai-chat-btn:hover { transform: scale(1.08); box-shadow: 0 0 40px rgba(56,189,248,0.5), 0 22px 54px rgba(0,0,0,0.5); animation-play-state: paused; }
    #kurdai-chat-btn svg { width: 74%; height: 74%; }
    #kurdai-lottie-fab { position: absolute; inset: 0; pointer-events: none; }
    @keyframes kurdaiBtnPulse { 0%,100%{box-shadow:0 18px 44px rgba(0,0,0,0.45),0 0 22px rgba(56,189,248,0.35),0 0 0 0 rgba(56,189,248,0.4)} 50%{box-shadow:0 18px 44px rgba(0,0,0,0.45),0 0 30px rgba(56,189,248,0.5),0 0 0 18px rgba(56,189,248,0)} }
    #kurdai-badge {
        position: absolute; top: -2px; right: -2px; min-width: 20px; height: 20px; padding: 0 5px;
        border-radius: 10px; background: linear-gradient(120deg, #ec4899, #7c3aed); color: #fff; font-size: 11px; font-weight: 800;
        display: none; align-items: center; justify-content: center;
        border: 2px solid #0b1220; box-shadow: 0 0 12px rgba(236,72,153,0.7);
    }
    #kurdai-badge.show { display: flex; }
    #kurdai-status::before {
        content: ''; display: inline-block; width: 8px; height: 8px; border-radius: 50%;
        background: #34d399; box-shadow: 0 0 8px #34d399; margin-inline-end: 6px; vertical-align: middle;
    }
    #kurdai-greet {
        position: fixed; bottom: 108px; right: 24px; z-index: 9997; display: none; cursor: pointer;
        background: var(--kw-glass-hi); backdrop-filter: blur(18px); -webkit-backdrop-filter: blur(18px);
        border: 1px solid var(--kw-brd-hi); color: var(--kw-ink);
        border-radius: 18px; padding: 13px 17px; font-size: 13.5px; max-width: 240px; line-height: 1.7;
        box-shadow: 0 16px 40px rgba(0,0,0,0.45), 0 0 20px rgba(56,189,248,0.18);
        animation: kurdaiBtnFloat 3s ease-in-out infinite;
    }
    #kurdai-greet .g-x { float: left; margin: -5px -8px 0 8px; color: var(--kw-ink-soft); font-size: 15px; font-weight: 700; }
    #kurdai-greet .g-x:hover { color: #f87171; }
    @media (max-width: 640px) {
        #kurdai-chat-panel { width: 100vw; height: 100vh; bottom: 0; right: 0; border-radius: 0; }
        #kurdai-chat-btn { bottom: 16px; right: 16px; width: 62px; height: 62px; }
        #kurdai-greet { bottom: 88px; right: 16px; }
        #kurdai-chat-input { font-size: 16px; }
    }
    #kurdai-chat-panel.fullscreen {
        position: fixed; inset: 0; width: 100vw; height: 100dvh;
        border-radius: 0; z-index: 10001; border: none;
        box-shadow: none; transform: none; opacity: 1;
    }
    @keyframes kurdaiBtnFloat { 0%,100%{transform:translateY(0)} 50%{transform:translateY(-3px)} }
    #kurdai-chat-panel.dragging { transition: none; }
    #kurdai-chat-header { cursor: grab; touch-action: none; user-select: none; }
    #kurdai-chat-panel.dragging #kurdai-chat-header { cursor: grabbing; }
    #kurdai-chat-panel {
        position: fixed; bottom: 112px; right: 24px; z-index: 9999;
        width: min(480px, calc(100vw - 48px)); height: min(660px, calc(100vh - 140px));
        display: flex; flex-direction: column; border-radius: 28px; overflow: hidden;
        background: var(--kw-glass-hi); backdrop-filter: blur(24px); -webkit-backdrop-filter: blur(24px);
        border: 1px solid var(--kw-brd);
        box-shadow: 0 24px 70px rgba(0,0,0,0.55), 0 0 30px rgba(56,189,248,0.12);
        opacity: 0; transform: translateY(20px) scale(0.95); pointer-events: none; transition: all 0.32s var(--kw-ease);
    }
    #kurdai-chat-panel.open { opacity: 1; transform: translateY(0) scale(1); pointer-events: auto; }
    #kurdai-chat-header {
        background: linear-gradient(135deg, rgba(17,25,42,0.92), rgba(11,18,32,0.88));
        border-bottom: 1px solid var(--kw-brd); color: var(--kw-ink);
        padding: 16px 18px; display: flex; align-items: center; gap: 12px; flex-shrink: 0;
    }
    #kurdai-chat-header .avatar {
        width: 46px; height: 46px; background: radial-gradient(circle at 30% 25%, #1b2a4a, #0b1220 72%);
        border: 1px solid var(--kw-brd-hi); border-radius: 50%;
        display: flex; align-items: center; justify-content: center; flex-shrink: 0;
        padding: 5px; position: relative;
        box-shadow: 0 0 14px rgba(56,189,248,0.35);
        animation: kurdaiAvatarGlow 3s ease-in-out infinite;
    }
    #kurdai-chat-header .avatar img { width: 100%; height: 100%; object-fit: contain; border-radius: 50%; }
    #kurdai-chat-header .avatar::after {
        content: ''; position: absolute; inset: -4px; border-radius: 50%;
        border: 2px solid var(--kw-b5);
        animation: kurdaiAvatarRing 2.5s ease-out infinite;
    }
    @keyframes kurdaiAvatarGlow { 0%,100%{box-shadow:0 0 10px rgba(56,189,248,0.3)} 50%{box-shadow:0 0 24px rgba(56,189,248,0.7),0 0 46px rgba(124,58,237,0.35)} }
    @keyframes kurdaiAvatarRing { 0%{transform:scale(1);opacity:0.8} 100%{transform:scale(1.8);opacity:0} }
    #kurdai-chat-header .hdr-title { min-width: 0; flex: 1; }
    #kurdai-chat-header h4 {
        font-size: 16px; font-weight: 900; margin: 0;
        background: var(--kw-grad);
        -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text;
    }
    #kurdai-chat-header span { font-size: 11px; color: var(--kw-ink-soft); display: block; }
    .hdr-btn {
        background: rgba(56,189,248,0.08); border: 1px solid var(--kw-brd);
        color: var(--kw-b5); width: 32px; height: 32px; border-radius: 10px;
        cursor: pointer; display: flex; align-items: center; justify-content: center;
        flex-shrink: 0; transition: all 0.2s;
    }
    .hdr-btn:hover { background: rgba(56,189,248,0.18); box-shadow: 0 0 14px rgba(56,189,248,0.4); transform: scale(1.06); }
    .hdr-btn svg { width: 16px; height: 16px; }
    #kurdai-chat-body { flex: 1 1 auto; display: flex; flex-direction: column; min-height: 0; height: 0; overflow: hidden; }
    #kurdai-chat-messages {
        flex: 1 1 auto; min-height: 0; height: 0; overflow-y: scroll; overflow-x: hidden; padding: 20px 16px;
        display: flex; flex-direction: column; gap: 14px;
        overscroll-behavior: contain; -webkit-overflow-scrolling: touch; touch-action: pan-y;
        background: var(--kw-bg);
        background-image:
            radial-gradient(rgba(56,189,248,0.08) 1px, transparent 1px),
            radial-gradient(600px 200px at 100% 0%, rgba(124,58,237,0.10), transparent);
        background-size: 24px 24px, 100% 100%;
    }
    #kurdai-chat-messages::-webkit-scrollbar, #kurdai-session-list::-webkit-scrollbar { width: 5px; }
    #kurdai-chat-messages::-webkit-scrollbar-thumb, #kurdai-session-list::-webkit-scrollbar-thumb { background: rgba(56,189,248,0.35); border-radius: 10px; }
    .chat-msg {
        max-width: 88%; padding: 12px 16px; border-radius: 18px;
        font-size: 14.5px; line-height: 1.75; white-space: pre-wrap; word-break: break-word;
        animation: chatFadeIn 0.25s ease; position: relative;
    }
    @keyframes chatFadeIn { from{opacity:0;transform:translateY(6px)} to{opacity:1;transform:translateY(0)} }
    .chat-msg.user {
        align-self: flex-start;
        background: linear-gradient(135deg, rgba(37,99,235,0.22), rgba(6,182,212,0.14));
        border: 1px solid rgba(56,189,248,0.35); box-shadow: 0 6px 18px rgba(0,0,0,0.25);
        color: #dff1ff; border-bottom-left-radius: 6px;
    }
    .chat-msg.bot {
        align-self: flex-end;
        background: linear-gradient(135deg, rgba(17,25,42,0.9), rgba(124,58,237,0.16));
        border: 1px solid rgba(124,58,237,0.35); box-shadow: 0 6px 18px rgba(0,0,0,0.25);
        color: var(--kw-ink); border-bottom-right-radius: 6px;
    }
    .chat-msg img.user-img { max-width: 200px; max-height: 200px; border-radius: 10px; margin-top: 8px; }
    .chat-msg.bot code {
        background: rgba(56,189,248,0.14); color: var(--kw-b5);
        padding: 2px 6px; border-radius: 6px; font-size: 12.5px; direction: ltr; display: inline-block;
    }
    .chat-msg.bot pre {
        direction: ltr; text-align: left;
        background: #070b14; border: 1px solid rgba(56,189,248,0.25);
        color: #c7f0ff; padding: 14px; border-radius: 12px;
        overflow-x: auto; font-size: 13px; margin: 10px 0;
    }
    .chat-msg.bot pre code { background: none; padding: 0; border-radius: 0; color: inherit; }
    .chat-typing { display: flex; align-items: center; padding: 10px 8px; }
    .nn-typing { display: flex; align-items: center; justify-content: center; }
    .nn-svg { width: 160px; height: 46px; }
    .nn-line { stroke: rgba(56,189,248,0.28); stroke-width: 1.1; stroke-dasharray: 4 8; animation: nnFlow 1.2s linear infinite; }
    .nn-node {
        fill: #38bdf8; transform-box: fill-box; transform-origin: center;
        animation: nnPulse 1.5s ease-in-out infinite;
    }
    @keyframes nnFlow { to { stroke-dashoffset: -12; } }
    @keyframes nnPulse { 0%,100% { opacity: 0.3; transform: scale(0.7); } 50% { opacity: 1; transform: scale(1.25); } }
    @media (prefers-reduced-motion: reduce) { .nn-line, .nn-node { animation: none; } }
    .chat-wait-hint {
        display: none; text-align: center; color: var(--kw-ink-soft); font-size: 12px;
        padding: 4px 10px; margin: 2px auto; border-radius: 10px;
        background: rgba(255,255,255,0.05); max-width: 90%;
    }
    .chat-msg-actions { display: flex; gap: 4px; margin-top: 6px; opacity: 0; transition: opacity 0.2s; }
    .chat-msg:hover .chat-msg-actions { opacity: 1; }
    .chat-msg-actions button {
        background: rgba(56,189,248,0.08); border: 1px solid var(--kw-brd);
        color: var(--kw-ink-soft); width: 28px; height: 28px; border-radius: 8px;
        cursor: pointer; display: flex; align-items: center; justify-content: center;
        font-size: 13px; transition: all 0.2s;
    }
    .chat-msg-actions button:hover { background: rgba(56,189,248,0.18); color: var(--kw-b5); }
    .chat-msg-actions button.run-btn {
        width: auto; padding: 0 10px; font-size: 11px; font-weight: 700; gap: 4px;
        color: #34d399; border-color: rgba(52,211,153,0.4);
    }
    .chat-msg-actions button.run-btn:hover { background: rgba(52,211,153,0.14); }
    #kurdai-chat-input-wrap {
        display: flex; flex-direction: column; gap: 0;
        background: rgba(14,22,40,0.9); border-top: 1px solid var(--kw-brd); flex-shrink: 0;
    }
    #kurdai-input-bar { display: flex; align-items: flex-end; gap: 6px; padding: 12px 14px; }
    #kurdai-tool-bar { display: flex; gap: 6px; padding: 0 14px 10px; flex-wrap: wrap; }
    .tool-btn {
        background: rgba(56,189,248,0.07); border: 1px solid var(--kw-brd);
        color: var(--kw-ink-soft); width: 32px; height: 32px; border-radius: 10px;
        cursor: pointer; display: flex; align-items: center; justify-content: center;
        transition: all 0.2s;
    }
    .tool-btn:hover { background: rgba(56,189,248,0.18); color: var(--kw-b5); }
    .tool-btn svg { width: 15px; height: 15px; }
    #kurdai-tier { margin-left: auto; width: auto; min-width: 92px; padding: 0 12px; gap: 4px; font-weight: 800; font-size: 11px; letter-spacing: .2px; color: #fbbf24; border-color: rgba(251,191,36,.4); background: rgba(251,191,36,.08); white-space: nowrap; }
    #kurdai-tier:hover { background: rgba(251,191,36,.16); color: #fde68a; border-color: rgba(251,191,36,.6); }
    #kurdai-tier.pro-active { background: linear-gradient(135deg, rgba(251,191,36,.2), rgba(168,85,247,.2)); border-color: rgba(251,191,36,.7); color: #fde68a; box-shadow: 0 0 14px rgba(251,191,36,.28); }
    #kurdai-chat-input {
        flex: 1; border: 1px solid var(--kw-brd); border-radius: 14px;
        padding: 12px 16px; font-size: 15px; background: rgba(11,18,32,0.75); color: var(--kw-ink);
        outline: none; transition: border-color 0.2s, box-shadow 0.2s; min-width: 0;
        resize: none; overflow-y: auto; line-height: 1.6; font-family: inherit; max-height: 140px;
    }
    #kurdai-chat-input::placeholder { color: #5a6b8c; }
    #kurdai-chat-input:focus { border-color: var(--kw-b5); box-shadow: 0 0 14px rgba(56,189,248,0.35); }
    #kurdai-chat-send {
        width: 50px; height: 50px; border: none; border-radius: 14px;
        background: var(--kw-grad); color: #fff;
        cursor: pointer; display: flex; align-items: center; justify-content: center;
        transition: all 0.2s; flex-shrink: 0; box-shadow: 0 8px 22px rgba(37,99,235,0.4);
    }
    #kurdai-chat-send:hover { transform: scale(1.05); box-shadow: 0 10px 28px rgba(124,58,237,0.5); }
    #kurdai-chat-send:disabled { opacity: 0.5; cursor: not-allowed; transform: none; box-shadow: none; }
    #kurdai-chat-send svg { width: 22px; height: 22px; }
    #kurdai-session-list {
        flex: 1; overflow-y: auto; padding: 14px 12px;
        display: flex; flex-direction: column; gap: 9px; background: var(--kw-bg);
    }
    #kurdai-session-list.empty::after {
        content: attr(data-empty-text); display: block; text-align: center; color: var(--kw-ink-soft); font-size: 13px; padding: 40px 10px;
    }
    .session-row {
        display: flex; align-items: center; gap: 8px;
        padding: 11px 13px; border-radius: 14px; background: rgba(17,25,42,0.75);
        border: 1px solid var(--kw-brd); cursor: pointer; transition: all 0.2s;
    }
    .session-row:hover { border-color: var(--kw-brd-hi); box-shadow: 0 0 12px rgba(56,189,248,0.2); }
    .session-row.active { border-color: var(--kw-b5); box-shadow: 0 0 0 2px rgba(56,189,248,0.16); }
    .session-row .s-title { flex: 1; min-width: 0; font-size: 14px; font-weight: 700; color: var(--kw-ink); white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
    .session-row .s-meta { font-size: 11px; color: var(--kw-ink-soft); margin-top: 2px; }
    .session-row .s-pin, .session-row .s-del {
        background: none; border: none; cursor: pointer; padding: 5px; border-radius: 8px; color: var(--kw-ink-soft);
        display: flex; align-items: center; justify-content: center; transition: all 0.2s; flex-shrink: 0;
    }
    .session-row .s-pin svg, .session-row .s-del svg { width: 16px; height: 16px; }
    .session-row .s-pin:hover { color: #34d399; }
    .session-row .s-pin.pinned { color: #34d399; text-shadow: 0 0 8px #34d399; }
    .session-row .s-del:hover { color: #f87171; }
    #kurdai-scroll-down {
        position: absolute; right: 14px; bottom: 128px; z-index: 5;
        width: 36px; height: 36px; border-radius: 50%;
        background: rgba(17,25,42,0.95); border: 1px solid var(--kw-brd-hi);
        color: var(--kw-b5); cursor: pointer; display: none; align-items: center; justify-content: center;
        box-shadow: 0 0 14px rgba(56,189,248,0.3); transition: all 0.2s;
    }
    #kurdai-scroll-down.show { display: flex; }
    #kurdai-scroll-down:hover { background: rgba(56,189,248,0.16); }
    #kurdai-scroll-down svg { width: 18px; height: 18px; }
    #kurdai-search-wrap {
        display: none; align-items: center; gap: 8px; padding: 12px 14px 4px; flex-shrink: 0;
    }
    #kurdai-search-wrap input {
        flex: 1; border: 1px solid var(--kw-brd); border-radius: 10px;
        padding: 9px 13px; font-size: 13.5px; background: rgba(11,18,32,0.75); color: var(--kw-ink); outline: none;
    }
    #kurdai-search-wrap input:focus { border-color: var(--kw-b5); box-shadow: 0 0 10px rgba(56,189,248,0.3); }
    #kurdai-search-wrap svg { width: 16px; height: 16px; color: var(--kw-b5); flex-shrink: 0; }
    #kurdai-backdrop {
        position: fixed; inset: 0; z-index: 9995; background: rgba(4,8,16,0.5);
        backdrop-filter: blur(3px); -webkit-backdrop-filter: blur(3px);
        opacity: 0; pointer-events: none; transition: opacity 0.3s;
    }
    #kurdai-backdrop.show { opacity: 1; pointer-events: auto; }
    #kurdai-chat-body { position: relative; }
    #kurdai-preview {
        background: rgba(17,25,42,0.8); border: 1px solid var(--kw-brd-hi); border-radius: 10px;
        padding: 10px; max-height: 120px; overflow: auto; display: none; margin: 0 14px; color: var(--kw-ink); font-size: 12px;
    }
    /* AI command-center skin */
    #kurdai-chat-panel { background:#080d1a; border-color:rgba(94,234,212,.22); box-shadow:0 30px 90px rgba(0,0,0,.68), 0 0 55px rgba(45,212,191,.08); }
    #kurdai-chat-panel::before { content:''; position:absolute; inset:0; pointer-events:none; opacity:.18; background-image:linear-gradient(rgba(94,234,212,.12) 1px,transparent 1px),linear-gradient(90deg,rgba(94,234,212,.12) 1px,transparent 1px); background-size:28px 28px; mask-image:linear-gradient(to bottom, #000, transparent 70%); }
    #kurdai-chat-header { position:relative; z-index:1; background:linear-gradient(120deg,rgba(7,18,31,.98),rgba(18,12,43,.96)); border-bottom-color:rgba(94,234,212,.18); }
    #kurdai-chat-header .avatar { border-color:rgba(94,234,212,.65); box-shadow:0 0 24px rgba(45,212,191,.24); }
    #kurdai-chat-header .avatar::after { border-color:#a78bfa; }
    #kurdai-chat-messages { position:relative; z-index:1; background-color:#080d1a; background-image:radial-gradient(circle at 12% 12%,rgba(45,212,191,.11),transparent 26%),radial-gradient(circle at 88% 75%,rgba(167,139,250,.12),transparent 30%),linear-gradient(rgba(94,234,212,.035) 1px,transparent 1px),linear-gradient(90deg,rgba(94,234,212,.035) 1px,transparent 1px); background-size:auto,auto,32px 32px,32px 32px; }
    #kurdai-chat-input-wrap { position:relative; z-index:2; background:rgba(6,12,24,.96); border-top-color:rgba(94,234,212,.2); }
    .chat-msg.bot { background:linear-gradient(145deg,rgba(15,23,42,.96),rgba(37,25,75,.72)); border-color:rgba(167,139,250,.32); }
    .chat-msg.user { background:linear-gradient(145deg,rgba(8,47,73,.9),rgba(15,118,110,.45)); border-color:rgba(94,234,212,.32); }
    .nn-typing { width:235px; flex-direction:column; gap:4px; }
    .nn-svg { width:210px; height:64px; overflow:visible; }
    .nn-grid { stroke:rgba(94,234,212,.11); stroke-width:.6; stroke-dasharray:2 5; }
    .nn-flow { stroke:#5eead4; stroke-width:1.5; stroke-dasharray:3 7; animation:nnDataFlow 1s linear infinite; filter:drop-shadow(0 0 3px rgba(94,234,212,.7)); }
    .nn-core { fill:#a78bfa; stroke:#ede9fe; stroke-width:1; transform-box:fill-box; transform-origin:center; animation:nnCorePulse 1.4s ease-in-out infinite; filter:drop-shadow(0 0 5px #a78bfa); }
    .nn-ring { fill:none; stroke:rgba(94,234,212,.7); stroke-width:1; stroke-dasharray:2 5; transform-origin:center; animation:nnRingSpin 4s linear infinite; }
    .nn-caption { color:#8ca3bd; font-size:10px; letter-spacing:.08em; direction:ltr; }
    @keyframes nnDataFlow { to { stroke-dashoffset:-20; } }
    @keyframes nnCorePulse { 0%,100% { transform:scale(.78); opacity:.55; } 50% { transform:scale(1.25); opacity:1; } }
    @keyframes nnRingSpin { to { transform:rotate(360deg); } }
    @media (prefers-reduced-motion:reduce) { .nn-flow,.nn-core,.nn-ring { animation:none; } }
    /* Header controls are a single calm toolbar instead of a crowded icon row. */
    #kurdai-chat-header { flex-wrap:wrap; padding:14px 16px 12px; gap:10px; }
    #kurdai-chat-header .avatar { width:42px; height:42px; }
    #kurdai-chat-header .hdr-title { flex:1 1 auto; }
    .kurdai-header-actions { order:3; flex:1 0 100%; display:grid; grid-template-columns:repeat(auto-fit,minmax(58px,1fr)); gap:6px; padding-top:9px; border-top:1px solid rgba(148,163,184,.13); }
    .kurdai-header-actions .hdr-btn { width:100%; height:38px; min-width:0; border-radius:11px; flex-direction:column; gap:2px; background:rgba(15,23,42,.7); color:#94a3b8; }
    .kurdai-header-actions .hdr-btn svg { width:15px; height:15px; }
    .kurdai-header-actions .hdr-btn::after { font-size:9px; font-weight:800; line-height:1; color:#94a3b8; }
    #kurdai-sessions-toggle::after { content:'مێژوی گفتوگۆ'; }
    #kurdai-new-session::after { content:'نوێ'; }
    #kurdai-analytics-btn::after { content:'ئامار'; }
    #kurdai-admin-btn::after { content:'بەڕێوەبردن'; }
    #kurdai-chat-close::after { content:'داخستن'; }
    .kurdai-header-actions .hdr-btn:hover { color:#5eead4; border-color:rgba(94,234,212,.5); background:rgba(45,212,191,.1); transform:translateY(-1px); }
    .kurdai-header-actions #kurdai-chat-close { color:#fda4af; }
    .kurdai-header-actions #kurdai-chat-close:hover { color:#fff; border-color:#fb7185; background:rgba(244,63,94,.16); }
    .kurdai-header-actions #kurdai-admin-btn.teaching-active { color:#06221f; background:#5eead4; border-color:#99f6e4; }
    @media (max-width:640px) { .kurdai-header-actions { grid-template-columns:repeat(5,1fr); } .kurdai-header-actions .hdr-btn::after { font-size:8px; } }
</style>

<div id="kurdai-widget-root">
<button id="kurdai-chat-btn" aria-label="چاتبۆتی کورد ئەی ئای">
    <svg viewBox="0 0 24 24" aria-hidden="true">
        <defs>
            <linearGradient id="kurdaiBubbleGrad" x1="0" y1="0" x2="1" y2="1">
                <stop offset="0" stop-color="#2563eb"/>
                <stop offset="0.5" stop-color="#06b6d4"/>
                <stop offset="1" stop-color="#7c3aed"/>
            </linearGradient>
        </defs>
        <path fill="url(#kurdaiBubbleGrad)" d="M12 2.8C6.4 2.8 2 6.8 2 11.7c0 2.9 1.6 5.4 4.1 7-.1 1-.6 2.4-1.9 3.4 0 0 2.6-.2 4.5-1.6.9.2 1.9.4 2.9.4 5.6 0 10-3.9 10-8.9S17.6 2.8 12 2.8z"/>
        <circle cx="8" cy="11.5" r="1.3" fill="#0b1220"/>
        <circle cx="12" cy="11.5" r="1.3" fill="#0b1220"/>
        <circle cx="16" cy="11.5" r="1.3" fill="#0b1220"/>
    </svg>
    <div id="kurdai-lottie-fab" aria-hidden="true"></div>
    <span id="kurdai-badge">0</span>
</button>

<div id="kurdai-chat-panel">
    <div id="kurdai-chat-header">
        <div class="avatar"><img src="logo.jpg" alt="Kurd AI"></div>
        <div class="hdr-title">
            <h4>KURD AI</h4>
            <span id="kurdai-status"></span>
        </div>
        <div class="kurdai-header-actions">
        <button id="kurdai-sessions-toggle" class="hdr-btn" title="مێژوی گفتوگۆ">
            <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h10"/></svg>
        </button>
        <button id="kurdai-new-session" class="hdr-btn" title="گفتوگۆی نوێ">
            <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/></svg>
        </button>
        <button id="kurdai-admin-btn" class="hdr-btn" title="زیادکردنی زانیاری بۆ چاتبۆت" style="display:none;">
            <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 13h6m-3-3v6m5 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
        </button>
        <button id="kurdai-analytics-btn" class="hdr-btn" title="شیکردنەوەی بەکارهێنان" style="display:none;">
            <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4 19V5m0 14h16M8 16v-5m4 5V7m4 9v-8"/></svg>
        </button>
        <button id="kurdai-chat-close" class="hdr-btn" title="داخستن">
            <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
        </button>
        </div>
    </div>
    <div id="kurdai-chat-body">
        <button id="kurdai-scroll-down" title="بۆ خوارەوە">
            <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19 14l-7 7m0 0l-7-7m7 7V3"/></svg>
        </button>
        <div id="kurdai-search-wrap">
            <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-4.35-4.35m1.35-5.4a6.75 6.75 0 11-13.5 0 6.75 6.75 0 0113.5 0z"/></svg>
            <input id="kurdai-search" placeholder="" autocomplete="off">
        </div>
        <div id="kurdai-session-list" style="display:none;"></div>
        <div id="kurdai-chat-messages"></div>
        <div id="kurdai-chat-input-wrap">
            <div id="kurdai-preview"></div>
            <div id="kurdai-tool-bar">
                <button class="tool-btn" id="kurdai-file-btn" title="فایل">
                    <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13"/></svg>
                </button>
                <button class="tool-btn" id="kurdai-image-btn" title="وێنە">
                    <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                </button>
                <button class="tool-btn" id="kurdai-tier" title=""></button>
            </div>
            <div id="kurdai-input-bar">
                <textarea id="kurdai-chat-input" rows="1" placeholder="" autocomplete="off"></textarea>
                <button id="kurdai-chat-send" aria-label="ناردن">
                    <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/></svg>
                </button>
            </div>
        </div>
    </div>
</div>
<div id="kurdai-backdrop"></div>
</div>

<script type="module" data-kai-shared>
/* Firebase is the heaviest dependency here (~110KB gzipped). It is only
   needed once the chat is actually opened (or for admin detection), so it is
   fetched lazily: on first hover/tap of the launcher, or shortly after the
   page has finished loading. First paint never waits for it. */
let kurdaiBootPromise = null;
async function kurdaiBootChat() {
    if (window.__kurdaiChatBooted) return kurdaiBootPromise;
    window.__kurdaiChatBooted = true;
    kurdaiBootPromise = (async () => {
        const fappMod = await import("https://www.gstatic.com/firebasejs/10.12.2/firebase-app.js");
        const fauthMod = await import("https://www.gstatic.com/firebasejs/10.12.2/firebase-auth.js");
        const fdbMod = await import("https://www.gstatic.com/firebasejs/10.12.2/firebase-database.js");
        const { initializeApp, getApp } = fappMod;
        const { getAuth, onAuthStateChanged } = fauthMod;
        const { getDatabase, ref: dbRef, push, set, get, remove } = fdbMod;
(async function () {
    const btn = document.getElementById('kurdai-chat-btn');
    const panel = document.getElementById('kurdai-chat-panel');
    const closeBtn = document.getElementById('kurdai-chat-close');
    const sessionsToggle = document.getElementById('kurdai-sessions-toggle');
    const newSessionBtn = document.getElementById('kurdai-new-session');
    const messagesEl = document.getElementById('kurdai-chat-messages');
    const listEl = document.getElementById('kurdai-session-list');
    const input = document.getElementById('kurdai-chat-input');
    const sendBtn = document.getElementById('kurdai-chat-send');
    const statusEl = document.getElementById('kurdai-status');
    const toolBar = document.getElementById('kurdai-tool-bar');
    const fileBtn = document.getElementById('kurdai-file-btn');
    const imageBtn = document.getElementById('kurdai-image-btn');
    const previewEl = document.getElementById('kurdai-preview');
    const badgeEl = document.getElementById('kurdai-badge');
    const searchInput = document.getElementById('kurdai-search');
    const scrollDownBtn = document.getElementById('kurdai-scroll-down');
    const backdrop = document.getElementById('kurdai-backdrop');
    const reducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

    let unreadCount = 0;
    let searchQuery = '';
    let soundEnabled = localStorage.getItem('kurdai_sound') !== 'off';
    let userEmail = '';
    let firebaseIdToken = '';
    let firebaseDb = null;
    let firebaseUid = '';
    let identityReadyResolve;
    const identityReady = new Promise(resolve => { identityReadyResolve = resolve; });

    const adminBtn = document.getElementById('kurdai-admin-btn');
    const analyticsBtn = document.getElementById('kurdai-analytics-btn');
    let isAdmin = document.querySelector('meta[name="kurdai-user-admin"]')?.content === '1';
    function setAdmin(v) {
        isAdmin = v;
        if (adminBtn) adminBtn.style.display = v ? 'flex' : 'none';
    }
    function setOwner(email) {
        if (analyticsBtn) analyticsBtn.style.display = String(email || '').toLowerCase() === 'mahamadkamaran890@gmail.com' ? 'flex' : 'none';
    }
    setOwner('');
    setAdmin(isAdmin);

    async function detectAdminFromFirebase() {
        try {
            const cfgEl = document.getElementById('kurdai-firebase-config') || document.getElementById('kurdai-chat-firebase-config');
            if (!cfgEl || !cfgEl.textContent) { identityReadyResolve(); return; }
            let fapp;
            try { fapp = getApp(); } catch (e) { fapp = initializeApp(JSON.parse(cfgEl.textContent)); }
            const fauth = getAuth(fapp);
            onAuthStateChanged(fauth, async (user) => {
                if (!user) { setAdmin(isAdmin); setOwner(''); identityReadyResolve(); return; }
                userEmail = String(user.email || '').toLowerCase();
                firebaseIdToken = await user.getIdToken();
                firebaseUid = user.uid || '';
                firebaseDb = getDatabase(fapp);
                setOwner(userEmail);
                identityReadyResolve();
                try {
                    const idToken = await user.getIdToken();
                    const res = await fetch('/api/knowledge', {
                        headers: { 'Accept': 'application/json', 'Authorization': 'Bearer ' + idToken, 'X-Firebase-Id-Token': idToken },
                    });
                    setAdmin(res.status === 200);
                } catch (e) {}
            });
        } catch (e) { identityReadyResolve(); }
    }
    detectAdminFromFirebase();

    function clearUnread() { unreadCount = 0; badgeEl.classList.remove('show'); }

    let audioCtx = null;
    function playPing() {
        if (!soundEnabled) return;
        try {
            const AC = window.AudioContext || window.webkitAudioContext;
            if (!AC) return;
            audioCtx = audioCtx || new AC();
            if (audioCtx.state === 'suspended') audioCtx.resume();
            const t0 = audioCtx.currentTime;
            const blip = (freq, at, dur) => {
                const o = audioCtx.createOscillator(), g = audioCtx.createGain();
                o.type = 'sine'; o.frequency.value = freq;
                g.gain.setValueAtTime(0.0001, t0 + at);
                g.gain.exponentialRampToValueAtTime(0.12, t0 + at + 0.02);
                g.gain.exponentialRampToValueAtTime(0.0001, t0 + at + dur);
                o.connect(g); g.connect(audioCtx.destination);
                o.start(t0 + at); o.stop(t0 + at + dur + 0.05);
            };
            blip(880, 0, 0.18); blip(1174.66, 0.12, 0.22);
        } catch (e) {}
    }

    function closePanel() {
        panel.classList.remove('open');
        backdrop.classList.remove('show');
    }

    function openPanel() {
        panel.classList.add('open');
        backdrop.classList.add('show');
        clearUnread();
        if (!messagesEl.children.length) addMessage('bot', t('welcome'));
        refreshUiTexts(); loadSessions(); input.focus();
        fetch('/api/chat/quota?user_key=' + encodeURIComponent(userKey), { headers: { 'Accept': 'application/json' } })
            .then(r => r.json())
            .then(d => { if (d && typeof d.pro_remaining === 'number') { proRemaining = d.pro_remaining; proLimit = d.pro_limit || 5; updateTierUI(); } })
            .catch(() => {});
    }

    function autosizeInput() {
        input.style.height = 'auto';
        input.style.height = Math.min(input.scrollHeight, 140) + 'px';
    }

    const csrf = document.querySelector('meta[name="csrf-token"]')?.content || '';

    const T = {
        so: {
            welcome: 'سڵاو! من یاریدەدەری کورد ئەی ئای م. بۆ فێربوونی پرۆگرامسازی، زیرەکی دەستکرد یان هەر پرسیارێکی تر بە کوردی پرسیارم لێ بکە 😊',
             status: 'بەردەستە - بە کوردی پرسیار بکە', status_list: 'مێژووی گفتوگۆ',
            placeholder: 'پرسیارەکەت لێرە بنووسە...',
            untitled: 'گفتوگۆی بێ ناو', now: 'ئێستا',
            delete_confirm: 'ئەم گفتوگۆیە بسڕینەوە؟', pin_on: 'لێکردنەوە لە پین', pin_off: 'پینکردن',
            delete: 'سڕینەوە', empty: 'هیچ گفتوگۆیەک نییە',
            network_error: 'ببورە، کێشەیەک ڕوویدا لە پەیوەندیدا.', wait_hint: 'ببورە، کەمێک درێژە دەکێشێت، تکایە چاوەڕێ بکە...',             greet: 'سڵاو! پێویستت بە یارمەتییە؟',
            run: '▶ کارپێکردن', file_attached: 'فایل: ',
             search_ph: 'گەڕان لە گفتوگۆکان...', teach_placeholder: 'فێرکردن بنووسە؛ نموونە: لەم بابەتەدا هەمیشە بە ئەم شێوەیە وەڵام بدە...',
            tier_normal: 'ئاسایی', tier_pro: 'پڕۆ',
            tier_hint: 'گۆڕین لە نێوان ئاسایی و پڕۆ (پڕۆ: ٥ پەیام لە ڕۆژێکدا)', pro_remaining: 'ماوە لە ڕۆژەکە:',
        },
        ba: {
            welcome: 'سڵاو! ئەز یاریدەدەری کورد ئەی ئای م. بۆ فێربوونا پرۆگرامسازیێ، ژیرییا دەستکرد یان هەر پرسیارەکا تر ب کوردی پرسیارە ژ من بکە 😊',
             status: 'بەردەستە - ب کوردی پرسیار بکە', status_list: 'مێژووی گفتوگۆ',
            placeholder: 'پرسیارا خۆ ڤێرە بنڤێسە...',
            untitled: 'گفتوگۆیەکا بێ ناڤ', now: 'نوکە',
            delete_confirm: 'ئەڤ گفتوگۆیا ب سڕینەوە؟', pin_on: 'ژ پین دەرخستن', pin_off: 'پینکرن',
            delete: 'سڕینەوە', empty: 'چ گفتوگۆیەک نینە',
            network_error: 'ببورە، کێشەیەک ڕوویدا د گرێدانێ دا.', wait_hint: 'ببورە، دەمەکێک درێژ دکەت، تکایە چاڤڕێ بکە...',             greet: 'سڵاو! پێدڤیت ب یارمەتییە؟',
            run: '▶ کاردان', file_attached: 'فایل: ',
             search_ph: 'گەڕان د گفتوگۆیان...', teach_placeholder: 'فێرکرن بنڤیسە؛ نموونە: د ڤی بابەتی دا هەردەم ب ڤی شێوەی بەرسڤ بدە...',
            tier_normal: 'ئاسایی', tier_pro: 'پرۆ',
            tier_hint: 'گوهۆڕینا نێڤبەرا ئاسایی و پرۆ (پرۆ: ٥ پەیام د ڕۆژەکێ دا)', pro_remaining: 'مایی د ڕۆژێ دا:',
        },
    };

    const FAB_LOTTIE = {
        "v": "5.7.4", "fr": 30, "ip": 0, "op": 60, "w": 200, "h": 200, "nm": "fab", "ddd": 0, "assets": [],
        "layers": [
            { "ddd": 0, "ind": 1, "ty": 4, "nm": "ring2", "sr": 1,
              "ks": { "o": { "a": 0, "k": 100 }, "r": { "a": 0, "k": 0 }, "p": { "a": 0, "k": [100, 100, 0] }, "a": { "a": 0, "k": [0, 0, 0] }, "s": { "a": 0, "k": [100, 100, 100] } },
              "ao": 0,
              "shapes": [{ "ty": "gr", "nm": "ring", "it": [
                  { "ty": "el", "nm": "el", "p": { "a": 0, "k": [0, 0] }, "s": { "a": 0, "k": [130, 130] } },
                  { "ty": "st", "nm": "st", "c": { "a": 0, "k": [0.486, 0.227, 0.929, 1] }, "o": { "a": 1, "k": [ { "i": {"x":[0.6,0.6],"y":[1,1]}, "o": {"x":[0.4,0.4],"y":[0,0]}, "t": 0, "s": [90] }, { "i": {"x":[0.6,0.6],"y":[1,1]}, "o": {"x":[0.4,0.4],"y":[0,0]}, "t": 20, "s": [90] }, { "t": 40, "s": [0] } ] }, "w": { "a": 0, "k": 3 }, "lc": 2, "lj": 2, "ml": 4, "bm": 0, "d": [] },
                  { "ty": "tr", "nm": "tr", "p": { "a": 0, "k": [100, 100] }, "a": { "a": 0, "k": [0, 0] }, "s": { "a": 1, "k": [ { "i": {"x":[0.6,0.6],"y":[1,1]}, "o": {"x":[0.4,0.4],"y":[0,0]}, "t": 0, "s": [40, 40] }, { "i": {"x":[0.6,0.6],"y":[1,1]}, "o": {"x":[0.4,0.4],"y":[0,0]}, "t": 20, "s": [150, 150] }, { "t": 40, "s": [150, 150] } ] }, "r": { "a": 0, "k": 0 }, "o": { "a": 0, "k": 100 }, "sk": { "a": 0, "k": 0 }, "sa": { "a": 0, "k": 0 } }
              ]}],
              "ip": 0, "op": 60, "st": 30, "bm": 0
            },
            { "ddd": 0, "ind": 2, "ty": 4, "nm": "ring1", "sr": 1,
              "ks": { "o": { "a": 0, "k": 100 }, "r": { "a": 0, "k": 0 }, "p": { "a": 0, "k": [100, 100, 0] }, "a": { "a": 0, "k": [0, 0, 0] }, "s": { "a": 0, "k": [100, 100, 100] } },
              "ao": 0,
              "shapes": [{ "ty": "gr", "nm": "ring", "it": [
                  { "ty": "el", "nm": "el", "p": { "a": 0, "k": [0, 0] }, "s": { "a": 0, "k": [130, 130] } },
                  { "ty": "st", "nm": "st", "c": { "a": 0, "k": [0.22, 0.741, 0.973, 1] }, "o": { "a": 1, "k": [ { "i": {"x":[0.6,0.6],"y":[1,1]}, "o": {"x":[0.4,0.4],"y":[0,0]}, "t": 0, "s": [90] }, { "i": {"x":[0.6,0.6],"y":[1,1]}, "o": {"x":[0.4,0.4],"y":[0,0]}, "t": 20, "s": [90] }, { "t": 40, "s": [0] } ] }, "w": { "a": 0, "k": 3 }, "lc": 2, "lj": 2, "ml": 4, "bm": 0, "d": [] },
                  { "ty": "tr", "nm": "tr", "p": { "a": 0, "k": [100, 100] }, "a": { "a": 0, "k": [0, 0] }, "s": { "a": 1, "k": [ { "i": {"x":[0.6,0.6],"y":[1,1]}, "o": {"x":[0.4,0.4],"y":[0,0]}, "t": 0, "s": [40, 40] }, { "i": {"x":[0.6,0.6],"y":[1,1]}, "o": {"x":[0.4,0.4],"y":[0,0]}, "t": 20, "s": [150, 150] }, { "t": 40, "s": [150, 150] } ] }, "r": { "a": 0, "k": 0 }, "o": { "a": 0, "k": 100 }, "sk": { "a": 0, "k": 0 }, "sa": { "a": 0, "k": 0 } }
              ]}],
              "ip": 0, "op": 60, "st": 0, "bm": 0
            },
            { "ddd": 0, "ind": 3, "ty": 4, "nm": "core", "sr": 1,
              "ks": { "o": { "a": 0, "k": 100 }, "r": { "a": 0, "k": 0 }, "p": { "a": 0, "k": [100, 100, 0] }, "a": { "a": 0, "k": [0, 0, 0] }, "s": { "a": 1, "k": [ { "i": {"x":[0.6,0.6],"y":[1,1]}, "o": {"x":[0.4,0.4],"y":[0,0]}, "t": 0, "s": [100, 100] }, { "i": {"x":[0.6,0.6],"y":[1,1]}, "o": {"x":[0.4,0.4],"y":[0,0]}, "t": 30, "s": [112, 112] }, { "t": 60, "s": [100, 100] } ] } },
              "ao": 0,
              "shapes": [{ "ty": "gr", "nm": "core", "it": [
                  { "ty": "el", "nm": "el", "p": { "a": 0, "k": [0, 0] }, "s": { "a": 0, "k": [64, 64] } },
                  { "ty": "fl", "nm": "fl", "c": { "a": 0, "k": [0.22, 0.741, 0.973, 1] }, "o": { "a": 0, "k": 100 }, "r": 1 },
                  { "ty": "tr", "nm": "tr", "p": { "a": 0, "k": [100, 100] }, "a": { "a": 0, "k": [0, 0] }, "s": { "a": 0, "k": [100, 100] }, "r": { "a": 0, "k": 0 }, "o": { "a": 0, "k": 100 }, "sk": { "a": 0, "k": 0 }, "sa": { "a": 0, "k": 0 } }
              ]}],
              "ip": 0, "op": 60, "st": 0, "bm": 0
            }
        ],
        "markers": []
    };

    function mountLottie(container, data) {
        if (!container || typeof lottie === 'undefined') return;
        try {
            lottie.loadAnimation({ container: container, renderer: 'svg', loop: true, autoplay: true, animationData: data });
        } catch (e) {}
    }
    function lottieReady(cb) {
        if (window.lottie) { cb(); return; }
        let tries = 0;
        const iv = setInterval(function () {
            if (window.lottie) { clearInterval(iv); cb(); }
            else if (++tries > 80) clearInterval(iv);
        }, 100);
    }
    function mountFabLottie() {
        if (reducedMotion) return;
        const box = document.getElementById('kurdai-lottie-fab');
        if (!box) return;
        if (window.kurdaiEnsureLottie) window.kurdaiEnsureLottie();
        lottieReady(function () { mountLottie(box, FAB_LOTTIE); });
    }

    function lang() { return localStorage.getItem('site-lang') === 'ba' ? 'ba' : 'so'; }
    function t(key) { return T[lang()][key] ?? T.so[key]; }

    let userKey = localStorage.getItem('kurdai_user_key');
    if (!userKey) {
        userKey = 'k-' + Date.now().toString(36) + '-' + Math.random().toString(36).slice(2, 10);
        localStorage.setItem('kurdai_user_key', userKey);
    }
    const userIdMeta = document.querySelector('meta[name="kurdai-user-id"]');
    const userId = userIdMeta && userIdMeta.content ? Number(userIdMeta.content) : null;

    let sessions = [], current = null, listMode = false, grammarMode = false, teachingMode = false,
        attachedFile = null, attachedImage = null, pyodideInstance = null;
    let tier = 'normal', proLimit = 5, proRemaining = 5;
    const tierBtn = document.getElementById('kurdai-tier');
    function updateTierUI() {
        if (tier === 'pro') {
            tierBtn.classList.add('pro-active');
            tierBtn.textContent = '👑 ' + t('tier_pro') + ' ' + proRemaining + '/' + proLimit;
            tierBtn.title = t('pro_remaining') + ' ' + proRemaining + '/' + proLimit;
        } else {
            tierBtn.classList.remove('pro-active');
            tierBtn.textContent = '⚡ ' + t('tier_normal');
            tierBtn.title = t('tier_hint');
        }
    }
    tierBtn.addEventListener('click', () => {
        if (tier === 'pro') {
            tier = 'normal';
        } else {
            if (proRemaining <= 0) {
                addMessage('bot', t('pro_remaining') + ' 0/' + proLimit);
                return;
            }
            tier = 'pro';
        }
        updateTierUI();
    });
    updateTierUI();

    function refreshUiTexts() {
        statusEl.textContent = listMode ? t('status_list') : t('status');
        input.placeholder = teachingMode ? t('teach_placeholder') : t('placeholder');
        searchInput.placeholder = t('search_ph');
    }

    async function api(path, opts = {}) {
        const res = await fetch(path, {
            method: opts.method || 'GET',
            headers: Object.assign({ Accept: 'application/json' }, firebaseIdToken ? { 'X-Firebase-Id-Token': firebaseIdToken } : {},
                ['POST', 'PUT', 'PATCH', 'DELETE'].includes(opts.method) ? { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': csrf } : {}),
            body: opts.body ? JSON.stringify(opts.body) : undefined,
        });
        let data = null;
        try { data = await res.json(); } catch (e) {}
        return { status: res.status, data };
    }

    async function saveConversationToFirebase(sessionId, userText, assistantText) {
        if (!firebaseDb || !firebaseUid || !userText || !assistantText) {
            console.warn('Firebase sync skipped: missing firebaseDb/firebaseUid or empty text');
            return;
        }
        try {
            const sessionIdKey = sessionId || ('local-' + Date.now());
            const conversationRef = dbRef(firebaseDb, 'chat_conversations/' + firebaseUid + '/' + sessionIdKey);
            const messageRef = push(conversationRef);
            await set(messageRef, {
                email: userEmail,
                session_id: sessionIdKey,
                user: userText,
                assistant: assistantText,
                lang: lang(),
                created_at: Date.now(),
            });
            console.log('Conversation saved to Firebase:', sessionIdKey);
        } catch (e) { console.error('Firebase save error:', e); }
    }

    function esc(text) {
        return String(text).replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/>/g, '&gt;');
    }

    function renderMarkdown(text) {
        let out = esc(text);
        /* protect code blocks first so inline rules and <br> never touch their content */
        const blocks = [];
        out = out.replace(/```(\w*)\n?([\s\S]*?)```/g, (_, lang, code) => {
            const token = '__KAI_CODE_' + blocks.length + '__';
            blocks.push(`<pre><code class="lang-${lang || 'text'}">${code}</code></pre>`);
            return token;
        });
        out = out.replace(/`([^`\n]+)`/g, '<code>$1</code>');
        out = out.replace(/\*\*([^*]+)\*\*/g, '<strong>$1</strong>');
        out = out.replace(/\n/g, '<br>');
        blocks.forEach((html, i) => { out = out.replace('__KAI_CODE_' + i + '__', html); });
        return out;
    }

    function nnLoaderHTML() {
        return '<svg class="nn-svg" viewBox="0 0 235 66" fill="none" aria-label="KURD AI neural network">' +
            '<path class="nn-grid" d="M8 10h219M8 33h219M8 56h219M30 4v58M78 4v58M126 4v58M174 4v58M222 4v58"/>' +
            '<path class="nn-flow" d="M12 48C38 12 55 53 79 29S111 14 126 33s31 30 47 5 32-24 50-26"/>' +
            '<path class="nn-flow" style="animation-delay:-.45s" d="M12 20c25 27 43 2 67 22s31 12 47-8 33-17 48 5 32 20 51 3"/>' +
            '<circle class="nn-ring" cx="126" cy="33" r="18"/><circle class="nn-ring" style="animation-direction:reverse;animation-duration:2.8s" cx="126" cy="33" r="10"/>' +
            '<circle class="nn-core" cx="126" cy="33" r="5"/>' +
            '</svg><span class="nn-caption">خەریکی شیکردنەوەم</span>';
    }

    function showTyping() {
        const el = document.createElement('div');
        el.className = 'chat-msg bot';
        const w = document.createElement('div'); w.className = 'chat-typing';
        const box = document.createElement('div'); box.className = 'nn-typing';
        box.innerHTML = nnLoaderHTML();
        w.appendChild(box); el.appendChild(w);
        messagesEl.appendChild(el); messagesEl.scrollTop = messagesEl.scrollHeight;
        return el;
    }

    async function typeEffect(content, text, speed = 22) {
        return new Promise(resolve => {
            let i = 0;
            const interval = setInterval(() => {
                if (i < text.length) { content.textContent += text[i]; i++; messagesEl.scrollTop = messagesEl.scrollHeight; }
                else { clearInterval(interval); content.innerHTML = renderMarkdown(text); resolve(); }
            }, speed);
        });
    }

    function addMessage(role, text, opts = {}) {
        const el = document.createElement('div');
        el.className = 'chat-msg ' + role;

        const content = document.createElement('div');
        content.className = 'msg-content';
        el.appendChild(content);

        if (opts.animate) {
            messagesEl.appendChild(el); messagesEl.scrollTop = messagesEl.scrollHeight;
            typeEffect(content, text);
        } else {
            content.innerHTML = renderMarkdown(text);
            messagesEl.appendChild(el); messagesEl.scrollTop = messagesEl.scrollHeight;
        }

        const actions = document.createElement('div');
        actions.className = 'chat-msg-actions';

        if (role === 'user') {
            if (opts.image) { const img = document.createElement('img'); img.className = 'user-img'; img.src = opts.image; el.appendChild(img); }
            if (opts.fileName) { const ft = document.createElement('div'); ft.style.cssText = 'font-size:11px;color:var(--kw-b5);margin-top:6px;opacity:0.8;'; ft.textContent = t('file_attached') + opts.fileName; el.appendChild(ft); }
        }

        if (role === 'bot') {
            attachRunButtons(el);
        }

        el.appendChild(actions);
        messagesEl.scrollTop = messagesEl.scrollHeight;
        return el;
    }

    function attachRunButtons(el) {
        const actions = el.querySelector('.chat-msg-actions');
        const codeBlock = el.querySelector('pre code');
        if (!actions || !codeBlock || el.querySelector('.run-btn')) return;
        const runBtn = document.createElement('button');
        runBtn.className = 'run-btn'; runBtn.innerHTML = t('run');
        runBtn.addEventListener('click', () => runCode(codeBlock, runBtn));
        actions.appendChild(runBtn);
    }

    async function runCode(codeBlock, runBtn) {
        const langMatch = (codeBlock.className.match(/lang-(\w+)/) || [])[1] || 'python';
        const code = codeBlock.textContent;
        runBtn.disabled = true;
        runBtn.innerHTML = '⏳ ...';

        try {
            if (langMatch === 'python') {
                if (!pyodideInstance) pyodideInstance = await loadPyodide();
                await pyodideInstance.runPython("import sys\nfrom io import StringIO\nsys.stdout = StringIO()");
                await pyodideInstance.runPythonAsync(code);
                const output = pyodideInstance.runPython("sys.stdout.getvalue()");
                runBtn.innerHTML = '✅ سەرکەوتوو';
                const pre = document.createElement('pre');
                pre.style.cssText = 'margin:8px 0;padding:12px;background:#000;border:1px solid #34d399;color:#34d399;border-radius:10px;font-size:13px;direction:ltr;text-align:left;white-space:pre-wrap;';
                pre.textContent = output || '(بەدۆنەداوە)';
                codeBlock.closest('.chat-msg').appendChild(pre);
            } else if (langMatch === 'cpp' || langMatch === 'c') {
                const res = await fetch('https://godbolt.org/api/compiler/g142/compile', {
                    method: 'POST', headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify({ source: code, options: { compilerOptions: { executorRequest: false }, filters: { labels: false, directives: false } } }),
                });
                const data = await res.json();
                const output = data.stdout?.map(l => l.text).join('\n') || data.stderr?.map(l => l.text).join('\n') || 'هیچ ئەنجامێک نییە';
                runBtn.innerHTML = '✅ Done';
                const pre = document.createElement('pre');
                pre.style.cssText = 'margin:8px 0;padding:12px;background:#000;border:1px solid #34d399;color:#34d399;border-radius:10px;font-size:13px;direction:ltr;text-align:left;white-space:pre-wrap;';
                pre.textContent = output;
                codeBlock.closest('.chat-msg').appendChild(pre);
            } else { runBtn.innerHTML = '⚠️ ' + langMatch + ' نا'; }
        } catch (e) { runBtn.innerHTML = '❌ هەڵە'; }
        finally { setTimeout(() => { runBtn.disabled = false; }, 2000); }
    }

    function renderSessions() {
        listEl.innerHTML = '';
        listEl.classList.toggle('empty', sessions.length === 0);
        listEl.dataset.emptyText = t('empty');
        if (!sessions.length) return;
        const ordered = [...sessions].sort((a, b) => (b.pinned - a.pinned) || (b.updated_at > a.updated_at ? 1 : -1));
        ordered.filter(s => !searchQuery || (s.title || '').toLowerCase().includes(searchQuery.toLowerCase())).forEach(s => {
            const row = document.createElement('div');
            row.className = 'session-row' + (current?.id === s.id ? ' active' : '');
            const pin = document.createElement('button');
            pin.className = 's-pin' + (s.pinned ? ' pinned' : '');
            if (s.firebase) pin.style.display = 'none';
            pin.innerHTML = '<svg fill="' + (s.pinned ? 'currentColor' : 'none') + '" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15 4l1.414 1.414a2 2 0 010 2.828L15 9.657 14.343 9 8.828 14.515 6 18l3.485-2.828L15 9.657 14.343 9l1.657-1.657a2 2 0 012.828 0zM4 20l2-4"/></svg>';
            pin.addEventListener('click', async (e) => {
                e.stopPropagation();
                const r = await api('/api/chat/sessions/' + s.id + '/pin', { method: 'POST', body: { user_key: userKey } });
                if (r.status === 200) { s.pinned = r.data.pinned; renderSessions(); }
            });
            const del = document.createElement('button');
            del.className = 's-del';
            del.innerHTML = '<svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>';
            del.addEventListener('click', async (e) => {
                e.stopPropagation();
                if (!confirm(t('delete_confirm'))) return;
                if (s.firebase && firebaseDb && firebaseUid) {
                    try {
                        await remove(dbRef(firebaseDb, 'chat_conversations/' + firebaseUid + '/' + s.id));
                    } catch (err) { console.error('Firebase delete error:', err); }
                    sessions = sessions.filter(x => String(x.id) !== String(s.id));
                    if (current && String(current.id) === String(s.id)) { current = null; messagesEl.innerHTML = ''; addMessage('bot', t('welcome')); }
                    renderSessions();
                    return;
                }
                const r = await api('/api/chat/sessions/' + s.id + '?user_key=' + encodeURIComponent(userKey), { method: 'DELETE' });
                if (r.status === 200) {
                    sessions = sessions.filter(x => x.id !== s.id);
                    if (current?.id === s.id) { current = null; messagesEl.innerHTML = ''; addMessage('bot', t('welcome')); }
                    renderSessions();
                }
            });
            const titleWrap = document.createElement('div');
            titleWrap.style.cssText = 'flex:1;min-width:0;';
            const title = document.createElement('div'); title.className = 's-title'; title.textContent = s.title || t('untitled');
            const meta = document.createElement('div'); meta.className = 's-meta';
            meta.textContent = (s.pinned ? '📌 ' : '') + s.updated_at + (current?.id === s.id ? ' • ' + t('now') : '');
            titleWrap.appendChild(title); titleWrap.appendChild(meta);
            row.appendChild(titleWrap); row.appendChild(pin); row.appendChild(del);
            row.addEventListener('click', () => openSession(s.id));
            listEl.appendChild(row);
        });
    }

    async function loadFirebaseSessions() {
        if (!firebaseDb || !firebaseUid) {
            console.warn('loadFirebaseSessions: firebaseDb/firebaseUid not ready');
            return [];
        }
        try {
            const snapshot = await get(dbRef(firebaseDb, 'chat_conversations/' + firebaseUid));
            const values = snapshot.val() || {};
            return Object.entries(values).map(([id, messages]) => {
                const rows = Object.values(messages || {}).sort((a, b) => (a.created_at || 0) - (b.created_at || 0));
                const first = rows[0] || {};
                const last = rows[rows.length - 1] || first;
                return {
                    id,
                    title: String(first.user || '').slice(0, 50) || t('untitled'),
                    pinned: false,
                    firebase: true,
                    updated_at: last.created_at ? new Date(last.created_at).toLocaleString() : ''
                };
            }).sort((a, b) => (b.updated_at || '').localeCompare(a.updated_at || ''));
        } catch (e) { console.error('loadFirebaseSessions error:', e); return []; }
    }

    async function loadSessions() {
        const settled = await Promise.race([identityReady.then(() => true), new Promise(resolve => setTimeout(() => resolve(false), 1500))]);
        const firebaseSessions = await loadFirebaseSessions();
        let mysqlSessions = [];
        try {
            const r = await api('/api/chat/sessions?user_key=' + encodeURIComponent(userKey) + '&user_email=' + encodeURIComponent(userEmail));
            if (r.status === 200 && Array.isArray(r.data)) mysqlSessions = r.data;
        } catch (e) {}
        sessions = [...mysqlSessions, ...firebaseSessions.filter(fs => !mysqlSessions.some(ms => String(ms.id) === String(fs.id)))];
        if (listMode) renderSessions();
        if (!settled) identityReady.then(() => { if (listMode) loadSessions(); });
    }

    async function openSession(id) {
        const firebaseSession = sessions.find(session => String(session.id) === String(id) && session.firebase);
        if (firebaseSession && firebaseDb && firebaseUid) {
            try {
                const snapshot = await get(dbRef(firebaseDb, 'chat_conversations/' + firebaseUid + '/' + id));
                const values = Object.values(snapshot.val() || {}).sort((a, b) => (a.created_at || 0) - (b.created_at || 0));
                current = { id, title: firebaseSession.title, pinned: false };
                messagesEl.innerHTML = '';
                values.forEach(item => { if (item.user) addMessage('user', item.user); if (item.assistant) addMessage('bot', item.assistant); });
                listMode = false; setView();
            } catch (e) {}
            return;
        }
        const r = await api('/api/chat/sessions/' + id + '/messages?user_key=' + encodeURIComponent(userKey) + '&user_email=' + encodeURIComponent(userEmail));
        if (r.status !== 200) return;
        const data = r.data;
        current = { id: data.id, title: data.title, pinned: data.pinned };
        messagesEl.innerHTML = '';
        if (!data.messages?.length) addMessage('bot', t('welcome'));
        else { data.messages.forEach(msg => addMessage(msg.role === 'user' ? 'user' : 'bot', msg.content, { messageId: msg.id, reaction: msg.reaction, time: msg.created_at })); }
        listMode = false; setView();
    }

    function newSession() {
        current = null; messagesEl.innerHTML = '';
        addMessage('bot', t('welcome'));
        listMode = false; setView(); input.focus();
    }

    async function sendMessage() {
        await Promise.race([identityReady, new Promise(resolve => setTimeout(resolve, 150))]);
        const message = input.value.trim();
        if (!message && !attachedImage && !attachedFile) return;
        if (sendBtn.disabled) return;

        addMessage('user', message || (attachedFile ? t('file_attached') + attachedFile.name : '(وێنە)'), { image: attachedImage, fileName: attachedFile?.name });
        const typing = showTyping();
        sendBtn.disabled = true;

        const waitHint = document.createElement('div');
        waitHint.className = 'chat-wait-hint';
        waitHint.textContent = t('wait_hint');
        messagesEl.appendChild(waitHint);
        const waitTimer = setTimeout(() => { waitHint.style.display = 'block'; messagesEl.scrollTop = messagesEl.scrollHeight; }, 15000);

        function clearWait() { clearTimeout(waitTimer); waitHint.remove(); }

        const body = {
            message: message || 'وەڵام بە ئەم وێنەیەدا بدە', user_email: userEmail,
            user_key: userKey, user_id: userId, session_id: current?.id || null,
            lang: lang(), mode: teachingMode ? 'teach' : (grammarMode ? 'grammar' : 'default'),
            tier: tier,
        };
        if (attachedImage) body.image = attachedImage;
        if (attachedFile) { body.file_name = attachedFile.name; body.file_content = attachedFile.content; }

        let result = null;
        try {
            result = await streamChat(body, typing, clearWait);
        } catch (e) {
            typing.remove(); clearWait();
            addMessage('bot', t('network_error'));
            result = { ok: false };
        } finally {
            sendBtn.disabled = false;
            attachedFile = null; attachedImage = null;
            previewEl.style.display = 'none'; previewEl.textContent = '';
            input.value = ''; autosizeInput();
        }

        if (result?.is_admin) setAdmin(true);
        const sessionId = result?.session_id || current?.id || null;
        if (result?.session_id) { current = { id: result.session_id, title: message?.slice(0, 60) || t('untitled'), pinned: false }; }
        if (result?.reply) {
            saveConversationToFirebase(sessionId || ('local-' + Date.now()), message, result.reply);
            if (!current && !result?.session_id) current = { id: 'local-' + Date.now(), title: message?.slice(0, 60) || t('untitled'), pinned: false };
        }
        loadSessions();
    }

    async function streamChat(body, typing, clearWait) {
        let res;
        try {
            res = await fetch('/api/chat/stream', {
                method: 'POST',
                headers: Object.assign({ 'Accept': 'text/event-stream', 'Content-Type': 'application/json', 'X-CSRF-TOKEN': csrf }, firebaseIdToken ? { 'X-Firebase-Id-Token': firebaseIdToken } : {}),
                body: JSON.stringify(body),
            });
        } catch (e) {
            typing.remove(); clearWait();
            addMessage('bot', t('network_error'));
            return { ok: false };
        }

        const ctype = res.headers.get('content-type') || '';

        if (!res.ok) {
            typing.remove(); clearWait();
            let data = null;
            try { data = await res.json(); } catch (e) {}
            if (data && typeof data.pro_remaining === 'number') { proRemaining = data.pro_remaining; if (proRemaining <= 0 && tier === 'pro') tier = 'normal'; updateTierUI(); }
            addMessage('bot', data?.reply || data?.error || data?.message || t('network_error'));
            return { ok: false };
        }

        if (!ctype.includes('text/event-stream')) {
            typing.remove(); clearWait();
            let data = null;
            try { data = await res.json(); } catch (e) {}
            addMessage('bot', data?.reply || t('network_error'), { animate: true });
            return { ok: true, session_id: data?.session_id, is_admin: data?.is_admin, reply: data?.reply || '' };
        }

        let buffer = '';
        let botEl = null, contentEl = null;
        let session_id = null, is_admin = null, streamError = false, rendered = false, replyText = '';

        function ensureBotEl() {
            if (!botEl) {
                typing.remove(); clearWait();
                botEl = addMessage('bot', '');
                contentEl = botEl.querySelector('.msg-content');
            }
            return botEl;
        }

        function handleRaw(raw) {
            let event = 'message', data = '';
            raw.split('\n').forEach(line => {
                if (line.startsWith('event:')) event = line.slice(6).trim();
                else if (line.startsWith('data:')) data += line.slice(5).trim();
            });
            if (data === '') return;
            let obj;
            try { obj = JSON.parse(data); } catch (e) { return; }

            if (event === 'meta') {
                if (obj.session_id) session_id = obj.session_id;
                if (typeof obj.is_admin === 'boolean') is_admin = obj.is_admin;
            } else if (event === 'delta') {
                ensureBotEl();
                contentEl.textContent += obj.text || '';
                messagesEl.scrollTop = messagesEl.scrollHeight;
            } else if (event === 'done') {
                ensureBotEl();
                replyText = obj.reply || contentEl.textContent || '';
                contentEl.innerHTML = renderMarkdown(replyText);
                attachRunButtons(botEl);
                rendered = true;
                if (obj.session_id) session_id = obj.session_id;
                if (typeof obj.is_admin === 'boolean') is_admin = obj.is_admin;
                if (typeof obj.pro_remaining === 'number') { proRemaining = obj.pro_remaining; updateTierUI(); }
                messagesEl.scrollTop = messagesEl.scrollHeight;
            } else if (event === 'error') {
                ensureBotEl();
                contentEl.innerHTML = renderMarkdown(obj.reply || t('network_error'));
                streamError = true;
                messagesEl.scrollTop = messagesEl.scrollHeight;
            }
        }

        const reader = res.body.getReader();
        const decoder = new TextDecoder();
        while (true) {
            const { done, value } = await reader.read();
            if (done) break;
            buffer += decoder.decode(value, { stream: true });
            let idx;
            while ((idx = buffer.indexOf('\n\n')) !== -1) {
                const raw = buffer.slice(0, idx);
                buffer = buffer.slice(idx + 2);
                if (raw.trim() !== '') handleRaw(raw);
            }
        }
        if (buffer.trim() !== '') handleRaw(buffer);

        if (!botEl) {
            typing.remove(); clearWait();
            addMessage('bot', t('network_error'));
            return { ok: false };
        }
        if (streamError) return { ok: false, is_admin, session_id };

        if (contentEl && !rendered) {
            contentEl.innerHTML = renderMarkdown(contentEl.textContent);
            attachRunButtons(botEl);
            messagesEl.scrollTop = messagesEl.scrollHeight;
        }

        return { ok: true, session_id, is_admin, reply: replyText || contentEl?.textContent || '' };
    }

    function setView() {
        listEl.style.display = listMode ? 'flex' : 'none';
        messagesEl.style.display = listMode ? 'none' : 'flex';
        toolBar.style.display = listMode ? 'none' : 'flex';
        document.getElementById('kurdai-input-bar').style.display = listMode ? 'none' : 'flex';
        document.getElementById('kurdai-search-wrap').style.display = listMode ? 'flex' : 'none';
        refreshUiTexts();
        if (listMode) renderSessions();
        else messagesEl.scrollTop = messagesEl.scrollHeight;
    }

    function updateScrollBtn() {
        const nearBottom = messagesEl.scrollHeight - messagesEl.scrollTop - messagesEl.clientHeight < 200;
        scrollDownBtn.classList.toggle('show', !nearBottom && messagesEl.scrollHeight > messagesEl.clientHeight + 200);
    }

    function togglePanel() {
        if (panel.classList.contains('open')) { closePanel(); return; }
        openPanel();
    }

    btn.addEventListener('keydown', e => {
        if (e.key === 'Enter' || e.key === ' ') { e.preventDefault(); togglePanel(); }
    });
    closeBtn.addEventListener('click', closePanel);
    backdrop.addEventListener('click', closePanel);
    adminBtn?.addEventListener('click', () => {
        teachingMode = !teachingMode;
        adminBtn.classList.toggle('teaching-active', teachingMode);
        statusEl.textContent = teachingMode ? 'مۆدی فێرکردن چالاکە' : t('status');
        refreshUiTexts();
        input.focus();
    });
    analyticsBtn?.addEventListener('click', () => window.open('/admin/chat-analytics', '_blank'));
    document.addEventListener('keydown', e => {
        if (e.key === 'Escape' && panel.classList.contains('open')) closePanel();
    });

    searchInput.addEventListener('input', () => {
        searchQuery = searchInput.value.trim();
        renderSessions();
    });

    messagesEl.addEventListener('scroll', updateScrollBtn);
    scrollDownBtn.addEventListener('click', () => messagesEl.scrollTo({ top: messagesEl.scrollHeight, behavior: 'smooth' }));

    let dragState = null;
    btn.addEventListener('pointerdown', e => {
        if (e.button !== 0) return;
        e.preventDefault();
        const rect = btn.getBoundingClientRect();
        dragState = { sx: e.clientX, sy: e.clientY, bx: rect.left, by: rect.top, moved: false };
        btn.classList.add('dragging');
    });
    document.addEventListener('pointermove', e => {
        if (!dragState) return;
        const dx = e.clientX - dragState.sx, dy = e.clientY - dragState.sy;
        if (!dragState.moved && (Math.abs(dx) > 4 || Math.abs(dy) > 4)) dragState.moved = true;
        if (!dragState.moved) return;
        const size = btn.offsetWidth;
        const x = Math.min(Math.max(dragState.bx + dx, 10), window.innerWidth - size - 10);
        const y = Math.min(Math.max(dragState.by + dy, 10), window.innerHeight - size - 10);
        btn.style.left = x + 'px';
        btn.style.top = y + 'px';
        btn.style.right = 'auto';
        btn.style.bottom = 'auto';
        localStorage.setItem('kurdai_btn_pos', JSON.stringify({ x, y }));
    });
    document.addEventListener('pointerup', () => {
        if (!dragState) return;
        const wasMoved = dragState.moved;
        dragState = null;
        btn.classList.remove('dragging');
        if (wasMoved) {
            btn.classList.add('just-dragged');
            setTimeout(() => btn.classList.remove('just-dragged'), 60);
        } else {
            togglePanel();
        }
    });
    try {
        const saved = JSON.parse(localStorage.getItem('kurdai_btn_pos') || 'null');
        if (saved && window.innerWidth > 640) {
            const size = btn.offsetWidth;
            btn.style.left = Math.min(Math.max(parseInt(saved.x), 10), window.innerWidth - size - 10) + 'px';
            btn.style.top = Math.min(Math.max(parseInt(saved.y), 10), window.innerHeight - size - 10) + 'px';
            btn.style.right = 'auto';
            btn.style.bottom = 'auto';
        }
    } catch (e) {}

    const panelHeader = document.getElementById('kurdai-chat-header');
    let panelDrag = null;
    panelHeader.addEventListener('pointerdown', e => {
        if (e.button !== 0 || e.target.closest('button')) return;
        if (panel.classList.contains('fullscreen') || window.innerWidth <= 640) return;
        e.preventDefault();
        const r = panel.getBoundingClientRect();
        panelDrag = { sx: e.clientX, sy: e.clientY, px: r.left, py: r.top, moved: false };
        panel.classList.add('dragging');
    });
    document.addEventListener('pointermove', e => {
        if (!panelDrag) return;
        const dx = e.clientX - panelDrag.sx, dy = e.clientY - panelDrag.sy;
        if (!panelDrag.moved && (Math.abs(dx) > 4 || Math.abs(dy) > 4)) panelDrag.moved = true;
        if (!panelDrag.moved) return;
        const pw = panel.offsetWidth, ph = panel.offsetHeight;
        const x = Math.min(Math.max(panelDrag.px + dx, -pw + 90), window.innerWidth - 90);
        const y = Math.min(Math.max(panelDrag.py + dy, 8), window.innerHeight - 60);
        panel.style.left = x + 'px';
        panel.style.top = y + 'px';
        panel.style.right = 'auto';
        panel.style.bottom = 'auto';
    });
    document.addEventListener('pointerup', () => {
        if (!panelDrag) return;
        panelDrag = null;
        panel.classList.remove('dragging');
    });

    sessionsToggle.addEventListener('click', () => { listMode = !listMode; setView(); });
    newSessionBtn.addEventListener('click', newSession);
    sendBtn.addEventListener('click', sendMessage);
    input.addEventListener('input', autosizeInput);
    input.addEventListener('keydown', e => { if (e.key === 'Enter' && !e.shiftKey) { e.preventDefault(); sendMessage(); } });

    fileBtn.addEventListener('click', () => {
        const inp = document.createElement('input'); inp.type = 'file';
        inp.accept = '.txt,.md,.php,.py,.js,.html,.css,.json,.xml,.java,.cpp,.c,.rs,.go,.rb,.sh,.sql,.vue,.jsx,.tsx,.swift,.kt,.ts,.dart';
        inp.onchange = e => {
            const file = e.target.files[0]; if (!file) return;
            const reader = new FileReader();
            reader.onload = ev => { attachedFile = { name: file.name, content: ev.target.result }; previewEl.style.display = 'block'; previewEl.textContent = '📎 ' + file.name + ' (' + Math.round(file.size / 1024) + 'KB)'; };
            reader.readAsText(file);
        };
        inp.click();
    });

    imageBtn.addEventListener('click', () => {
        const inp = document.createElement('input'); inp.type = 'file'; inp.accept = 'image/*';
        inp.onchange = e => {
            const file = e.target.files[0]; if (!file) return;
            const reader = new FileReader();
            reader.onload = ev => { attachedImage = ev.target.result; previewEl.style.display = 'block'; previewEl.innerHTML = '<img src="' + ev.target.result + '" style="max-height:80px;border-radius:8px;">'; };
            reader.readAsDataURL(file);
        };
        inp.click();
    });

    mountFabLottie();

    window.kurdaiOpenChat = openPanel;
    window.kurdaiCloseChat = closePanel;

    const greet = document.createElement('div');
    greet.id = 'kurdai-greet';
    greet.innerHTML = t('greet') + '<span class="g-x">✕</span>';
    document.body.appendChild(greet);

    setTimeout(() => {
        if (!panel.classList.contains('open') && !localStorage.getItem('kurdai_greet_done')) {
            greet.style.display = 'block';
        }
    }, 3000);

    greet.querySelector('.g-x').addEventListener('click', (e) => {
        e.stopPropagation();
        greet.style.display = 'none';
        localStorage.setItem('kurdai_greet_done', '1');
    });
    greet.addEventListener('click', () => {
        greet.style.display = 'none';
        localStorage.setItem('kurdai_greet_done', '1');
        openPanel();
    });
})();
    })();
    return kurdaiBootPromise;
}

/* Boot the chat once: on first hover/tap of the launcher, or after the page
   is idle. The widget root survives SPA swaps, so this runs once per page. */
(function () {
    if (window.__kurdaiChatBootStarted) return;
    window.__kurdaiChatBootStarted = true;

    var btn = document.getElementById('kurdai-chat-btn');
    if (!btn) return;

    var boot = function () { kurdaiBootChat().catch(function () {}); };

    btn.addEventListener('pointerenter', boot, { once: true, passive: true });
    btn.addEventListener('pointerdown', boot, { once: true, passive: true });

    /* CTA buttons (e.g. hero) call kurdaiOpenChat. If the chat has not booted
       yet, start it and open once the (re)defined handler is in place. */
    window.kurdaiOpenChat = function () {
        boot();
        kurdaiBootChat().then(function () {
            if (typeof window.kurdaiOpenChat === 'function') window.kurdaiOpenChat();
        });
    };

    var later = function () {
        if (typeof requestIdleCallback === 'function') requestIdleCallback(boot, { timeout: 2500 });
        else setTimeout(boot, 2000);
    };
    if (document.readyState === 'complete') later();
    else window.addEventListener('load', later, { once: true });
})();
</script>
