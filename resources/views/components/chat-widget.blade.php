<!-- ===== چاتبۆتی یاریدەدەری AI (Kurd AI) - Full Features ===== -->
<meta name="csrf-token" content="{{ csrf_token() }}">
<script src="https://cdn.jsdelivr.net/pyodide/v0.23.4/full/pyodide.js"></script>

<style>
    :root {
        --neon-cyan: #00f0ff;
        --neon-pink: #ff2ec4;
        --neon-purple: #b026ff;
        --neon-green: #39ff14;
        --kai-black: #050507;
        --kai-black-2: #0c0c11;
        --kai-black-3: #16161d;
    }
    #kurdai-chat-btn {
        position: fixed; bottom: 24px; right: 24px; z-index: 9998;
        width: 78px; height: 78px; border-radius: 50%;
        background: radial-gradient(circle at 30% 30%, #15151d, #000);
        border: 2px solid var(--neon-cyan); cursor: pointer;
        box-shadow: 0 0 18px rgba(0,240,255,0.55), inset 0 0 14px rgba(0,240,255,0.2);
        display: flex; align-items: center; justify-content: center; padding: 9px;
        transition: transform 0.3s, box-shadow 0.3s;
        animation: kurdaiBtnPulse 3s ease-in-out infinite;
    }
    #kurdai-chat-btn:hover { transform: scale(1.08); box-shadow: 0 0 28px rgba(0,240,255,0.85), 0 0 60px rgba(176,38,255,0.4); animation-play-state: paused; }
    #kurdai-chat-btn img { width: 100%; height: 100%; object-fit: contain; border-radius: 50%; animation: kurdaiBtnFloat 3s ease-in-out infinite; }
    #kurdai-chat-btn:hover img { animation: none; }
    @keyframes kurdaiBtnPulse { 0%,100%{box-shadow:0 0 18px rgba(0,240,255,0.55),0 0 0 0 rgba(0,240,255,0.5)} 50%{box-shadow:0 0 18px rgba(0,240,255,0.55),0 0 0 16px rgba(0,240,255,0)} }
    @keyframes kurdaiBtnFloat { 0%,100%{transform:translateY(0)} 50%{transform:translateY(-3px)} }
    #kurdai-chat-panel {
        position: fixed; bottom: 118px; right: 24px; z-index: 9999;
        width: min(480px, calc(100vw - 48px)); height: min(660px, calc(100vh - 140px));
        display: flex; flex-direction: column; border-radius: 24px; overflow: hidden;
        background: rgba(5,5,7,0.97); backdrop-filter: blur(16px);
        border: 1px solid var(--neon-cyan);
        box-shadow: 0 0 24px rgba(0,240,255,0.25), 0 20px 60px rgba(0,0,0,0.7);
        opacity: 0; transform: translateY(20px) scale(0.95); pointer-events: none; transition: all 0.3s ease;
    }
    #kurdai-chat-panel.open { opacity: 1; transform: translateY(0) scale(1); pointer-events: auto; }
    #kurdai-chat-header {
        background: linear-gradient(135deg, #0a0a10, #10101a);
        border-bottom: 1px solid rgba(0,240,255,0.35); color: #fff;
        padding: 16px 18px; display: flex; align-items: center; gap: 12px; flex-shrink: 0;
    }
    #kurdai-chat-header .avatar {
        width: 46px; height: 46px; background: radial-gradient(circle at 30% 30%, #15151d, #000);
        border: 1px solid var(--neon-cyan); border-radius: 50%;
        display: flex; align-items: center; justify-content: center; flex-shrink: 0;
        padding: 5px; position: relative;
        box-shadow: 0 0 12px rgba(0,240,255,0.5);
        animation: kurdaiAvatarGlow 3s ease-in-out infinite;
    }
    #kurdai-chat-header .avatar img { width: 100%; height: 100%; object-fit: contain; border-radius: 50%; }
    #kurdai-chat-header .avatar::after {
        content: ''; position: absolute; inset: -4px; border-radius: 50%;
        border: 2px solid var(--neon-cyan);
        animation: kurdaiAvatarRing 2.5s ease-out infinite;
    }
    @keyframes kurdaiAvatarGlow { 0%,100%{box-shadow:0 0 10px rgba(0,240,255,0.4)} 50%{box-shadow:0 0 22px rgba(0,240,255,0.9),0 0 40px rgba(176,38,255,0.35)} }
    @keyframes kurdaiAvatarRing { 0%{transform:scale(1);opacity:0.8} 100%{transform:scale(1.8);opacity:0} }
    #kurdai-chat-header .hdr-title { min-width: 0; flex: 1; }
    #kurdai-chat-header h4 {
        font-size: 16px; font-weight: 900; margin: 0;
        background: linear-gradient(90deg, var(--neon-cyan), var(--neon-pink));
        -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text;
    }
    #kurdai-chat-header span { font-size: 11px; color: #8b8b98; display: block; }
    .hdr-btn {
        background: rgba(0,240,255,0.07); border: 1px solid rgba(0,240,255,0.35);
        color: var(--neon-cyan); width: 32px; height: 32px; border-radius: 10px;
        cursor: pointer; display: flex; align-items: center; justify-content: center;
        flex-shrink: 0; transition: all 0.2s;
    }
    .hdr-btn:hover { background: rgba(0,240,255,0.2); box-shadow: 0 0 12px rgba(0,240,255,0.5); transform: scale(1.06); }
    .hdr-btn svg { width: 16px; height: 16px; }
    #kurdai-chat-body { flex: 1; display: flex; flex-direction: column; min-height: 0; }
    #kurdai-chat-messages {
        flex: 1; overflow-y: auto; padding: 20px 16px;
        display: flex; flex-direction: column; gap: 14px;
        background: #050507;
        background-image: radial-gradient(rgba(0,240,255,0.06) 1px, transparent 1px);
        background-size: 22px 22px;
    }
    #kurdai-chat-messages::-webkit-scrollbar, #kurdai-session-list::-webkit-scrollbar { width: 5px; }
    #kurdai-chat-messages::-webkit-scrollbar-thumb, #kurdai-session-list::-webkit-scrollbar-thumb { background: rgba(0,240,255,0.35); border-radius: 10px; }
    .chat-msg {
        max-width: 88%; padding: 12px 16px; border-radius: 18px;
        font-size: 14.5px; line-height: 1.75; white-space: pre-wrap; word-break: break-word;
        animation: chatFadeIn 0.25s ease; position: relative;
    }
    @keyframes chatFadeIn { from{opacity:0;transform:translateY(6px)} to{opacity:1;transform:translateY(0)} }
    .chat-msg.user {
        align-self: flex-start;
        background: linear-gradient(135deg, #0a0a12, #0d0d16);
        border: 1px solid var(--neon-cyan); box-shadow: 0 0 12px rgba(0,240,255,0.25);
        color: #e6feff; border-bottom-left-radius: 6px;
    }
    .chat-msg.bot {
        align-self: flex-end;
        background: linear-gradient(135deg, #12121a, #0d0d13);
        border: 1px solid var(--neon-purple); box-shadow: 0 0 10px rgba(176,38,255,0.2);
        color: #e8e8f0; border-bottom-right-radius: 6px;
    }
    .chat-msg img.user-img { max-width: 200px; max-height: 200px; border-radius: 10px; margin-top: 8px; }
    .chat-msg.bot code {
        background: rgba(0,240,255,0.12); color: var(--neon-cyan);
        padding: 2px 6px; border-radius: 6px; font-size: 12.5px; direction: ltr; display: inline-block;
    }
    .chat-msg.bot pre {
        direction: ltr; text-align: left;
        background: #000; border: 1px solid rgba(0,240,255,0.25);
        color: #d8ffe8; padding: 14px; border-radius: 12px;
        overflow-x: auto; font-size: 13px; margin: 10px 0;
    }
    .chat-msg.bot pre code { background: none; padding: 0; border-radius: 0; color: inherit; }
    .chat-typing { display: flex; gap: 6px; align-items: center; padding: 10px 4px; }
    .chat-typing span {
        width: 9px; height: 9px; border-radius: 50%;
        background: var(--neon-cyan); box-shadow: 0 0 8px var(--neon-cyan);
        animation: chatTyping 1s infinite ease-in-out;
    }
    .chat-typing span:nth-child(2) { animation-delay: 0.15s; background: var(--neon-pink); box-shadow: 0 0 8px var(--neon-pink); }
    .chat-typing span:nth-child(3) { animation-delay: 0.3s; background: var(--neon-purple); box-shadow: 0 0 8px var(--neon-purple); }
    @keyframes chatTyping { 0%,60%,100%{transform:translateY(0);opacity:0.4} 30%{transform:translateY(-6px);opacity:1} }
    .chat-msg-actions { display: flex; gap: 4px; margin-top: 6px; opacity: 0; transition: opacity 0.2s; }
    .chat-msg:hover .chat-msg-actions { opacity: 1; }
    .chat-msg-actions button {
        background: rgba(0,240,255,0.08); border: 1px solid rgba(0,240,255,0.25);
        color: #8b8b98; width: 28px; height: 28px; border-radius: 8px;
        cursor: pointer; display: flex; align-items: center; justify-content: center;
        font-size: 13px; transition: all 0.2s;
    }
    .chat-msg-actions button:hover { background: rgba(0,240,255,0.2); color: var(--neon-cyan); }
    .chat-msg-actions button.reacted { background: rgba(0,240,255,0.25); color: var(--neon-cyan); border-color: var(--neon-cyan); }
    .chat-msg-actions button.run-btn {
        width: auto; padding: 0 10px; font-size: 11px; font-weight: 700; gap: 4px;
        color: var(--neon-green); border-color: rgba(57,255,20,0.35);
    }
    .chat-msg-actions button.run-btn:hover { background: rgba(57,255,20,0.15); }
    #kurdai-chat-input-wrap {
        display: flex; flex-direction: column; gap: 0;
        background: #08080c; border-top: 1px solid rgba(0,240,255,0.25); flex-shrink: 0;
    }
    #kurdai-input-bar { display: flex; align-items: center; gap: 6px; padding: 12px 14px; }
    #kurdai-tool-bar { display: flex; gap: 6px; padding: 0 14px 10px; flex-wrap: wrap; }
    .tool-btn {
        background: rgba(0,240,255,0.07); border: 1px solid rgba(0,240,255,0.25);
        color: #6b6b78; height: 30px; border-radius: 9px;
        cursor: pointer; display: flex; align-items: center; justify-content: center; gap: 5px;
        font-size: 11.5px; padding: 0 10px; transition: all 0.2s;
    }
    .tool-btn:hover { background: rgba(0,240,255,0.18); color: var(--neon-cyan); }
    .tool-btn.active { background: rgba(0,240,255,0.2); color: var(--neon-cyan); border-color: var(--neon-cyan); }
    .tool-btn svg { width: 14px; height: 14px; }
    #kurdai-chat-input {
        flex: 1; border: 1px solid rgba(0,240,255,0.3); border-radius: 14px;
        padding: 12px 16px; font-size: 15px; background: #0c0c12; color: #e6feff;
        outline: none; transition: border-color 0.2s, box-shadow 0.2s; min-width: 0;
    }
    #kurdai-chat-input::placeholder { color: #4a4a58; }
    #kurdai-chat-input:focus { border-color: var(--neon-cyan); box-shadow: 0 0 12px rgba(0,240,255,0.4); }
    #kurdai-chat-send {
        width: 50px; height: 50px; border: 1px solid var(--neon-cyan); border-radius: 14px;
        background: radial-gradient(circle at 30% 30%, #0d0d16, #000); color: var(--neon-cyan);
        cursor: pointer; display: flex; align-items: center; justify-content: center;
        transition: all 0.2s; flex-shrink: 0; box-shadow: 0 0 10px rgba(0,240,255,0.35);
    }
    #kurdai-chat-send:hover { transform: scale(1.05); box-shadow: 0 0 18px rgba(0,240,255,0.7); color: var(--neon-pink); border-color: var(--neon-pink); }
    #kurdai-chat-send:disabled { opacity: 0.5; cursor: not-allowed; transform: none; }
    #kurdai-chat-send svg { width: 22px; height: 22px; }
    #kurdai-session-list {
        flex: 1; overflow-y: auto; padding: 14px 12px;
        display: flex; flex-direction: column; gap: 9px; background: #050507;
    }
    #kurdai-session-list.empty::after {
        content: attr(data-empty-text); display: block; text-align: center; color: #4a4a58; font-size: 13px; padding: 40px 10px;
    }
    .session-row {
        display: flex; align-items: center; gap: 8px;
        padding: 11px 13px; border-radius: 14px; background: #0c0c12;
        border: 1px solid rgba(0,240,255,0.2); cursor: pointer; transition: all 0.2s;
    }
    .session-row:hover { border-color: var(--neon-cyan); box-shadow: 0 0 10px rgba(0,240,255,0.25); }
    .session-row.active { border-color: var(--neon-cyan); box-shadow: 0 0 0 2px rgba(0,240,255,0.15); }
    .session-row .s-title { flex: 1; min-width: 0; font-size: 14px; font-weight: 700; color: #e8e8f0; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
    .session-row .s-meta { font-size: 11px; color: #4a4a58; margin-top: 2px; }
    .session-row .s-pin, .session-row .s-del {
        background: none; border: none; cursor: pointer; padding: 5px; border-radius: 8px; color: #4a4a58;
        display: flex; align-items: center; justify-content: center; transition: all 0.2s; flex-shrink: 0;
    }
    .session-row .s-pin svg, .session-row .s-del svg { width: 16px; height: 16px; }
    .session-row .s-pin:hover { color: var(--neon-green); }
    .session-row .s-pin.pinned { color: var(--neon-green); text-shadow: 0 0 8px var(--neon-green); }
    .session-row .s-del:hover { color: #ff4444; }
    .chat-welcome {
        background: linear-gradient(135deg, rgba(0,240,255,0.06), rgba(176,38,255,0.06));
        border: 1px dashed rgba(0,240,255,0.4); border-radius: 16px;
        padding: 16px; font-size: 14px; line-height: 1.8; color: #b8f8ff;
    }
    .chat-quota {
        align-self: center; font-size: 11px; color: var(--neon-green);
        text-shadow: 0 0 8px rgba(57,255,20,0.5);
        background: rgba(57,255,20,0.07); border: 1px solid rgba(57,255,20,0.3);
        border-radius: 999px; padding: 4px 14px;
    }
    .suggestions { display: flex; flex-wrap: wrap; gap: 8px; padding: 10px 0; justify-content: center; }
    .suggestions button {
        background: rgba(0,240,255,0.07); border: 1px solid rgba(0,240,255,0.3);
        color: var(--neon-cyan); border-radius: 999px; padding: 7px 14px; font-size: 12.5px;
        cursor: pointer; transition: all 0.2s;
    }
    .suggestions button:hover { background: rgba(0,240,255,0.2); box-shadow: 0 0 10px rgba(0,240,255,0.4); }
    .copy-toast {
        position: fixed; bottom: 130px; right: 60px; z-index: 10000;
        background: rgba(57,255,20,0.15); border: 1px solid var(--neon-green);
        color: var(--neon-green); border-radius: 12px; padding: 8px 18px;
        font-size: 12px; animation: fadeInUp 0.3s ease; pointer-events: none;
    }
    @keyframes fadeInUp { from{opacity:0;transform:translateY(10px)} to{opacity:1;transform:translateY(0)} }
    #kurdai-preview {
        background: #12121a; border: 1px solid rgba(0,240,255,0.35); border-radius: 10px;
        padding: 10px; max-height: 120px; overflow: auto; display: none; margin: 0 14px; color: #e8e8f0; font-size: 12px;
    }
</style>

<button id="kurdai-chat-btn" aria-label="چاتبۆتی کورد ئەی ئای">
    <img src="logo.jpg" alt="Kurd AI" title="کورد ئەی ئای">
</button>

<div id="kurdai-chat-panel">
    <div id="kurdai-chat-header">
        <div class="avatar"><img src="logo.jpg" alt="Kurd AI"></div>
        <div class="hdr-title">
            <h4>KURD AI</h4>
            <span id="kurdai-status"></span>
        </div>
        <button id="kurdai-sessions-toggle" class="hdr-btn" title="گفتوگۆکان">
            <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h10"/></svg>
        </button>
        <button id="kurdai-new-session" class="hdr-btn" title="گفتوگۆی نوێ">
            <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/></svg>
        </button>
        <button id="kurdai-chat-close" class="hdr-btn" title="داخستن">
            <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
        </button>
    </div>
    <div id="kurdai-chat-body">
        <div id="kurdai-session-list" style="display:none;"></div>
        <div id="kurdai-chat-messages"></div>
        <div id="kurdai-chat-input-wrap">
            <div id="kurdai-preview"></div>
            <div id="kurdai-tool-bar">
                <button class="tool-btn" id="kurdai-file-btn" title="فایل">
                    <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13"/></svg>
                    فایل
                </button>
                <button class="tool-btn" id="kurdai-image-btn" title="وێنە">
                    <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                    وێنە
                </button>
                <button class="tool-btn" id="kurdai-voice-btn" title="دەنگ">
                    <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19 11a7 7 0 01-14 0m7 7v4m-4 0h8m-4-10a3 3 0 01-3 3m3-3a3 3 0 003 3m-3-3a3 3 0 01-3-3m3 3a3 3 0 013-3"/></svg>
                    دەنگ
                </button>
                <button class="tool-btn" id="kurdai-grammar-btn" title="چاککردنی ڕێزمان">
                    <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                    ڕێزمان
                </button>
            </div>
            <div id="kurdai-input-bar">
                <input id="kurdai-chat-input" type="text" placeholder="" autocomplete="off">
                <button id="kurdai-chat-send" aria-label="ناردن">
                    <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/></svg>
                </button>
            </div>
        </div>
    </div>
</div>

<script type="module">
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
    const voiceBtn = document.getElementById('kurdai-voice-btn');
    const grammarBtn = document.getElementById('kurdai-grammar-btn');
    const previewEl = document.getElementById('kurdai-preview');

    const csrf = document.querySelector('meta[name="csrf-token"]')?.content || '';

    const T = {
        so: {
            welcome: 'سڵاو! من یاریدەدەری کورد ئەی ئای م. بۆ فێربوونی پرۆگرامسازی، زیرەکی دەستکرد یان هەر پرسیارێکی تر بە کوردی پرسیارم لێ بکە 😊',
            status: 'بەردەستە - بە کوردی پرسیار بکە', status_list: 'گفتوگۆکان',
            placeholder: 'پرسیارەکەت لێرە بنووسە...',
            untitled: 'گفتوگۆی بێ ناو', now: 'ئێستا',
            delete_confirm: 'ئەم گفتوگۆیە بسڕینەوە؟', pin_on: 'لێکردنەوە لە پین', pin_off: 'پینکردن',
            delete: 'سڕینەوە', empty: 'هیچ گفتوگۆیەک نییە',
            quota: 'ماوە: ', network_error: 'ببورە، کێشەیەک ڕوویدا لە پەیوەندیدا.',
            copied: 'کۆپی کرا!', voice_not_avail: 'دەنگ ناڤێ نا', voice_listening: 'گوێ بگرە...',
            run: '▶ کارپێکردن', file_attached: 'فایل: ',
            grammar_on: 'مۆدی ڕێزمان: ئین', grammar_off: 'مۆدی ڕێزمان: دامە',
            suggestions: ['چۆن لە PHP فەنکشن دروست بکەم؟', 'سیستەمی بەڕێبردن چۆن کاردەکات؟', 'خشتەی کورد چییە؟', 'ئیمۆڵیشنە چییە؟'],
        },
        ba: {
            welcome: 'سڵاو! ئەز یاریدەدەری کورد ئەی ئای م. بۆ فێربوونا پرۆگرامسازیێ، ژیرییا دەستکرد یان هەر پرسیارەکا تر ب کوردی پرسیارە ژ من بکە 😊',
            status: 'بەردەستە - ب کوردی پرسیار بکە', status_list: 'گفتوگۆ',
            placeholder: 'پرسیارا خۆ ڤێرە بنڤێسە...',
            untitled: 'گفتوگۆیەکا بێ ناڤ', now: 'نوکە',
            delete_confirm: 'ئەڤ گفتوگۆیا ب سڕینەوە؟', pin_on: 'ژ پین دەرخستن', pin_off: 'پینکرن',
            delete: 'سڕینەوە', empty: 'چ گفتوگۆیەک نینە',
            quota: 'مایین: ', network_error: 'ببورە، کێشەیەک ڕوویدا د گرێدانێ دا.',
            copied: 'کۆپی کرا!', voice_not_avail: 'دەنگ ناڤێ نا', voice_listening: 'گوێ بگرە...',
            run: '▶ کاردان', file_attached: 'فایل: ',
            grammar_on: 'مۆدێ ڕێزمان: ئین', grammar_off: 'مۆدێ ڕێزمان: دامە',
            suggestions: ['چاوا ل PHP فەنکشن دروست بکەم؟', 'سیستەما بەڕێبردنێ چاوا کاردەکات؟', 'خشتەیا کورد چییە؟', 'ئیمۆڵیشنێ چییە؟'],
        },
    };

    function lang() { return localStorage.getItem('site-lang') === 'ba' ? 'ba' : 'so'; }
    function t(key) { return T[lang()][key] ?? T.so[key]; }

    let userKey = localStorage.getItem('kurdai_user_key');
    if (!userKey) {
        userKey = 'k-' + Date.now().toString(36) + '-' + Math.random().toString(36).slice(2, 10);
        localStorage.setItem('kurdai_user_key', userKey);
    }

    let sessions = [], current = null, listMode = false, grammarMode = false,
        attachedFile = null, attachedImage = null, pyodideInstance = null, isRecording = false;

    function refreshUiTexts() {
        statusEl.textContent = listMode ? t('status_list') : t('status');
        input.placeholder = t('placeholder');
        grammarBtn.classList.toggle('active', grammarMode);
    }

    async function api(path, opts = {}) {
        const res = await fetch(path, {
            method: opts.method || 'GET',
            headers: Object.assign({ Accept: 'application/json' },
                opts.method === 'POST' ? { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': csrf } : {}),
            body: opts.body ? JSON.stringify(opts.body) : undefined,
        });
        let data = null;
        try { data = await res.json(); } catch (e) {}
        return { status: res.status, data };
    }

    function esc(text) {
        return String(text).replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/>/g, '&gt;');
    }

    function renderMarkdown(text) {
        let out = esc(text);
        out = out.replace(/```(\w*)\n?([\s\S]*?)```/g, (_, lang, code) => `<pre><code class="lang-${lang || 'text'}">${code}</code></pre>`);
        out = out.replace(/`([^`\n]+)`/g, '<code>$1</code>');
        out = out.replace(/\*\*([^*]+)\*\*/g, '<strong>$1</strong>');
        out = out.replace(/\n/g, '<br>');
        return out;
    }

    function showToast(text) {
        const toast = document.createElement('div');
        toast.className = 'copy-toast'; toast.textContent = text;
        document.body.appendChild(toast); setTimeout(() => toast.remove(), 1500);
    }

    function showTyping() {
        const el = document.createElement('div');
        el.className = 'chat-msg bot';
        el.innerHTML = '<div class="chat-typing"><span></span><span></span><span></span></div>';
        messagesEl.appendChild(el); messagesEl.scrollTop = messagesEl.scrollHeight;
        return el;
    }

    async function typeEffect(el, text, speed = 22) {
        return new Promise(resolve => {
            let i = 0;
            const interval = setInterval(() => {
                if (i < text.length) { el.textContent += text[i]; i++; messagesEl.scrollTop = messagesEl.scrollHeight; }
                else { clearInterval(interval); el.innerHTML = renderMarkdown(text); el.dataset.raw = text; resolve(); }
            }, speed);
        });
    }

    function addMessage(role, text, opts = {}) {
        const el = document.createElement('div');
        el.className = 'chat-msg ' + role;

        if (opts.animate) {
            el.textContent = '';
            messagesEl.appendChild(el); messagesEl.scrollTop = messagesEl.scrollHeight;
            typeEffect(el, text);
        } else {
            el.innerHTML = renderMarkdown(text); el.dataset.raw = text;
            messagesEl.appendChild(el); messagesEl.scrollTop = messagesEl.scrollHeight;
        }

        const actions = document.createElement('div');
        actions.className = 'chat-msg-actions';

        if (role === 'user') {
            if (opts.image) { const img = document.createElement('img'); img.className = 'user-img'; img.src = opts.image; el.appendChild(img); }
            if (opts.fileName) { const ft = document.createElement('div'); ft.style.cssText = 'font-size:11px;color:var(--neon-cyan);margin-top:6px;opacity:0.8;'; ft.textContent = t('file_attached') + opts.fileName; el.appendChild(ft); }
        }

        if (role === 'bot') {
            const copyBtn = document.createElement('button');
            copyBtn.textContent = '📋'; copyBtn.title = 'کۆپی';
            copyBtn.addEventListener('click', () => navigator.clipboard.writeText(el.dataset.raw || '').then(() => showToast(t('copied'))));
            actions.appendChild(copyBtn);

            const reactionUp = document.createElement('button');
            reactionUp.textContent = '👍'; reactionUp.title = 'باش';
            reactionUp.dataset.msgId = opts.messageId; reactionUp.dataset.reaction = 'up';
            reactionUp.addEventListener('click', () => setReaction(reactionUp));
            actions.appendChild(reactionUp);

            const reactionDown = document.createElement('button');
            reactionDown.textContent = '👎'; reactionDown.title = 'نەخۆش';
            reactionDown.dataset.msgId = opts.messageId; reactionDown.dataset.reaction = 'down';
            reactionDown.addEventListener('click', () => setReaction(reactionDown));
            actions.appendChild(reactionDown);

            const codeBlock = el.querySelector('pre code');
            if (codeBlock) {
                const runBtn = document.createElement('button');
                runBtn.className = 'run-btn'; runBtn.innerHTML = t('run');
                runBtn.addEventListener('click', () => runCode(codeBlock, runBtn));
                actions.appendChild(runBtn);
            }

            if (opts.messageId) {
                if (opts.reaction === 'up') reactionUp.classList.add('reacted');
                if (opts.reaction === 'down') reactionDown.classList.add('reacted');
            }
        }

        el.appendChild(actions);
        messagesEl.scrollTop = messagesEl.scrollHeight;
        return el;
    }

    async function setReaction(btn) {
        if (!btn.dataset.msgId) return;
        const reaction = btn.classList.contains('reacted') ? null : btn.dataset.reaction;
        const sibling = btn.dataset.reaction === 'up' ? btn.nextElementSibling : btn.previousElementSibling;
        if (sibling) sibling.classList.remove('reacted');
        btn.classList.toggle('reacted', !!reaction);
        try { await api('/api/chat/messages/' + btn.dataset.msgId + '/reaction', { method: 'POST', body: { user_key: userKey, reaction } }); } catch (e) {}
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
                pre.style.cssText = 'margin:8px 0;padding:12px;background:#000;border:1px solid var(--neon-green);color:var(--neon-green);border-radius:10px;font-size:13px;direction:ltr;text-align:left;white-space:pre-wrap;';
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
                pre.style.cssText = 'margin:8px 0;padding:12px;background:#000;border:1px solid var(--neon-green);color:var(--neon-green);border-radius:10px;font-size:13px;direction:ltr;text-align:left;white-space:pre-wrap;';
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
        ordered.forEach(s => {
            const row = document.createElement('div');
            row.className = 'session-row' + (current?.id === s.id ? ' active' : '');
            const pin = document.createElement('button');
            pin.className = 's-pin' + (s.pinned ? ' pinned' : '');
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
                const r = await api('/api/chat/sessions/' + s.id + '?user_key=' + encodeURIComponent(userKey), { method: 'DELETE' });
                if (r.status === 200) {
                    sessions = sessions.filter(x => x.id !== s.id);
                    if (current?.id === s.id) { current = null; messagesEl.innerHTML = ''; addMessage('bot', t('welcome')); addSuggestions(); }
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

    async function loadSessions() {
        const r = await api('/api/chat/sessions?user_key=' + encodeURIComponent(userKey));
        sessions = r.status === 200 ? (r.data || []) : [];
        if (listMode) renderSessions();
    }

    async function openSession(id) {
        const r = await api('/api/chat/sessions/' + id + '/messages?user_key=' + encodeURIComponent(userKey));
        if (r.status !== 200) return;
        const data = r.data;
        current = { id: data.id, title: data.title, pinned: data.pinned };
        messagesEl.innerHTML = '';
        if (!data.messages?.length) { addMessage('bot', t('welcome')); addSuggestions(); }
        else { data.messages.forEach(msg => addMessage(msg.role === 'user' ? 'user' : 'bot', msg.content, { messageId: msg.id, reaction: msg.reaction })); }
        listMode = false; setView();
    }

    function newSession() {
        current = null; messagesEl.innerHTML = '';
        addMessage('bot', t('welcome')); addSuggestions();
        listMode = false; setView(); input.focus();
    }

    function addSuggestions() {
        const wrap = document.createElement('div'); wrap.className = 'suggestions';
        t('suggestions').forEach(text => {
            const chip = document.createElement('button'); chip.textContent = text;
            chip.addEventListener('click', () => { input.value = text; sendMessage(); });
            wrap.appendChild(chip);
        });
        messagesEl.appendChild(wrap); messagesEl.scrollTop = messagesEl.scrollHeight;
    }

    async function sendMessage() {
        const message = input.value.trim();
        if (!message && !attachedImage && !attachedFile) return;
        if (sendBtn.disabled) return;

        addMessage('user', message || (attachedFile ? t('file_attached') + attachedFile.name : '(وێنە)'), { image: attachedImage, fileName: attachedFile?.name });
        const typing = showTyping();
        sendBtn.disabled = true;

        const body = {
            message: message || 'وەڵام بە ئەم وێنەیەدا بدە',
            user_key: userKey, session_id: current?.id || null,
            lang: lang(), mode: grammarMode ? 'grammar' : 'default',
        };
        if (attachedImage) body.image = attachedImage;
        if (attachedFile) { body.file_name = attachedFile.name; body.file_content = attachedFile.content; }

        try {
            const r = await api('/api/chat', { method: 'POST', body });
            typing.remove();
            if (r.status === 429) { addMessage('bot', r.data?.reply || t('network_error')); if (r.data?.remaining !== undefined) showQuota(r.data.remaining); return; }
            if (r.status !== 200) { addMessage('bot', r.data?.reply || t('network_error')); return; }
            addMessage('bot', r.data.reply || t('network_error'), { animate: true });
            if (r.data.remaining !== undefined) showQuota(r.data.remaining);
            if (r.data.session_id) { current = { id: r.data.session_id, title: message?.slice(0, 60), pinned: false }; loadSessions(); }
        } catch (e) { typing.remove(); addMessage('bot', t('network_error')); }
        finally { sendBtn.disabled = false; attachedFile = null; attachedImage = null; previewEl.style.display = 'none'; previewEl.textContent = ''; }
    }

    function showQuota(r) {
        if (r == null) return;
        const old = messagesEl.querySelector('.chat-quota'); if (old) old.remove();
        const el = document.createElement('div'); el.className = 'chat-quota';
        el.textContent = t('quota') + r + '/3';
        messagesEl.insertBefore(el, messagesEl.firstChild);
    }

    function setView() {
        listEl.style.display = listMode ? 'flex' : 'none';
        messagesEl.style.display = listMode ? 'none' : 'flex';
        toolBar.style.display = listMode ? 'none' : 'flex';
        document.getElementById('kurdai-input-bar').style.display = listMode ? 'none' : 'flex';
        refreshUiTexts();
        if (listMode) renderSessions();
        else messagesEl.scrollTop = messagesEl.scrollHeight;
    }

    btn.addEventListener('click', () => {
        const open = !panel.classList.contains('open');
        panel.classList.toggle('open', open);
        if (open) {
            if (!messagesEl.children.length) { addMessage('bot', t('welcome')); addSuggestions(); }
            refreshUiTexts(); loadSessions(); input.focus();
        }
    });
    closeBtn.addEventListener('click', () => panel.classList.remove('open'));
    sessionsToggle.addEventListener('click', () => { listMode = !listMode; setView(); });
    newSessionBtn.addEventListener('click', newSession);
    sendBtn.addEventListener('click', sendMessage);
    input.addEventListener('keydown', e => { if (e.key === 'Enter' && !e.shiftKey) { e.preventDefault(); sendMessage(); } });

    grammarBtn.addEventListener('click', () => {
        grammarMode = !grammarMode; refreshUiTexts();
        showToast(grammarMode ? t('grammar_on') : t('grammar_off'));
    });

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

    if ('webkitSpeechRecognition' in window || 'SpeechRecognition' in window) {
        const SR = window.SpeechRecognition || window.webkitSpeechRecognition;
        const recognition = new SR();
        recognition.continuous = false; recognition.interimResults = false;
        voiceBtn.addEventListener('click', () => {
            if (isRecording) { recognition.stop(); isRecording = false; voiceBtn.classList.remove('active'); return; }
            try { recognition.lang = 'ckb'; recognition.start(); isRecording = true; voiceBtn.classList.add('active'); voiceBtn.textContent = t('voice_listening'); }
            catch (e) { showToast(t('voice_not_avail')); }
        });
        recognition.onresult = e => { input.value = e.results[0][0].transcript; isRecording = false; voiceBtn.classList.remove('active'); };
        recognition.onerror = () => { isRecording = false; voiceBtn.classList.remove('active'); };
        recognition.onend = () => { isRecording = false; voiceBtn.classList.remove('active'); };
    } else { voiceBtn.style.display = 'none'; }
})();
</script>
