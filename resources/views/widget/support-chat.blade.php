<style>
    #sc-widget {
        position: fixed;
        bottom: 60px;
        right: 5px;
        z-index: 9999;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }

    /* System message */
    .sc-system {
        max-width: 100%;
        margin: 12px auto;
        padding: 8px 14px;
        font-size: 12px;
        color: #6b7280;
        text-align: center;
        background: #f3f4f6;
        border-radius: 8px;
    }

    /* Time under system message */
    .sc-system .sc-time {
        font-size: 11px;
        margin-top: 2px;
        color: #9ca3af;
    }

    .sc-error {
        border-color: #dc2626 !important;
    }

    .sc-error-text {
        color: #dc2626;
        font-size: 12px;
        margin-top: 4px;
    }


    /* Floating button */
    #sc-toggle {
        width: 60px;
        height: 60px;
        border-radius: 50%;
        background: linear-gradient(135deg, #0074a3, #005a7d);
        color: white;
        border: none;
        cursor: pointer;
        box-shadow: 0 8px 25px rgba(0, 116, 163, 0.35);
        font-size: 24px;
        transition: all 0.3s ease;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    #sc-toggle:hover {
        transform: translateY(-3px);
        box-shadow: 0 12px 35px rgba(0, 116, 163, 0.45);
    }

    #sc-toggle:active {
        transform: translateY(-1px);
    }

    /* Chat box */
    #sc-box {
        width: 360px;
        height: 520px;
        background: #fff;
        border-radius: 16px;
        box-shadow: 0 20px 60px rgba(0, 0, 0, 0.2);
        display: none;
        flex-direction: column;
        overflow: hidden;
        margin-bottom: 12px;
    }

    /* Header */
    #sc-header {
        background: linear-gradient(135deg, #0074a3, #005a7d);
        color: white;
        padding: 18px 16px;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    #sc-header h3 {
        font-size: 18px;
        font-weight: 600;
        margin: 0 0 4px 0;
    }

    #sc-header small {
        font-size: 13px;
        opacity: 0.9;
    }

    #sc-header button {
        background: rgba(255, 255, 255, 0.15);
        border: none;
        color: white;
        cursor: pointer;
        width: 32px;
        height: 32px;
        border-radius: 6px;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: background 0.2s ease;
    }

    #sc-header button:hover {
        background: rgba(255, 255, 255, 0.25);
    }

    /* Messages */
    #sc-messages {
        flex: 1;
        padding: 16px;
        overflow-y: auto;
        background: #f9fafb;
    }

    #sc-messages::-webkit-scrollbar {
        width: 6px;
    }

    #sc-messages::-webkit-scrollbar-track {
        background: transparent;
    }

    #sc-messages::-webkit-scrollbar-thumb {
        background: #d1d5db;
        border-radius: 3px;
    }

    #sc-messages::-webkit-scrollbar-thumb:hover {
        background: #9ca3af;
    }

    /* Date separator */
    .sc-date-sep {
        text-align: center;
        font-size: 12px;
        color: #6b7280;
        margin: 16px 0;
        user-select: none;
        font-weight: 500;
    }

    /* Message bubbles */
    .sc-msg {
        max-width: 75%;
        margin-bottom: 10px;
        padding: 10px 14px;
        border-radius: 16px;
        font-size: 14px;
        line-height: 1.5;
        word-break: break-word;
    }

    .sc-user {
        background: linear-gradient(135deg, #0074a3, #005a7d);
        color: white;
        margin-left: auto;
        border-bottom-right-radius: 4px;
    }

    .sc-agent {
        background: #e5e7eb;
        color: #111827;
        margin-right: auto;
        border-bottom-left-radius: 4px;
    }

    /* Time under bubble */
    .sc-time {
        font-size: 11px;
        margin-top: 6px;
        opacity: 0.8;
        user-select: none;
    }

    .sc-user .sc-time {
        color: rgba(255, 255, 255, 0.9);
        text-align: right;
    }

    .sc-agent .sc-time {
        color: #6b7280;
        text-align: left;
    }

    /* Guest form */
    #sc-form {
        padding: 24px 20px;
        background: #fff;
    }

    #sc-form h3 {
        font-size: 22px;
        color: #111827;
        margin-bottom: 8px;
        text-align: center;
    }

    #sc-form h4 {
        font-size: 16px;
        color: #374151;
        margin-bottom: 16px;
        text-align: center;
        font-weight: 500;
    }

    #sc-form p {
        font-size: 13px;
        color: #6b7280;
        margin-bottom: 20px;
        text-align: center;
        line-height: 1.6;
    }

    #sc-form input {
        width: 100%;
        padding: 12px 14px;
        margin-bottom: 12px;
        border-radius: 8px;
        border: 2px solid #e5e7eb;
        font-size: 14px;
        transition: all 0.3s ease;
        outline: none;
    }

    #sc-form input:focus {
        border-color: #0074a3;
        box-shadow: 0 0 0 3px rgba(0, 116, 163, 0.1);
    }

    #sc-form input::placeholder {
        color: #9ca3af;
    }

    #sc-form button {
        width: 100%;
        padding: 12px;
        background: linear-gradient(135deg, #0074a3, #005a7d);
        color: white;
        border: none;
        border-radius: 8px;
        cursor: pointer;
        font-size: 15px;
        font-weight: 600;
        transition: all 0.3s ease;
        margin-top: 8px;
    }

    #sc-form button:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(0, 116, 163, 0.3);
    }

    #sc-form button:active {
        transform: translateY(0);
    }

    /* Message input */
    #sc-input {
        padding: 14px;
        border-top: 1px solid #e5e7eb;
        display: none;
        gap: 8px;
        background: #fff;
    }

    #sc-input input {
        flex: 1;
        padding: 11px 16px;
        border-radius: 24px;
        border: 2px solid #e5e7eb;
        font-size: 14px;
        outline: none;
        transition: all 0.3s ease;
    }

    #sc-input input:focus {
        border-color: #0074a3;
        box-shadow: 0 0 0 3px rgba(0, 116, 163, 0.1);
    }

    #sc-input button {
        background: linear-gradient(135deg, #0074a3, #005a7d);
        border: none;
        color: white;
        width: 42px;
        height: 42px;
        border-radius: 50%;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.3s ease;
        flex-shrink: 0;
    }

    #sc-input button:hover {
        transform: scale(1.05);
        box-shadow: 0 4px 12px rgba(0, 116, 163, 0.3);
    }

    #sc-input button:active {
        transform: scale(0.98);
    }

    /* Message row */
    .sc-row {
        display: flex;
        align-items: flex-start;
        gap: 10px;
        margin-bottom: 12px;
    }

    .sc-row.sc-user-row {
        flex-direction: row-reverse;
    }

    /* Avatar */
    .sc-avatar {
        width: 34px;
        height: 34px;
        border-radius: 50%;
        background: #9ca3af;
        color: white;
        font-size: 13px;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
        user-select: none;
        font-weight: 600;
    }

    .sc-avatar.agent {
        background: linear-gradient(135deg, #0074a3, #005a7d);
    }

    .sc-avatar.user {
        background: linear-gradient(135deg, #0074a3, #005a7d);
        font-size: 11px;
    }

    .sc-avatar.system {
        background: #6b7280;
    }

    /* Name label */
    .sc-name {
        font-size: 12px;
        font-weight: 600;
        margin-bottom: 5px;
        color: #374151;
    }

    .sc-user .sc-name {
        text-align: right;
        color: rgba(255, 255, 255, 0.95);
    }

    /* Mobile Responsive */
    @media (max-width: 480px) {
        #sc-box {
            width: calc(100vw - 20px);
            height: calc(100vh - 140px);
            max-width: 360px;
        }
    }
</style>
<section class="start_chat">
    <div id="sc-widget">
        <!-- Floating Button -->
        <button id="sc-toggle" aria-label="Open Chat" onclick="toggleChat()">
            <i class="fa fa-comments"></i>
        </button>
        <!-- Chat Box -->
        <div id="sc-box">
            <!-- Header -->
            <div id="sc-header">
                <div>
                    <h3>EzeAD Live Chat</h3>
                    <small>We are here to help 24/7</small>
                </div>
                <div style="display:flex; gap:8px;">
                    <button onclick="endChat()" title="End chat" aria-label="End Chat">
                        <i class="fa fa-sign-out-alt"></i>
                    </button>
                    <button onclick="toggleChat()" aria-label="Close Chat">
                        <i class="fa fa-times"></i>
                    </button>
                </div>
            </div>
            <!-- Messages -->
            <div id="sc-messages"></div>
            <!-- Guest Form -->
            <div id="sc-form">
                <h3>Hi there 👋</h3>
                <h4>How can we help you?</h4>
                <p>To start the chat, please provide your name and email. Our support team will be with you shortly!</p>
                <input id="g-name" placeholder="Your name">
                <input id="g-email" placeholder="Email address">
                <button onclick="startChat()">
                    <i class="fa fa-paper-plane"></i> Start Chat
                </button>
            </div>
            <!-- Input -->
            <div id="sc-input">
                <input id="chat-text" placeholder="Type your message...">
                <button onclick="sendMessage()">
                    <i class="fa fa-paper-plane"></i>
                </button>
            </div>
        </div>
    </div>
</section>
<script>
    /* -----------------------------
    Sound (NEW)
    ------------------------------ */
    let chatBeep = null;

    function initChatBeep() {
        if (chatBeep) return;

        chatBeep = new Audio('/sounds/message.mp3');
        chatBeep.preload = 'auto';
    }

    function playChatBeep() {
        initChatBeep();

        try {
            chatBeep.currentTime = 0;
            chatBeep.play().catch(() => {
                // autoplay blocked – ignore
            });
        } catch {}
    }

    // enable sound after first interaction (browser-safe)
    document.addEventListener('click', initChatBeep, {
        once: true
    });
    document.addEventListener('keydown', initChatBeep, {
        once: true
    });
    /* -----------------------------
       State
    ------------------------------ */
    let conversationUuid = localStorage.getItem('support_uuid');
    let lastEventId = Number(localStorage.getItem('support_last_event_id') || 0);
    let lastMessageId = 0;
    let eventSource = null;
    const seenMessageIds = new Set();

    // NEW: date separator state
    let lastRenderedDateKey = null;

    // NEW: auth flag (needs meta)
    const isAuthenticated = document.querySelector('meta[name="sc-auth"]')?.content === '1';

    /* -----------------------------
       On page load
    ------------------------------ */
    document.addEventListener('DOMContentLoaded', () => {
        // Enter to send (NEW)
        const input = document.getElementById('chat-text');
        input.addEventListener('keydown', (e) => {
            if (e.key === 'Enter') {
                e.preventDefault();
                sendMessage();
            }
        });

        if (conversationUuid) {
            resumeChat();
        }
    });

    /* -----------------------------
       Toggle widget
    ------------------------------ */
    function toggleChat() {
        const box = document.getElementById('sc-box');
        const isOpen = box.style.display === 'flex';
        box.style.display = isOpen ? 'none' : 'flex';

        // NEW: if opening and user is logged in and no chat yet -> auto start (skip guest form)
        // if (!isOpen && !conversationUuid && isAuthenticated) {
        //     startChat(true);
        // }

    }

    /* -----------------------------
       Resume existing chat
    ------------------------------ */
    function resumeChat() {
        fetch('/support-chat/resume?uuid=' + conversationUuid)
            .then(r => r.json())
            .then(data => {

                // ❌ invalid or closed chat → reset
                if (!data.valid || data.status === 'closed') {
                    resetChatState();
                    return;
                }

                document.getElementById('sc-form').style.display = 'none';
                document.getElementById('sc-input').style.display = 'flex';

                const box = document.getElementById('sc-messages');
                box.innerHTML = '';
                lastRenderedDateKey = null;
                seenMessageIds.clear();

                data.messages.forEach(msg => {
                    addMessage(msg);
                    lastMessageId = msg.id;
                });

                scrollToBottom();
                startSSE();
            });
    }


    /* -----------------------------
       Start new chat
       - if skipForm=true: do not send name/email/phone
    ------------------------------ */

    function startChat(skipForm = false) {

        // 🔴 Client-side validation (only when form is visible)
        if (!isAuthenticated) {
            const nameInput = document.getElementById('g-name');
            const emailInput = document.getElementById('g-email');

            let hasError = false;

            // reset previous errors
            clearFieldError(nameInput);
            clearFieldError(emailInput);

            if (!nameInput.value.trim()) {
                showFieldError(nameInput, 'Name is required');
                hasError = true;
            }

            if (!emailInput.value.trim()) {
                showFieldError(emailInput, 'Email is required');
                hasError = true;
            } else if (!isValidEmail(emailInput.value.trim())) {
                showFieldError(emailInput, 'Please enter a valid email address');
                hasError = true;
            }

            if (hasError) {
                return; // ❌ stop chat start
            }
        }

        fetch('/support-chat/start', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').content
                },
                body: skipForm ? JSON.stringify({}) : JSON.stringify({
                    name: document.getElementById('g-name').value.trim(),
                    email: document.getElementById('g-email').value.trim(),
                    // phone: document.getElementById('g-phone').value.trim()
                })
            })
            .then(r => r.json())
            .then(d => {
                conversationUuid = d.uuid;
                localStorage.setItem('support_uuid', conversationUuid);

                document.getElementById('sc-form').style.display = 'none';
                document.getElementById('sc-input').style.display = 'flex';

                lastMessageId = 0;
                lastRenderedDateKey = null;

                fetchNewMessages();
                startSSE();
                if (d.waiting_for_agent) {
                    // call url to trigger AI join and agent notification after 1 minute of no agent assignment
                    setTimeout(() => {
                        fetch(`/join-ai-notify-agent/${conversationUuid}`);
                    }, 60000);
                }
            });
    }
    function isValidEmail(email) {
        const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        return emailPattern.test(email);
    }

    /* -----------------------------
       Validation helpers
    ------------------------------ */

    function showFieldError(input, message) {
        input.classList.add('sc-error');

        let error = input.nextElementSibling;
        if (!error || !error.classList.contains('sc-error-text')) {
            error = document.createElement('div');
            error.className = 'sc-error-text';
            input.after(error);
        }

        error.textContent = message;
    }

    function clearFieldError(input) {
        input.classList.remove('sc-error');

        const error = input.nextElementSibling;
        if (error && error.classList.contains('sc-error-text')) {
            error.remove();
        }
    }

    // auto-clear on typing
    ['g-name', 'g-email'].forEach(id => {
        const el = document.getElementById(id);
        if (el) {
            el.addEventListener('input', () => clearFieldError(el));
        }
    });


    /* -----------------------------
       Add message bubble (UPDATED)
       expects msg = {id, text, from, created_at}
    ------------------------------ */
    function addMessage(msg) {
        const messageId = msg?.id ?? null;

        // Prevent duplicates
        if (messageId && seenMessageIds.has(messageId)) return;
        if (messageId) seenMessageIds.add(messageId);

        const createdAt = msg.created_at ? new Date(msg.created_at) : new Date();
        const dateKey = createdAt.toDateString();

        // Date separator (already present in your code)
        if (dateKey !== lastRenderedDateKey) {
            const sep = document.createElement('div');
            sep.className = 'sc-date-sep';
            sep.innerText = formatDateLabel(createdAt);
            document.getElementById('sc-messages').appendChild(sep);
            lastRenderedDateKey = dateKey;
        }

        // SYSTEM MESSAGE
        if (msg.sender_type === 'system') {
            const div = document.createElement('div');
            div.className = 'sc-system';
            div.innerHTML = `
            <div>${escapeHtml(msg.text || '')}</div>
            <div class="sc-time">${formatTime(createdAt)}</div>
        `;
            document.getElementById('sc-messages').appendChild(div);
            scrollToBottom();
            return;
        }

        // USER / AGENT MESSAGE
        const row = document.createElement('div');
        row.className = `sc-row ${msg.from === 'user' ? 'sc-user-row' : ''}`;

        const avatar = document.createElement('div');
        avatar.className = `sc-avatar ${msg.from}`;
        avatar.innerText =
            msg.from === 'user' ? 'You' :
            msg.from === 'agent' ? (msg.sender_name?.[0] || 'A') :
            'S';

        const bubble = document.createElement('div');
        bubble.className = `sc-msg ${msg.from === 'user' ? 'sc-user' : 'sc-agent'}`;

        const senderName = msg.sender_name;

        bubble.innerHTML = `
        <div class="sc-name">${escapeHtml(senderName)}</div>
        <div>${escapeHtml(msg.text || '').replace(/\n/g, '<br>')}</div>
        <div class="sc-time">${formatTime(createdAt)}</div>
    `;

        row.appendChild(avatar);
        row.appendChild(bubble);

        document.getElementById('sc-messages').appendChild(row);
        scrollToBottom();
    }


    /* -----------------------------
       Scroll helper
    ------------------------------ */
    function scrollToBottom() {
        const box = document.getElementById('sc-messages');
        box.scrollTop = box.scrollHeight;
    }

    /* -----------------------------
       Send user message
    ------------------------------ */
    function sendMessage() {
        const input = document.getElementById('chat-text');
        const text = input.value.trim();
        if (!text || !conversationUuid) return;

        input.value = '';
        scrollToBottom();

        fetch('/support-chat/message', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').content
            },
            body: JSON.stringify({
                uuid: conversationUuid,
                message: text
            })
        });
    }

    /* -----------------------------
       Fetch new messages from DB
    ------------------------------ */
    function fetchNewMessages() {
        fetch(`/support-chat/messages?uuid=${conversationUuid}&after_id=${lastMessageId}`)
            .then(r => r.json())
            .then(data => {
                if (!data.messages || !data.messages.length) return;

                let shouldBeep = false;

                data.messages.forEach(msg => {
                    // 🔔 Beep only if message is from agent
                    if (msg.from !== 'user') {
                        shouldBeep = true;
                    }

                    addMessage(msg);
                    lastMessageId = msg.id;
                });

                if (shouldBeep) {
                    playChatBeep();
                    document.getElementById('sc-box').style.display = 'flex';
                }

                scrollToBottom();
            });
    }

    /* -----------------------------
       SSE: notify-only channel (PRESERVED)
    ------------------------------ */
    function startSSE() {
        if (!conversationUuid) return;

        if (eventSource) {
            eventSource.close();
            eventSource = null;
        }

        eventSource = new EventSource(
            `/support-chat/events?uuid=${conversationUuid}&last_id=${lastEventId}`
        );

        // MUST listen to named event (PRESERVED)
        eventSource.addEventListener('message', function(e) {
            // advance event cursor
            if (e.lastEventId) {
                lastEventId = Number(e.lastEventId);
                localStorage.setItem('support_last_event_id', lastEventId);
            }

            fetchNewMessages();
        });

        eventSource.onerror = function() {
            if (eventSource) {
                eventSource.close();
                eventSource = null;
            }
            setTimeout(startSSE, 3000);
        };
    }

    /* -----------------------------
       Formatting helpers (NEW)
    ------------------------------ */
    function formatDateLabel(d) {
        const today = new Date();
        const startOfToday = new Date(today.getFullYear(), today.getMonth(), today.getDate());
        const startOfThatDay = new Date(d.getFullYear(), d.getMonth(), d.getDate());
        const diffDays = Math.round((startOfToday - startOfThatDay) / 86400000);

        if (diffDays === 0) return 'Today';
        if (diffDays === 1) return 'Yesterday';

        return d.toLocaleDateString(undefined, {
            month: 'short',
            day: 'numeric',
            year: 'numeric'
        });
    }

    function formatTime(d) {
        return d.toLocaleTimeString([], {
            hour: '2-digit',
            minute: '2-digit'
        });
    }

    // basic escape for safety
    function escapeHtml(str) {
        return str
            .replace(/&/g, '&amp;')
            .replace(/</g, '&lt;')
            .replace(/>/g, '&gt;')
            .replace(/"/g, '&quot;')
            .replace(/'/g, '&#039;');
    }

    function resetChatState() {
        localStorage.removeItem('support_uuid');
        localStorage.removeItem('support_last_event_id');
        conversationUuid = null;
        lastEventId = 0;
    }

    document.addEventListener('DOMContentLoaded', () => {
        const isAuthenticated =
            document.querySelector('meta[name="sc-auth"]')?.content === '1';

        if (isAuthenticated) {
            document.getElementById('g-name').style.display = 'none';
            document.getElementById('g-email').style.display = 'none';
            // document.getElementById('g-phone').style.display = 'none';
        }

        if (conversationUuid) {
            resumeChat();
        }
    });

    function endChat() {
        if (!conversationUuid) return;

        if (!confirm('Are you sure you want to end this chat?')) return;

        fetch('/support-chat/end', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').content
                },
                body: JSON.stringify({
                    uuid: conversationUuid
                })
            })
            .then(() => {
                resetChatUI();
            });
    }

    function resetChatUI() {
        resetChatState();

        document.getElementById('sc-messages').innerHTML = '';
        document.getElementById('sc-input').style.display = 'none';
        document.getElementById('sc-form').style.display = 'block';

        if (eventSource) {
            eventSource.close();
            eventSource = null;
        }
    }
</script>


{{-- <style>
    #sc-widget {
        position: fixed;
        bottom: 60px;
        right: 5px;
        z-index: 9999;
        font-family: Arial, sans-serif;
    }

    /* System message */
    .sc-system {
        max-width: 100%;
        margin: 12px auto;
        padding: 4px 10px;
        font-size: 12px;
        color: #6b7280;
        text-align: center;
        background: transparent;
    }

    /* Time under system message */
    .sc-system .sc-time {
        font-size: 11px;
        margin-top: 2px;
        color: #9ca3af;
    }

    .sc-error {
        border-color: #dc2626 !important;
    }

    .sc-error-text {
        color: #dc2626;
        font-size: 12px;
        margin-top: 4px;
    }


    /* Floating button */
    #sc-toggle {
        width: 56px;
        height: 56px;
        border-radius: 50%;
        background: linear-gradient(135deg, #c16211, #f38522);
        color: white;
        border: none;
        cursor: pointer;
        box-shadow: 0 12px 30px rgba(0, 0, 0, 0.25);
        font-size: 22px;
    }

    /* Chat box */
    #sc-box {
        width: 340px;
        height: 460px;
        background: #fff;
        border-radius: 12px;
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.2);
        display: none;
        flex-direction: column;
        overflow: hidden;
        margin-bottom: 12px;
    }

    /* Header */
    #sc-header {
        background: linear-gradient(135deg, #c16211, #f38522);
        color: white;
        padding: 14px;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    #sc-header button {
        background: none;
        border: none;
        color: white;
        cursor: pointer;
    }

    /* Messages */
    #sc-messages {
        flex: 1;
        padding: 12px;
        overflow-y: auto;
        background: #f9fafb;
    }

    /* Date separator (NEW) */
    .sc-date-sep {
        text-align: center;
        font-size: 12px;
        color: #6b7280;
        margin: 12px 0;
        user-select: none;
    }

    /* Message bubbles */
    .sc-msg {
        max-width: 75%;
        margin-bottom: 10px;
        padding: 10px 12px;
        border-radius: 14px;
        font-size: 14px;
        line-height: 1.4;
        /*white-space: pre-wrap;*/
        word-break: break-word;
    }

    .sc-user {
        background: #0074a3;
        color: white;
        margin-left: auto;
        border-bottom-right-radius: 4px;
    }

    .sc-agent {
        background: #e5e7eb;
        color: #111827;
        margin-right: auto;
        border-bottom-left-radius: 4px;
    }

    /* Time under bubble (NEW) */
    .sc-time {
        font-size: 11px;
        margin-top: 6px;
        opacity: 0.8;
        user-select: none;
    }

    .sc-user .sc-time {
        color: rgba(255, 255, 255, 0.85);
        text-align: right;
    }

    .sc-agent .sc-time {
        color: #374151;
        text-align: left;
    }

    /* Guest form */
    #sc-form {
        padding: 12px;
    }

    #sc-form input {
        width: 100%;
        padding: 8px;
        margin-bottom: 8px;
        border-radius: 6px;
        border: 1px solid #d1d5db;
    }

    #sc-form button {
        width: 100%;
        padding: 10px;
        background: linear-gradient(135deg, #c16211, #f38522);
        color: white;
        border: none;
        border-radius: 6px;
        cursor: pointer;
    }

    /* Message input */
    #sc-input {
        padding: 10px;
        border-top: 1px solid #e5e7eb;
        display: none;
        /* keep correct */
        gap: 6px;
    }

    #sc-input input {
        flex: 1;
        padding: 10px;
        border-radius: 20px;
        border: 1px solid #d1d5db;
    }

    #sc-input button {
        background: #0074a3;
        border: none;
        color: white;
        width: 40px;
        height: 40px;
        border-radius: 50%;
        cursor: pointer;
    }

    /* Message row */
    .sc-row {
        display: flex;
        align-items: flex-start;
        gap: 8px;
        margin-bottom: 10px;
    }

    .sc-row.sc-user-row {
        flex-direction: row-reverse;
    }

    /* Avatar */
    .sc-avatar {
        width: 32px;
        height: 32px;
        border-radius: 50%;
        background: #9ca3af;
        color: white;
        font-size: 14px;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
        user-select: none;
    }

    .sc-avatar.agent {
        background: #2563eb;
    }

    .sc-avatar.user {
        background: #0074a3;
        font-size: 12px;
    }

    .sc-avatar.system {
        background: #6b7280;
    }

    /* Name label */
    .sc-name {
        font-size: 12px;
        font-weight: 600;
        margin-bottom: 4px;
        color: #374151;
    }

    .sc-user .sc-name {
        text-align: right;
        color: rgba(255, 255, 255, 0.9);
    }
</style> --}}
{{-- <section class="chat_icon">
    <div id="sc-widget">
        <!-- Floating Button -->
        <button id="sc-toggle" aria-label="Open Chat" onclick="toggleChat()">
            <i class="fa fa-comments"></i>
        </button>
        <!-- Chat Box -->
        <div id="sc-box">
            <!-- Header -->
            <div id="sc-header">
                <div>
                    EzeAD Live Chat<br>
                    <small>We are here to help 24/7</small>
                </div>
                <div style="display:flex; gap:10px;">
                    <button onclick="endChat()" title="End chat" aria-label="End Chat">
                        <i class="fa fa-sign-out-alt"></i>
                    </button>
                    <button onclick="toggleChat()" aria-label="Close Chat">
                        <i class="fa fa-times"></i>
                    </button>
                </div>
            </div>
            <!-- Messages -->
            <div id="sc-messages"></div>
            <!-- Guest Form -->
            <div id="sc-form">
                <h3 class="text-center">Hi there 👋</h3>
                <h4 class="p-3">How can we help you?</h4>
                <p class="p-3 p-1">To start the chat, please provide your name and email. Our support team will be with
                    you shortly!</p>
                <input id="g-name" placeholder="Your name">
                <input id="g-email" placeholder="Email address">
                <button onclick="startChat()">
                    <i class="fa fa-paper-plane"></i> Start Chat
                </button>
            </div>
            <!-- Input -->
            <div id="sc-input">
                <input id="chat-text" placeholder="Type your message...">
                <button onclick="sendMessage()">
                    <i class="fa fa-paper-plane"></i>
                </button>
            </div>
        </div>
    </div>
</section> --}}
{{-- <script>
        /* -----------------------------
            Sound (NEW)
            ------------------------------ */
        let chatBeep = null;

        function initChatBeep() {
            if (chatBeep) return;

            chatBeep = new Audio('/sounds/message.mp3');
            chatBeep.preload = 'auto';
        }

        function playChatBeep() {
            initChatBeep();

            try {
                chatBeep.currentTime = 0;
                chatBeep.play().catch(() => {
                    // autoplay blocked – ignore
                });
            } catch {}
        }

        // enable sound after first interaction (browser-safe)
        document.addEventListener('click', initChatBeep, {
            once: true
        });
        document.addEventListener('keydown', initChatBeep, {
            once: true
        });
        /* -----------------------------
           State
        ------------------------------ */
        let conversationUuid = localStorage.getItem('support_uuid');
        let lastEventId = Number(localStorage.getItem('support_last_event_id') || 0);
        let lastMessageId = 0;
        let eventSource = null;
        const seenMessageIds = new Set();

        // NEW: date separator state
        let lastRenderedDateKey = null;

        // NEW: auth flag (needs meta)
        const isAuthenticated = document.querySelector('meta[name="sc-auth"]')?.content === '1';

        /* -----------------------------
           On page load
        ------------------------------ */
        document.addEventListener('DOMContentLoaded', () => {
            // Enter to send (NEW)
            const input = document.getElementById('chat-text');
            input.addEventListener('keydown', (e) => {
                if (e.key === 'Enter') {
                    e.preventDefault();
                    sendMessage();
                }
            });

            if (conversationUuid) {
                resumeChat();
            }
        });

        /* -----------------------------
           Toggle widget
        ------------------------------ */
        function toggleChat() {
            const box = document.getElementById('sc-box');
            const isOpen = box.style.display === 'flex';
            box.style.display = isOpen ? 'none' : 'flex';

            // NEW: if opening and user is logged in and no chat yet -> auto start (skip guest form)
            // if (!isOpen && !conversationUuid && isAuthenticated) {
            //     startChat(true);
            // }

        }

        /* -----------------------------
           Resume existing chat
        ------------------------------ */
        function resumeChat() {
            fetch('/support-chat/resume?uuid=' + conversationUuid)
                .then(r => r.json())
                .then(data => {

                    // ❌ invalid or closed chat → reset
                    if (!data.valid || data.status === 'closed') {
                        resetChatState();
                        return;
                    }

                    document.getElementById('sc-form').style.display = 'none';
                    document.getElementById('sc-input').style.display = 'flex';

                    const box = document.getElementById('sc-messages');
                    box.innerHTML = '';
                    lastRenderedDateKey = null;
                    seenMessageIds.clear();

                    data.messages.forEach(msg => {
                        addMessage(msg);
                        lastMessageId = msg.id;
                    });

                    scrollToBottom();
                    startSSE();
                });
        }


        /* -----------------------------
           Start new chat
           - if skipForm=true: do not send name/email/phone
        ------------------------------ */

        function startChat(skipForm = false) {

            // 🔴 Client-side validation (only when form is visible)
            if (!isAuthenticated) {
                const nameInput = document.getElementById('g-name');
                const emailInput = document.getElementById('g-email');

                let hasError = false;

                // reset previous errors
                clearFieldError(nameInput);
                clearFieldError(emailInput);

                if (!nameInput.value.trim()) {
                    showFieldError(nameInput, 'Name is required');
                    hasError = true;
                }

                if (!emailInput.value.trim()) {
                    showFieldError(emailInput, 'Email is required');
                    hasError = true;
                }

                if (hasError) {
                    return; // ❌ stop chat start
                }
            }

            fetch('/support-chat/start', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').content
                    },
                    body: skipForm ? JSON.stringify({}) : JSON.stringify({
                        name: document.getElementById('g-name').value.trim(),
                        email: document.getElementById('g-email').value.trim(),
                        // phone: document.getElementById('g-phone').value.trim()
                    })
                })
                .then(r => r.json())
                .then(d => {
                    conversationUuid = d.uuid;
                    localStorage.setItem('support_uuid', conversationUuid);

                    document.getElementById('sc-form').style.display = 'none';
                    document.getElementById('sc-input').style.display = 'flex';

                    lastMessageId = 0;
                    lastRenderedDateKey = null;

                    fetchNewMessages();
                    startSSE();
                    if (d.waiting_for_agent) {
                        // call url to trigger AI join and agent notification after 1 minute of no agent assignment
                        setTimeout(() => {
                            fetch(`/join-ai-notify-agent/${conversationUuid}`);
                        }, 60000);
                    }
                });
        }

        /* -----------------------------
           Validation helpers
        ------------------------------ */

        function showFieldError(input, message) {
            input.classList.add('sc-error');

            let error = input.nextElementSibling;
            if (!error || !error.classList.contains('sc-error-text')) {
                error = document.createElement('div');
                error.className = 'sc-error-text';
                input.after(error);
            }

            error.textContent = message;
        }

        function clearFieldError(input) {
            input.classList.remove('sc-error');

            const error = input.nextElementSibling;
            if (error && error.classList.contains('sc-error-text')) {
                error.remove();
            }
        }

        // auto-clear on typing
        ['g-name', 'g-email'].forEach(id => {
            const el = document.getElementById(id);
            if (el) {
                el.addEventListener('input', () => clearFieldError(el));
            }
        });


        /* -----------------------------
           Add message bubble (UPDATED)
           expects msg = {id, text, from, created_at}
        ------------------------------ */
        function addMessage(msg) {
            const messageId = msg?.id ?? null;

            // Prevent duplicates
            if (messageId && seenMessageIds.has(messageId)) return;
            if (messageId) seenMessageIds.add(messageId);

            const createdAt = msg.created_at ? new Date(msg.created_at) : new Date();
            const dateKey = createdAt.toDateString();

            // Date separator (already present in your code)
            if (dateKey !== lastRenderedDateKey) {
                const sep = document.createElement('div');
                sep.className = 'sc-date-sep';
                sep.innerText = formatDateLabel(createdAt);
                document.getElementById('sc-messages').appendChild(sep);
                lastRenderedDateKey = dateKey;
            }

            // SYSTEM MESSAGE
            if (msg.sender_type === 'system') {
                const div = document.createElement('div');
                div.className = 'sc-system';
                div.innerHTML = `
            <div>${escapeHtml(msg.text || '')}</div>
            <div class="sc-time">${formatTime(createdAt)}</div>
        `;
                document.getElementById('sc-messages').appendChild(div);
                scrollToBottom();
                return;
            }

            // USER / AGENT MESSAGE
            const row = document.createElement('div');
            row.className = `sc-row ${msg.from === 'user' ? 'sc-user-row' : ''}`;

            const avatar = document.createElement('div');
            avatar.className = `sc-avatar ${msg.from}`;
            avatar.innerText =
                msg.from === 'user' ? 'You' :
                msg.from === 'agent' ? (msg.sender_name?.[0] || 'A') :
                'S';

            const bubble = document.createElement('div');
            bubble.className = `sc-msg ${msg.from === 'user' ? 'sc-user' : 'sc-agent'}`;

            const senderName = msg.sender_name;

            bubble.innerHTML = `
        <div class="sc-name">${escapeHtml(senderName)}</div>
        <div>${escapeHtml(msg.text || '').replace(/\n/g, '<br>')}</div>
        <div class="sc-time">${formatTime(createdAt)}</div>
    `;

            row.appendChild(avatar);
            row.appendChild(bubble);

            document.getElementById('sc-messages').appendChild(row);
            scrollToBottom();
        }


        /* -----------------------------
           Scroll helper
        ------------------------------ */
        function scrollToBottom() {
            const box = document.getElementById('sc-messages');
            box.scrollTop = box.scrollHeight;
        }

        /* -----------------------------
           Send user message
        ------------------------------ */
        function sendMessage() {
            const input = document.getElementById('chat-text');
            const text = input.value.trim();
            if (!text || !conversationUuid) return;

            input.value = '';
            scrollToBottom();

            fetch('/support-chat/message', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').content
                },
                body: JSON.stringify({
                    uuid: conversationUuid,
                    message: text
                })
            });
        }

        /* -----------------------------
           Fetch new messages from DB
        ------------------------------ */
        function fetchNewMessages() {
            fetch(`/support-chat/messages?uuid=${conversationUuid}&after_id=${lastMessageId}`)
                .then(r => r.json())
                .then(data => {
                    if (!data.messages || !data.messages.length) return;

                    let shouldBeep = false;

                    data.messages.forEach(msg => {
                        // 🔔 Beep only if message is from agent
                        if (msg.from !== 'user') {
                            shouldBeep = true;
                        }

                        addMessage(msg);
                        lastMessageId = msg.id;
                    });

                    if (shouldBeep) {
                        playChatBeep();
                        document.getElementById('sc-box').style.display = 'flex';
                    }

                    scrollToBottom();
                });
        }

        /* -----------------------------
           SSE: notify-only channel (PRESERVED)
        ------------------------------ */
        function startSSE() {
            if (!conversationUuid) return;

            if (eventSource) {
                eventSource.close();
                eventSource = null;
            }

            eventSource = new EventSource(
                `/support-chat/events?uuid=${conversationUuid}&last_id=${lastEventId}`
            );

            // MUST listen to named event (PRESERVED)
            eventSource.addEventListener('message', function(e) {
                // advance event cursor
                if (e.lastEventId) {
                    lastEventId = Number(e.lastEventId);
                    localStorage.setItem('support_last_event_id', lastEventId);
                }

                fetchNewMessages();
            });

            eventSource.onerror = function() {
                if (eventSource) {
                    eventSource.close();
                    eventSource = null;
                }
                setTimeout(startSSE, 3000);
            };
        }

        /* -----------------------------
           Formatting helpers (NEW)
        ------------------------------ */
        function formatDateLabel(d) {
            const today = new Date();
            const startOfToday = new Date(today.getFullYear(), today.getMonth(), today.getDate());
            const startOfThatDay = new Date(d.getFullYear(), d.getMonth(), d.getDate());
            const diffDays = Math.round((startOfToday - startOfThatDay) / 86400000);

            if (diffDays === 0) return 'Today';
            if (diffDays === 1) return 'Yesterday';

            return d.toLocaleDateString(undefined, {
                month: 'short',
                day: 'numeric',
                year: 'numeric'
            });
        }

        function formatTime(d) {
            return d.toLocaleTimeString([], {
                hour: '2-digit',
                minute: '2-digit'
            });
        }

        // basic escape for safety
        function escapeHtml(str) {
            return str
                .replace(/&/g, '&amp;')
                .replace(/</g, '&lt;')
                .replace(/>/g, '&gt;')
                .replace(/"/g, '&quot;')
                .replace(/'/g, '&#039;');
        }

        function resetChatState() {
            localStorage.removeItem('support_uuid');
            localStorage.removeItem('support_last_event_id');
            conversationUuid = null;
            lastEventId = 0;
        }

        document.addEventListener('DOMContentLoaded', () => {
            const isAuthenticated =
                document.querySelector('meta[name="sc-auth"]')?.content === '1';

            if (isAuthenticated) {
                document.getElementById('g-name').style.display = 'none';
                document.getElementById('g-email').style.display = 'none';
                // document.getElementById('g-phone').style.display = 'none';
            }

            if (conversationUuid) {
                resumeChat();
            }
        });

        function endChat() {
            if (!conversationUuid) return;

            if (!confirm('Are you sure you want to end this chat?')) return;

            fetch('/support-chat/end', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').content
                    },
                    body: JSON.stringify({
                        uuid: conversationUuid
                    })
                })
                .then(() => {
                    resetChatUI();
                });
        }

        function resetChatUI() {
            resetChatState();

            document.getElementById('sc-messages').innerHTML = '';
            document.getElementById('sc-input').style.display = 'none';
            document.getElementById('sc-form').style.display = 'block';

            if (eventSource) {
                eventSource.close();
                eventSource = null;
            }
        }
    </script> --}}

{{-- <style>
    #sc-widget {
        position: fixed;
        bottom: 60px;
        right: 5px;
        z-index: 9999;
        font-family: Arial, sans-serif;
    }

    /* System message */
    .sc-system {
        max-width: 100%;
        margin: 12px auto;
        padding: 4px 10px;
        font-size: 12px;
        color: #6b7280;
        text-align: center;
        background: transparent;
    }

    /* Time under system message */
    .sc-system .sc-time {
        font-size: 11px;
        margin-top: 2px;
        color: #9ca3af;
    }

    .sc-error {
        border-color: #dc2626 !important;
    }

    .sc-error-text {
        color: #dc2626;
        font-size: 12px;
        margin-top: 4px;
    }


    /* Floating button */
    #sc-toggle {
        width: 56px;
        height: 56px;
        border-radius: 50%;
        background: linear-gradient(135deg, #c16211, #f38522);
        color: white;
        border: none;
        cursor: pointer;
        box-shadow: 0 12px 30px rgba(0, 0, 0, 0.25);
        font-size: 22px;
    }

    /* Chat box */
    #sc-box {
        width: 340px;
        height: 460px;
        background: #fff;
        border-radius: 12px;
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.2);
        display: none;
        flex-direction: column;
        overflow: hidden;
        margin-bottom: 12px;
    }

    /* Header */
    #sc-header {
        background: linear-gradient(135deg, #c16211, #f38522);
        color: white;
        padding: 14px;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    #sc-header button {
        background: none;
        border: none;
        color: white;
        cursor: pointer;
    }

    /* Messages */
    #sc-messages {
        flex: 1;
        padding: 12px;
        overflow-y: auto;
        background: #f9fafb;
    }

    /* Date separator (NEW) */
    .sc-date-sep {
        text-align: center;
        font-size: 12px;
        color: #6b7280;
        margin: 12px 0;
        user-select: none;
    }

    /* Message bubbles */
    .sc-msg {
        max-width: 75%;
        margin-bottom: 10px;
        padding: 10px 12px;
        border-radius: 14px;
        font-size: 14px;
        line-height: 1.4;
        /*white-space: pre-wrap;*/
        word-break: break-word;
    }

    .sc-user {
        background: #0074a3;
        color: white;
        margin-left: auto;
        border-bottom-right-radius: 4px;
    }

    .sc-agent {
        background: #e5e7eb;
        color: #111827;
        margin-right: auto;
        border-bottom-left-radius: 4px;
    }

    /* Time under bubble (NEW) */
    .sc-time {
        font-size: 11px;
        margin-top: 6px;
        opacity: 0.8;
        user-select: none;
    }

    .sc-user .sc-time {
        color: rgba(255, 255, 255, 0.85);
        text-align: right;
    }

    .sc-agent .sc-time {
        color: #374151;
        text-align: left;
    }

    /* Guest form */
    #sc-form {
        padding: 12px;
    }

    #sc-form input {
        width: 100%;
        padding: 8px;
        margin-bottom: 8px;
        border-radius: 6px;
        border: 1px solid #d1d5db;
    }

    #sc-form button {
        width: 100%;
        padding: 10px;
        background: linear-gradient(135deg, #c16211, #f38522);
        color: white;
        border: none;
        border-radius: 6px;
        cursor: pointer;
    }

    /* Message input */
    #sc-input {
        padding: 10px;
        border-top: 1px solid #e5e7eb;
        display: none;
        /* keep correct */
        gap: 6px;
    }

    #sc-input input {
        flex: 1;
        padding: 10px;
        border-radius: 20px;
        border: 1px solid #d1d5db;
    }

    #sc-input button {
        background: #0074a3;
        border: none;
        color: white;
        width: 40px;
        height: 40px;
        border-radius: 50%;
        cursor: pointer;
    }

    /* Message row */
    .sc-row {
        display: flex;
        align-items: flex-start;
        gap: 8px;
        margin-bottom: 10px;
    }

    .sc-row.sc-user-row {
        flex-direction: row-reverse;
    }

    /* Avatar */
    .sc-avatar {
        width: 32px;
        height: 32px;
        border-radius: 50%;
        background: #9ca3af;
        color: white;
        font-size: 14px;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
        user-select: none;
    }

    .sc-avatar.agent {
        background: #2563eb;
    }

    .sc-avatar.user {
        background: #0074a3;
        font-size: 12px;
    }

    .sc-avatar.system {
        background: #6b7280;
    }

    /* Name label */
    .sc-name {
        font-size: 12px;
        font-weight: 600;
        margin-bottom: 4px;
        color: #374151;
    }

    .sc-user .sc-name {
        text-align: right;
        color: rgba(255, 255, 255, 0.9);
    }
</style>
<div id="sc-widget">
    <!-- Floating Button -->
    <button id="sc-toggle" onclick="toggleChat()">
        <i class="fa fa-comments"></i>
    </button>

    <!-- Chat Box -->
    <div id="sc-box">
        <!-- Header -->
        <div id="sc-header">
            <div>
                EzeAD Live Chat<br>
                <small>We are here to help 24/7</small>
            </div>
            <div style="display:flex; gap:10px;">
                <button onclick="endChat()" title="End chat">
                    <i class="fa fa-sign-out-alt"></i>
                </button>
                <button onclick="toggleChat()">
                    <i class="fa fa-times"></i>
                </button>
            </div>
        </div>

        <!-- Messages -->
        <div id="sc-messages"></div>

        <!-- Guest Form -->
        <div id="sc-form">
            <h3 class="text-center">Hi there 👋</h3>
            <h4 class="p-3">How can we help you?</h4>
            <p class="p-3 p-1">To start the chat, please provide your name and email. Our support team will be with you
                shortly!</p>
            <input id="g-name" placeholder="Your name">
            <input id="g-email" placeholder="Email address">
            <button onclick="startChat()">
                <i class="fa fa-paper-plane"></i> Start Chat
            </button>
        </div>


        <!-- Input -->
        <div id="sc-input">
            <input id="chat-text" placeholder="Type your message...">
            <button onclick="sendMessage()">
                <i class="fa fa-paper-plane"></i>
            </button>
        </div>
    </div>
</div>
<script>
    /* -----------------------------
    Sound (NEW)
    ------------------------------ */
    let chatBeep = null;

    function initChatBeep() {
        if (chatBeep) return;

        chatBeep = new Audio('/sounds/message.mp3');
        chatBeep.preload = 'auto';
    }

    function playChatBeep() {
        initChatBeep();

        try {
            chatBeep.currentTime = 0;
            chatBeep.play().catch(() => {
                // autoplay blocked – ignore
            });
        } catch {}
    }

    // enable sound after first interaction (browser-safe)
    document.addEventListener('click', initChatBeep, {
        once: true
    });
    document.addEventListener('keydown', initChatBeep, {
        once: true
    });
    /* -----------------------------
       State
    ------------------------------ */
    let conversationUuid = localStorage.getItem('support_uuid');
    let lastEventId = Number(localStorage.getItem('support_last_event_id') || 0);
    let lastMessageId = 0;
    let eventSource = null;
    const seenMessageIds = new Set();

    // NEW: date separator state
    let lastRenderedDateKey = null;

    // NEW: auth flag (needs meta)
    const isAuthenticated = document.querySelector('meta[name="sc-auth"]')?.content === '1';

    /* -----------------------------
       On page load
    ------------------------------ */
    document.addEventListener('DOMContentLoaded', () => {
        // Enter to send (NEW)
        const input = document.getElementById('chat-text');
        input.addEventListener('keydown', (e) => {
            if (e.key === 'Enter') {
                e.preventDefault();
                sendMessage();
            }
        });

        if (conversationUuid) {
            resumeChat();
        }
    });

    /* -----------------------------
       Toggle widget
    ------------------------------ */
    function toggleChat() {
        const box = document.getElementById('sc-box');
        const isOpen = box.style.display === 'flex';
        box.style.display = isOpen ? 'none' : 'flex';

        // NEW: if opening and user is logged in and no chat yet -> auto start (skip guest form)
        // if (!isOpen && !conversationUuid && isAuthenticated) {
        //     startChat(true);
        // }

    }

    /* -----------------------------
       Resume existing chat
    ------------------------------ */
    function resumeChat() {
        fetch('/support-chat/resume?uuid=' + conversationUuid)
            .then(r => r.json())
            .then(data => {

                // ❌ invalid or closed chat → reset
                if (!data.valid || data.status === 'closed') {
                    resetChatState();
                    return;
                }

                document.getElementById('sc-form').style.display = 'none';
                document.getElementById('sc-input').style.display = 'flex';

                const box = document.getElementById('sc-messages');
                box.innerHTML = '';
                lastRenderedDateKey = null;
                seenMessageIds.clear();

                data.messages.forEach(msg => {
                    addMessage(msg);
                    lastMessageId = msg.id;
                });

                scrollToBottom();
                startSSE();
            });
    }


    /* -----------------------------
       Start new chat
       - if skipForm=true: do not send name/email/phone
    ------------------------------ */

    function startChat(skipForm = false) {

        // 🔴 Client-side validation (only when form is visible)
        if (!isAuthenticated) {
            const nameInput = document.getElementById('g-name');
            const emailInput = document.getElementById('g-email');

            let hasError = false;

            // reset previous errors
            clearFieldError(nameInput);
            clearFieldError(emailInput);

            if (!nameInput.value.trim()) {
                showFieldError(nameInput, 'Name is required');
                hasError = true;
            }

            if (!emailInput.value.trim()) {
                showFieldError(emailInput, 'Email is required');
                hasError = true;
            }

            if (hasError) {
                return; // ❌ stop chat start
            }
        }

        fetch('/support-chat/start', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').content
                },
                body: skipForm ? JSON.stringify({}) : JSON.stringify({
                    name: document.getElementById('g-name').value.trim(),
                    email: document.getElementById('g-email').value.trim(),
                    // phone: document.getElementById('g-phone').value.trim()
                })
            })
            .then(r => r.json())
            .then(d => {
                conversationUuid = d.uuid;
                localStorage.setItem('support_uuid', conversationUuid);

                document.getElementById('sc-form').style.display = 'none';
                document.getElementById('sc-input').style.display = 'flex';

                lastMessageId = 0;
                lastRenderedDateKey = null;

                fetchNewMessages();
                startSSE();
                if (d.waiting_for_agent) {
                    // call url to trigger AI join and agent notification after 1 minute of no agent assignment
                    setTimeout(() => {
                        fetch(`/join-ai-notify-agent/${conversationUuid}`);
                    }, 60000);
                }
            });
    }

    /* -----------------------------
       Validation helpers
    ------------------------------ */

    function showFieldError(input, message) {
        input.classList.add('sc-error');

        let error = input.nextElementSibling;
        if (!error || !error.classList.contains('sc-error-text')) {
            error = document.createElement('div');
            error.className = 'sc-error-text';
            input.after(error);
        }

        error.textContent = message;
    }

    function clearFieldError(input) {
        input.classList.remove('sc-error');

        const error = input.nextElementSibling;
        if (error && error.classList.contains('sc-error-text')) {
            error.remove();
        }
    }

    // auto-clear on typing
    ['g-name', 'g-email'].forEach(id => {
        const el = document.getElementById(id);
        if (el) {
            el.addEventListener('input', () => clearFieldError(el));
        }
    });


    /* -----------------------------
       Add message bubble (UPDATED)
       expects msg = {id, text, from, created_at}
    ------------------------------ */
    function addMessage(msg) {
        const messageId = msg?.id ?? null;

        // Prevent duplicates
        if (messageId && seenMessageIds.has(messageId)) return;
        if (messageId) seenMessageIds.add(messageId);

        const createdAt = msg.created_at ? new Date(msg.created_at) : new Date();
        const dateKey = createdAt.toDateString();

        // Date separator (already present in your code)
        if (dateKey !== lastRenderedDateKey) {
            const sep = document.createElement('div');
            sep.className = 'sc-date-sep';
            sep.innerText = formatDateLabel(createdAt);
            document.getElementById('sc-messages').appendChild(sep);
            lastRenderedDateKey = dateKey;
        }

        // SYSTEM MESSAGE
        if (msg.sender_type === 'system') {
            const div = document.createElement('div');
            div.className = 'sc-system';
            div.innerHTML = `
            <div>${escapeHtml(msg.text || '')}</div>
            <div class="sc-time">${formatTime(createdAt)}</div>
        `;
            document.getElementById('sc-messages').appendChild(div);
            scrollToBottom();
            return;
        }

        // USER / AGENT MESSAGE
        const row = document.createElement('div');
        row.className = `sc-row ${msg.from === 'user' ? 'sc-user-row' : ''}`;

        const avatar = document.createElement('div');
        avatar.className = `sc-avatar ${msg.from}`;
        avatar.innerText =
            msg.from === 'user' ? 'You' :
            msg.from === 'agent' ? (msg.sender_name?.[0] || 'A') :
            'S';

        const bubble = document.createElement('div');
        bubble.className = `sc-msg ${msg.from === 'user' ? 'sc-user' : 'sc-agent'}`;

        const senderName = msg.sender_name;

        bubble.innerHTML = `
        <div class="sc-name">${escapeHtml(senderName)}</div>
        <div>${escapeHtml(msg.text || '').replace(/\n/g, '<br>')}</div>
        <div class="sc-time">${formatTime(createdAt)}</div>
    `;

        row.appendChild(avatar);
        row.appendChild(bubble);

        document.getElementById('sc-messages').appendChild(row);
        scrollToBottom();
    }


    /* -----------------------------
       Scroll helper
    ------------------------------ */
    function scrollToBottom() {
        const box = document.getElementById('sc-messages');
        box.scrollTop = box.scrollHeight;
    }

    /* -----------------------------
       Send user message
    ------------------------------ */
    function sendMessage() {
        const input = document.getElementById('chat-text');
        const text = input.value.trim();
        if (!text || !conversationUuid) return;

        input.value = '';
        scrollToBottom();

        fetch('/support-chat/message', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').content
            },
            body: JSON.stringify({
                uuid: conversationUuid,
                message: text
            })
        });
    }

    /* -----------------------------
       Fetch new messages from DB
    ------------------------------ */
    function fetchNewMessages() {
        fetch(`/support-chat/messages?uuid=${conversationUuid}&after_id=${lastMessageId}`)
            .then(r => r.json())
            .then(data => {
                if (!data.messages || !data.messages.length) return;

                let shouldBeep = false;

                data.messages.forEach(msg => {
                    // 🔔 Beep only if message is from agent
                    if (msg.from !== 'user') {
                        shouldBeep = true;
                    }

                    addMessage(msg);
                    lastMessageId = msg.id;
                });

                if (shouldBeep) {
                    playChatBeep();
                    document.getElementById('sc-box').style.display = 'flex';
                }

                scrollToBottom();
            });
    }

    /* -----------------------------
       SSE: notify-only channel (PRESERVED)
    ------------------------------ */
    function startSSE() {
        if (!conversationUuid) return;

        if (eventSource) {
            eventSource.close();
            eventSource = null;
        }

        eventSource = new EventSource(
            `/support-chat/events?uuid=${conversationUuid}&last_id=${lastEventId}`
        );

        // MUST listen to named event (PRESERVED)
        eventSource.addEventListener('message', function(e) {
            // advance event cursor
            if (e.lastEventId) {
                lastEventId = Number(e.lastEventId);
                localStorage.setItem('support_last_event_id', lastEventId);
            }

            fetchNewMessages();
        });

        eventSource.onerror = function() {
            if (eventSource) {
                eventSource.close();
                eventSource = null;
            }
            setTimeout(startSSE, 3000);
        };
    }

    /* -----------------------------
       Formatting helpers (NEW)
    ------------------------------ */
    function formatDateLabel(d) {
        const today = new Date();
        const startOfToday = new Date(today.getFullYear(), today.getMonth(), today.getDate());
        const startOfThatDay = new Date(d.getFullYear(), d.getMonth(), d.getDate());
        const diffDays = Math.round((startOfToday - startOfThatDay) / 86400000);

        if (diffDays === 0) return 'Today';
        if (diffDays === 1) return 'Yesterday';

        return d.toLocaleDateString(undefined, {
            month: 'short',
            day: 'numeric',
            year: 'numeric'
        });
    }

    function formatTime(d) {
        return d.toLocaleTimeString([], {
            hour: '2-digit',
            minute: '2-digit'
        });
    }

    // basic escape for safety
    function escapeHtml(str) {
        return str
            .replace(/&/g, '&amp;')
            .replace(/</g, '&lt;')
            .replace(/>/g, '&gt;')
            .replace(/"/g, '&quot;')
            .replace(/'/g, '&#039;');
    }

    function resetChatState() {
        localStorage.removeItem('support_uuid');
        localStorage.removeItem('support_last_event_id');
        conversationUuid = null;
        lastEventId = 0;
    }

    document.addEventListener('DOMContentLoaded', () => {
        const isAuthenticated =
            document.querySelector('meta[name="sc-auth"]')?.content === '1';

        if (isAuthenticated) {
            document.getElementById('g-name').style.display = 'none';
            document.getElementById('g-email').style.display = 'none';
            // document.getElementById('g-phone').style.display = 'none';
        }

        if (conversationUuid) {
            resumeChat();
        }
    });

    function endChat() {
        if (!conversationUuid) return;

        if (!confirm('Are you sure you want to end this chat?')) return;

        fetch('/support-chat/end', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').content
                },
                body: JSON.stringify({
                    uuid: conversationUuid
                })
            })
            .then(() => {
                resetChatUI();
            });
    }

    function resetChatUI() {
        resetChatState();

        document.getElementById('sc-messages').innerHTML = '';
        document.getElementById('sc-input').style.display = 'none';
        document.getElementById('sc-form').style.display = 'block';

        if (eventSource) {
            eventSource.close();
            eventSource = null;
        }
    }
</script> --}}
