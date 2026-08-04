<!-- ===== چاتبۆتی یاریدەدەری AI (Kurd AI) ===== -->
<meta name="csrf-token" content="{{ csrf_token() }}">

<style>
    #kurdai-chat-btn {
        position: fixed;
        bottom: 24px;
        right: 24px;
        z-index: 9998;
        width: 60px;
        height: 60px;
        border-radius: 50%;
        background: linear-gradient(135deg, #3b82f6, #06b6d4);
        border: none;
        cursor: pointer;
        box-shadow: 0 8px 24px rgba(59, 130, 246, 0.45);
        display: flex;
        align-items: center;
        justify-content: center;
        transition: transform 0.3s, box-shadow 0.3s;
    }
    #kurdai-chat-btn:hover { transform: scale(1.08); box-shadow: 0 12px 32px rgba(59, 130, 246, 0.6); }
    #kurdai-chat-btn svg { width: 30px; height: 30px; color: #fff; }
    #kurdai-chat-panel {
        position: fixed;
        bottom: 96px;
        right: 24px;
        z-index: 9999;
        width: min(380px, calc(100vw - 48px));
        height: min(560px, calc(100vh - 140px));
        display: flex;
        flex-direction: column;
        border-radius: 24px;
        overflow: hidden;
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(16px);
        border: 1px solid rgba(255, 255, 255, 0.3);
        box-shadow: 0 20px 60px rgba(0, 0, 0, 0.25);
        opacity: 0;
        transform: translateY(20px) scale(0.95);
        pointer-events: none;
        transition: all 0.3s ease;
    }
    #kurdai-chat-panel.open { opacity: 1; transform: translateY(0) scale(1); pointer-events: auto; }
    .dark #kurdai-chat-panel { background: rgba(17, 24, 39, 0.97); border-color: rgba(55, 65, 81, 0.5); }
    #kurdai-chat-header {
        background: linear-gradient(135deg, #2563eb, #0891b2);
        color: #fff;
        padding: 14px 16px;
        display: flex;
        align-items: center;
        gap: 10px;
        flex-shrink: 0;
    }
    #kurdai-chat-header .avatar {
        width: 38px; height: 38px;
        background: rgba(255, 255, 255, 0.2);
        border-radius: 50%;
        display: flex; align-items: center; justify-content: center;
        font-weight: 900; font-size: 17px;
        flex-shrink: 0;
    }
    #kurdai-chat-header .hdr-title { min-width: 0; flex: 1; }
    #kurdai-chat-header h4 { font-size: 14.5px; font-weight: 900; margin: 0; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
    #kurdai-chat-header span { font-size: 10.5px; opacity: 0.9; display: block; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
    .hdr-btn {
        background: rgba(255,255,255,0.15);
        border: none; color: #fff;
        width: 30px; height: 30px; border-radius: 10px;
        cursor: pointer; font-size: 15px;
        display: flex; align-items: center; justify-content: center;
        flex-shrink: 0;
        transition: background 0.2s, transform 0.2s;
    }
    .hdr-btn:hover { background: rgba(255,255,255,0.3); transform: scale(1.06); }
    .hdr-btn svg { width: 15px; height: 15px; }
    #kurdai-chat-body { flex: 1; display: flex; flex-direction: column; min-height: 0; }
    #kurdai-chat-messages {
        flex: 1;
        overflow-y: auto;
        padding: 18px 14px;
        display: flex;
        flex-direction: column;
        gap: 12px;
        background: #f8fafc;
    }
    .dark #kurdai-chat-messages { background: #111827; }
    #kurdai-chat-messages::-webkit-scrollbar, #kurdai-session-list::-webkit-scrollbar { width: 5px; }
    #kurdai-chat-messages::-webkit-scrollbar-thumb, #kurdai-session-list::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 10px; }
    .dark #kurdai-chat-messages::-webkit-scrollbar-thumb, .dark #kurdai-session-list::-webkit-scrollbar-thumb { background: #475569; }
    .chat-msg {
        max-width: 85%;
        padding: 10px 14px;
        border-radius: 16px;
        font-size: 13.5px;
        line-height: 1.7;
        white-space: pre-wrap;
        word-break: break-word;
        animation: chatFadeIn 0.25s ease;
    }
    @keyframes chatFadeIn { from { opacity: 0; transform: translateY(6px); } to { opacity: 1; transform: translateY(0); } }
    .chat-msg.user {
        align-self: flex-start;
        background: linear-gradient(135deg, #3b82f6, #06b6d4);
        color: #fff;
        border-bottom-left-radius: 6px;
    }
    .chat-msg.bot {
        align-self: flex-end;
        background: #e2e8f0;
        color: #1e293b;
        border-bottom-right-radius: 6px;
    }
    .dark .chat-msg.bot { background: #1f2937; color: #e5e7eb; }
    .chat-msg.bot code {
        background: rgba(0,0,0,0.1);
        padding: 2px 6px; border-radius: 6px;
        font-size: 12px;
        direction: ltr;
        display: inline-block;
    }
    .dark .chat-msg.bot code { background: rgba(255,255,255,0.1); }
    .chat-msg.bot pre {
        direction: ltr;
        text-align: left;
        background: #0f172a;
        color: #e2e8f0;
        padding: 12px;
        border-radius: 10px;
        overflow-x: auto;
        font-size: 12px;
        margin: 8px 0;
    }
    .dark .chat-msg.bot pre { background: #0b1220; }
    .chat-typing { display: flex; gap: 5px; align-items: center; padding: 8px 4px; }
    .chat-typing span {
        width: 8px; height: 8px; border-radius: 50%;
        background: #94a3b8;
        animation: chatTyping 1s infinite ease-in-out;
    }
    .chat-typing span:nth-child(2) { animation-delay: 0.15s; }
    .chat-typing span:nth-child(3) { animation-delay: 0.3s; }
    @keyframes chatTyping { 0%, 60%, 100% { transform: translateY(0); opacity: 0.4; } 30% { transform: translateY(-5px); opacity: 1; } }
    #kurdai-chat-input-wrap {
        display: flex;
        gap: 8px;
        padding: 12px;
        background: #fff;
        border-top: 1px solid rgba(0,0,0,0.06);
        flex-shrink: 0;
    }
    .dark #kurdai-chat-input-wrap { background: #111827; border-color: rgba(255,255,255,0.08); }
    #kurdai-chat-input {
        flex: 1;
        border: 1px solid #e2e8f0;
        border-radius: 14px;
        padding: 10px 14px;
        font-size: 13.5px;
        background: #f8fafc;
        color: inherit;
        outline: none;
        transition: border-color 0.2s;
        min-width: 0;
    }
    .dark #kurdai-chat-input { background: #1f2937; border-color: #374151; }
    #kurdai-chat-input:focus { border-color: #3b82f6; }
    #kurdai-chat-send {
        width: 44px; height: 44px;
        border: none;
        border-radius: 14px;
        background: linear-gradient(135deg, #3b82f6, #06b6d4);
        color: #fff;
        cursor: pointer;
        display: flex; align-items: center; justify-content: center;
        transition: transform 0.2s, opacity 0.2s;
        flex-shrink: 0;
    }
    #kurdai-chat-send:hover { transform: scale(1.05); }
    #kurdai-chat-send:disabled { opacity: 0.5; cursor: not-allowed; transform: none; }
    #kurdai-chat-send svg { width: 20px; height: 20px; }
    #kurdai-session-list {
        flex: 1;
        overflow-y: auto;
        padding: 12px 10px;
        display: flex;
        flex-direction: column;
        gap: 8px;
        background: #f8fafc;
    }
    .dark #kurdai-session-list { background: #111827; }
    #kurdai-session-list.empty::after {
        content: attr(data-empty-text);
        display: block;
        text-align: center;
        color: #94a3b8;
        font-size: 13px;
        padding: 40px 10px;
    }
    .session-row {
        display: flex;
        align-items: center;
        gap: 8px;
        padding: 10px 12px;
        border-radius: 14px;
        background: #fff;
        border: 1px solid #e2e8f0;
        cursor: pointer;
        transition: all 0.2s;
    }
    .dark .session-row { background: #1f2937; border-color: #374151; }
    .session-row:hover { border-color: #3b82f6; transform: translateY(-1px); }
    .session-row.active { border-color: #3b82f6; box-shadow: 0 0 0 2px rgba(59,130,246,0.15); }
    .session-row .s-title {
        flex: 1;
        min-width: 0;
        font-size: 13px;
        font-weight: 700;
        color: #1e293b;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }
    .dark .session-row .s-title { color: #e5e7eb; }
    .session-row .s-meta { font-size: 10.5px; color: #94a3b8; margin-top: 2px; }
    .session-row .s-pin, .session-row .s-del {
        background: none;
        border: none;
        cursor: pointer;
        padding: 4px;
        border-radius: 8px;
        color: #94a3b8;
        display: flex; align-items: center; justify-content: center;
        transition: all 0.2s;
        flex-shrink: 0;
    }
    .session-row .s-pin svg, .session-row .s-del svg { width: 15px; height: 15px; }
    .session-row .s-pin:hover { color: #f59e0b; background: rgba(245,158,11,0.1); }
    .session-row .s-pin.pinned { color: #f59e0b; }
    .session-row .s-del:hover { color: #ef4444; background: rgba(239,68,68,0.1); }
    #kurdai-session-empty {
        flex: 1;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        gap: 10px;
        color: #94a3b8;
        font-size: 13.5px;
        text-align: center;
        padding: 20px;
    }
    .chat-welcome {
        background: linear-gradient(135deg, #eff6ff, #ecfeff);
        border: 1px dashed #93c5fd;
        border-radius: 16px;
        padding: 14px;
        font-size: 13px;
        line-height: 1.8;
        color: #1e40af;
    }
    .dark .chat-welcome { background: rgba(30,58,138,0.15); border-color: #1d4ed8; color: #93c5fd; }
</style>

<button id="kurdai-chat-btn" aria-label="چاتبۆتی کورد ئەی ئای">
    <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"/>
    </svg>
</button>

<div id="kurdai-chat-panel">
    <div id="kurdai-chat-header">
        <div class="avatar">K</div>
        <div class="hdr-title">
            <h4>یاریدەدەری کورد ئەی ئای</h4>
            <span id="kurdai-status">بەردەستە - بە کوردی پرسیار بکە</span>
        </div>
        <button id="kurdai-sessions-toggle" class="hdr-btn" title="گفتوگۆکان" aria-label="گفتوگۆکان">
            <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h10"/>
            </svg>
        </button>
        <button id="kurdai-new-session" class="hdr-btn" title="گفتوگۆی نوێ" aria-label="گفتوگۆی نوێ">
            <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/>
            </svg>
        </button>
        <button id="kurdai-chat-close" class="hdr-btn" title="داخستن" aria-label="داخستن">
            <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
            </svg>
        </button>
    </div>

    <div id="kurdai-chat-body">
        <div id="kurdai-session-list" style="display:none;"></div>
        <div id="kurdai-chat-messages"></div>
        <div id="kurdai-chat-input-wrap">
            <input id="kurdai-chat-input" type="text" placeholder="پرسیارەکەت لێرە بنووسە..." autocomplete="off">
            <button id="kurdai-chat-send" aria-label="ناردن">
                <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/>
                </svg>
            </button>
        </div>
    </div>
</div>

<script>
(function () {
    const btn = document.getElementById('kurdai-chat-btn');
    const panel = document.getElementById('kurdai-chat-panel');
    const closeBtn = document.getElementById('kurdai-chat-close');
    const sessionsToggle = document.getElementById('kurdai-sessions-toggle');
    const newSessionBtn = document.getElementById('kurdai-new-session');
    const body = document.getElementById('kurdai-chat-body');
    const messagesEl = document.getElementById('kurdai-chat-messages');
    const listEl = document.getElementById('kurdai-session-list');
    const input = document.getElementById('kurdai-chat-input');
    const sendBtn = document.getElementById('kurdai-chat-send');
    const statusEl = document.getElementById('kurdai-status');

    const csrf = document.querySelector('meta[name="csrf-token"]')?.content || '';
    const welcome = 'سڵاو! من یاریدەدەری کورد ئەی ئای م. بۆ فێربوونی پرۆگرامسازی، زیرەکی دەستکرد یان هەر پرسیارێکی تر بە کوردی پرسیارم لێ بکە 😊';

    let userKey = localStorage.getItem('kurdai_user_key');
    if (!userKey) {
        userKey = 'k-' + Date.now().toString(36) + '-' + Math.random().toString(36).slice(2, 10);
        localStorage.setItem('kurdai_user_key', userKey);
    }

    let sessions = [];
    let current = null;
    let listMode = false;

    async function api(path, opts = {}) {
        const res = await fetch(path, {
            method: opts.method || 'GET',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrf,
                'Accept': 'application/json',
            },
            body: opts.body ? JSON.stringify(opts.body) : undefined,
        });
        if (!res.ok) throw new Error('HTTP ' + res.status);
        return res.json();
    }

    function esc(text) {
        return String(text).replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/>/g, '&gt;');
    }

    function renderMarkdown(text) {
        return esc(text)
            .replace(/```(\w*)\n?([\s\S]*?)```/g, '<pre><code>$2</code></pre>')
            .replace(/`([^`\n]+)`/g, '<code>$1</code>')
            .replace(/\*\*([^*]+)\*\*/g, '<strong>$1</strong>')
            .replace(/\n/g, '<br>');
    }

    function addMessage(role, text) {
        const el = document.createElement('div');
        el.className = 'chat-msg ' + role;
        el.innerHTML = renderMarkdown(text);
        messagesEl.appendChild(el);
        messagesEl.scrollTop = messagesEl.scrollHeight;
        return el;
    }

    function showTyping() {
        const el = document.createElement('div');
        el.className = 'chat-msg bot';
        el.innerHTML = '<div class="chat-typing"><span></span><span></span><span></span></div>';
        messagesEl.appendChild(el);
        messagesEl.scrollTop = messagesEl.scrollHeight;
        return el;
    }

    function setView() {
        listEl.style.display = listMode ? 'flex' : 'none';
        messagesEl.style.display = listMode ? 'none' : 'flex';
        input.closest('#kurdai-chat-input-wrap').style.display = listMode ? 'none' : 'flex';
        statusEl.textContent = listMode ? 'گفتوگۆکان' : 'بەردەستە - بە کوردی پرسیار بکە';
        if (listMode) renderSessions();
        else messagesEl.scrollTop = messagesEl.scrollHeight;
    }

    function renderSessions() {
        listEl.innerHTML = '';
        listEl.classList.toggle('empty', sessions.length === 0);
        if (sessions.length === 0) return;

        const ordered = [...sessions].sort((a, b) => (b.pinned - a.pinned) || (b.updated_at > a.updated_at ? 1 : -1));

        ordered.forEach(s => {
            const row = document.createElement('div');
            row.className = 'session-row' + (current && current.id === s.id ? ' active' : '');

            const pin = document.createElement('button');
            pin.className = 's-pin' + (s.pinned ? ' pinned' : '');
            pin.title = s.pinned ? 'لێکردنەوە لە پین' : 'پینکردن';
            pin.innerHTML = '<svg fill="' + (s.pinned ? 'currentColor' : 'none') + '" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15 4l1.414 1.414a2 2 0 010 2.828L15 9.657 14.343 9 8.828 14.515 6 18l3.485-2.828L15 9.657 14.343 9l1.657-1.657a2 2 0 012.828 0zM4 20l2-4"/></svg>';
            pin.addEventListener('click', async (e) => {
                e.stopPropagation();
                try {
                    const r = await api('/api/chat/sessions/' + s.id + '/pin', { method: 'POST', body: { user_key: userKey } });
                    s.pinned = r.pinned;
                    renderSessions();
                } catch (err) {}
            });

            const del = document.createElement('button');
            del.className = 's-del';
            del.title = 'سڕینەوە';
            del.innerHTML = '<svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>';
            del.addEventListener('click', async (e) => {
                e.stopPropagation();
                if (!confirm('ئەم گفتوگۆیە بسڕینەوە؟')) return;
                try {
                    await api('/api/chat/sessions/' + s.id + '?user_key=' + encodeURIComponent(userKey), { method: 'DELETE' });
                    sessions = sessions.filter(x => x.id !== s.id);
                    if (current && current.id === s.id) {
                        current = null;
                        messagesEl.innerHTML = '';
                        addMessage('bot', welcome);
                    }
                    renderSessions();
                } catch (err) {}
            });

            const titleWrap = document.createElement('div');
            titleWrap.style.cssText = 'flex:1;min-width:0;';
            const t = document.createElement('div');
            t.className = 's-title';
            t.textContent = s.title || 'گفتوگۆی بێ ناو';
            const m = document.createElement('div');
            m.className = 's-meta';
            m.textContent = (s.pinned ? '📌 ' : '') + s.updated_at + (current && current.id === s.id ? ' • ئێستا' : '');
            titleWrap.appendChild(t);
            titleWrap.appendChild(m);

            row.appendChild(titleWrap);
            row.appendChild(pin);
            row.appendChild(del);
            row.addEventListener('click', () => openSession(s.id));
            listEl.appendChild(row);
        });
    }

    async function loadSessions() {
        try {
            sessions = await api('/api/chat/sessions?user_key=' + encodeURIComponent(userKey));
        } catch (err) {
            sessions = [];
        }
        if (listMode) renderSessions();
    }

    async function openSession(id) {
        try {
            const data = await api('/api/chat/sessions/' + id + '/messages?user_key=' + encodeURIComponent(userKey));
            current = { id: data.id, title: data.title, pinned: data.pinned };
            messagesEl.innerHTML = '';
            if (!data.messages || !data.messages.length) {
                addMessage('bot', welcome);
            } else {
                data.messages.forEach(msg => addMessage(msg.role === 'user' ? 'user' : 'bot', msg.content));
            }
            listMode = false;
            setView();
        } catch (err) {}
    }

    function newSession() {
        current = null;
        messagesEl.innerHTML = '';
        addMessage('bot', welcome);
        listMode = false;
        setView();
        input.focus();
    }

    async function sendMessage() {
        const message = input.value.trim();
        if (!message || sendBtn.disabled) return;

        input.value = '';
        addMessage('user', message);
        const typing = showTyping();
        sendBtn.disabled = true;

        try {
            const data = await api('/api/chat', {
                method: 'POST',
                body: { message: message, user_key: userKey, session_id: current ? current.id : null },
            });
            typing.remove();
            addMessage('bot', data.reply || 'ببورە، نەمتوانی وەڵام بدەمەوە.');
            if (data.session_id) {
                current = { id: data.session_id, title: message.slice(0, 60), pinned: false };
                loadSessions();
            }
        } catch (e) {
            typing.remove();
            addMessage('bot', 'ببورە، کێشەیەک ڕوویدا لە پەیوەندیدا. دوای تروە هەوڵبدەرەوە.');
        } finally {
            sendBtn.disabled = false;
        }
    }

    btn.addEventListener('click', () => {
        const open = !panel.classList.contains('open');
        panel.classList.toggle('open', open);
        if (open) {
            if (!messagesEl.children.length) addMessage('bot', welcome);
            loadSessions();
            input.focus();
        }
    });
    closeBtn.addEventListener('click', () => panel.classList.remove('open'));
    sessionsToggle.addEventListener('click', () => { listMode = !listMode; setView(); });
    newSessionBtn.addEventListener('click', newSession);
    sendBtn.addEventListener('click', sendMessage);
    input.addEventListener('keydown', (e) => { if (e.key === 'Enter') sendMessage(); });
})();
</script>
