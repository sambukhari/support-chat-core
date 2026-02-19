/* =============================
   Sounds
============================= */
let messageAudio = null;
let lastRenderedMessageDate = null;
function initMessageSound() {
  if (messageAudio) return;

  messageAudio = new Audio('/sounds/message.mp3');
  messageAudio.preload = 'auto';
}

function playMessageSound() {
  initMessageSound();

  try {
    messageAudio.currentTime = 0;
    messageAudio.play().catch(() => {
      // autoplay blocked until user interaction – ignore silently
    });
  } catch { }
}

/* =============================
   STATEs
============================= */
let currentTab = 'active'; // active|closed
let currentUuid = null;
let lastMessageId = 0;
let lastEventId = 0;
let eventSource = null;

const seenMessageIds = new Set();
const seenEventIds = new Set();
let knownChatUuids = new Set();
let chatsCache = []; // for search

/* =============================
   Helpers
============================= */
function csrf() {
  return (window.csrfToken || document.querySelector('meta[name=csrf-token]')?.content || '');
}

function setTotalUnread(n) {
  const el = document.getElementById('total-unread');
  if (!el) return;
  if (n > 0) {
    el.classList.remove('d-none');
    el.textContent = String(n);
  } else {
    el.classList.add('d-none');
    el.textContent = '0';
  }
}

function scrollToBottom() {
  const box = document.getElementById('chat-messages');
  if (!box) return;
  box.scrollTop = box.scrollHeight;
}

function setChatInputEnabled(enabled) {
  //hide class chat-input
  const chatInput = document.getElementById('agent-chat-input');
  if (chatInput) {
    if (enabled) {
      chatInput.classList.remove('d-none');
    } else {
      chatInput.classList.add('d-none');
    }
  }
  const input = document.getElementById('agent-text');
  const btn = document.getElementById('send-btn');
  if (input) input.disabled = !enabled;
  if (btn) btn.disabled = !enabled;
}

/* =============================
   Tabs
============================= */
document.addEventListener('DOMContentLoaded', () => {
  document.getElementById('tab-active')?.addEventListener('click', () => switchTab('active'));
  document.getElementById('tab-closed')?.addEventListener('click', () => switchTab('closed'));
  document.getElementById('refresh-chats-btn')?.addEventListener('click', () => loadChats(true));
  document.getElementById('chat-search')?.addEventListener('input', e => renderChatList(filterChats(e.target.value)));

  loadChats(true);
  startAgentSSE();
});

function switchTab(tab) {
  currentTab = tab;

  document.querySelectorAll('.tab-btn').forEach(b => b.classList.remove('active'));
  document.querySelector(`[data-tab="${tab}"]`)?.classList.add('active');

  // reset view
  currentUuid = null;
  document.getElementById('chat-window')?.classList.add('d-none');
  document.getElementById('chat-empty')?.classList.remove('d-none');

  loadChats(true);
}

/* =============================
   Chat list
============================= */
function loadChats(force = false) {
  return fetch(`/agent/chats?tab=${currentTab}`)
    .then(r => r.json())
    .then(chats => {
      chats = Array.isArray(chats) ? chats : [];

      // 🔔 NEW CHAT DETECTION
      if (currentTab === 'active') {
        chats.forEach(c => {
          if (!knownChatUuids.has(c.uuid)) {
            knownChatUuids.add(c.uuid);

            // new chat only if NOT first load
            if (chatsCache.length > 0) {
              playMessageSound();
            }
          }
        });
      }

      chatsCache = chats;
      renderChatList(chatsCache);

      if (currentTab === 'active') {
        const total = chatsCache.reduce((sum, c) => sum + (Number(c.unread_count || 0)), 0);
        setTotalUnread(total);
      } else {
        setTotalUnread(0);
      }
    })
    .catch(() => { });
}


function filterChats(q) {
  q = (q || '').toLowerCase().trim();
  if (!q) return chatsCache;
  return chatsCache.filter(c => {
    const n = (c.visitor_name || '').toLowerCase();
    const e = (c.visitor_email || '').toLowerCase();
    return n.includes(q) || e.includes(q);
  });
}

// function renderChatList(chats) {
//   const list = document.getElementById('chat-list');
//   if (!list) return;
//   list.innerHTML = '';

//   chats.forEach(chat => {
//     const li = document.createElement('li');
//     li.className = 'chat-item';
//     li.dataset.uuid = chat.uuid;

//     const unread = Number(chat.unread_count || 0);
//     if (unread > 0) li.classList.add('unread');
//     if (currentUuid && chat.uuid === currentUuid) li.classList.add('active');

//     li.innerHTML = `
//       <div class="meta">
//         <strong>${chat.visitor_name || 'Visitor'}</strong>
//         <small>${chat.visitor_email || ''}</small>
//       </div>
//       ${unread > 0 ? `<span class="unread-badge">${unread}</span>` : ``}
//     `;

//     // only open chats from active tab
//     if (currentTab === 'active') {
//       li.addEventListener('click', () => openChat(chat));
//     }

//     list.appendChild(li);
//   });
// }
function renderChatList(chats) {
  const list = document.getElementById('chat-list');
  if (!list) return;

  list.innerHTML = '';

  chats.forEach(chat => {
    const li = document.createElement('li');
    li.className = 'chat-item';
    li.dataset.uuid = chat.uuid;

    const unread = Number(chat.unread_count || 0);
    if (unread > 0) li.classList.add('unread');
    if (currentUuid && chat.uuid === currentUuid) li.classList.add('active');

    const dateStr = chat.last_message_at || chat.updated_at;
    const dateLabel = formatChatListDate(dateStr);

    li.innerHTML = `
      <div class="meta">
        <div class="top-row">
        <span class="chat-date">${dateLabel}</span>
          <strong>${chat.visitor_name || 'Visitor'}</strong>
        </div>
        <small>${chat.visitor_email || ''}</small>
      </div>
      ${unread > 0 ? `<span class="unread-badge">${unread}</span>` : ``}
    `;

    if (currentTab === 'active') {
      li.addEventListener('click', () => openChat(chat));
    }

    list.appendChild(li);
  });
  if (typeof applyPagination === 'function') applyPagination();
}

function formatChatListDate(ts) {
  if (!ts) return '';

  const d = new Date(ts);
  const now = new Date();

  const isToday = d.toDateString() === now.toDateString();

  const yesterday = new Date();
  yesterday.setDate(yesterday.getDate() - 1);

  const isYesterday = d.toDateString() === yesterday.toDateString();

  if (isToday) {
    return d.toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' });
  }

  if (isYesterday) {
    return 'Yesterday';
  }

  return d.toLocaleDateString([], {
    day: '2-digit',
    month: 'short'
  });
}

/* =============================
   Open chat
============================= */
function openChat(chat) {
  // lastRenderedMessageDate = null;
  currentUuid = chat.uuid;
  const li = document.querySelector(`.chat-item[data-uuid="${chat.uuid}"]`);
  if (li) {
    li.classList.remove('unread');
    const badge = li.querySelector('.unread-badge');
    if (badge) badge.remove();
  }

  // 🔥 recalc total unread
  setTimeout(() => loadChats(), 300);
  lastMessageId = 0;
  // Join / Leave logic
  setChatInputEnabled(false);
  document.getElementById('join-btn')?.classList.add('d-none');
  document.getElementById('leave-btn')?.classList.add('d-none');

  // reset dedupe per conversation
  seenMessageIds.clear();
  lastRenderedMessageDate = null;
  // activate list item
  document.querySelectorAll('.chat-item').forEach(el => el.classList.remove('active'));
  document.querySelector(`.chat-item[data-uuid="${chat.uuid}"]`)?.classList.add('active');

  // show window
  document.getElementById('chat-empty')?.classList.add('d-none');
  document.getElementById('chat-window')?.classList.remove('d-none');

  document.getElementById('chat-user-name').innerText = chat.visitor_name || 'Visitor';
  document.getElementById('chat-user-email').innerText = chat.visitor_email || '';
  document.getElementById('chat-status').innerText = `Status: ${chat.status || ''}`;

  // if already closed, disable input
  const isClosed = (chat.status === 'closed');
  setChatInputEnabled(!isClosed);

  // clear messages UI
  const box = document.getElementById('chat-messages');
  if (box) box.innerHTML = '';

  // mark read (sets unread_count = 0)
  fetch(`/agent/chat/mark-read/${chat.uuid}`, {
    method: 'POST',
    headers: { 'X-CSRF-TOKEN': csrf() }
  }).then(() => {
    // refresh list counts (so badge disappears)
    loadChats();
  });

  // load history
  fetch(`/agent/messages/${chat.uuid}`)
    .then(r => r.json())
    .then(data => {

      const assignedUserId = data.assigned_user_id ? Number(data.assigned_user_id) : null;

      const myId = Number(document.getElementById('agent-chat-container').dataset.agentId); // see STEP 4
      console.log('Assigned User ID:', assignedUserId, 'My ID:', myId);
      const joinBtn = document.getElementById('join-btn');
      const leaveBtn = document.getElementById('leave-btn');

      if (!assignedUserId) {
        joinBtn?.classList.remove('d-none');
        leaveBtn?.classList.add('d-none');

        setChatInputEnabled(false);
      } else if (assignedUserId === myId) {
        joinBtn?.classList.add('d-none');
        leaveBtn?.classList.remove('d-none');
        setChatInputEnabled(true);
      } else {
        // another agent owns it
        joinBtn?.classList.add('d-none');
        leaveBtn?.classList.add('d-none');
        setChatInputEnabled(false);
      }

      (data.messages || []).forEach(m => appendMessage(m));
      scrollToBottom();
    });

}

/* =============================
   Append message (DEDUP SAFE)
============================= */
function appendMessage(m) {
  if (!m) return;
  if (m.id && seenMessageIds.has(m.id)) return;

  if (m.id) {
    seenMessageIds.add(m.id);
    lastMessageId = Math.max(lastMessageId, Number(m.id));
  }

  const messageDate = extractMessageDate(m.created_at);

  // 🔹 Insert date divider if needed
  if (messageDate !== lastRenderedMessageDate) {
    lastRenderedMessageDate = messageDate;

    const dateDivider = document.createElement('div');
    dateDivider.className = 'chat-date-divider';
    dateDivider.textContent = formatMessageDateLabel(m.created_at);

    document.getElementById('chat-messages')?.appendChild(dateDivider);
  }

  const div = document.createElement('div');

  if (m.from === 'system') {
    div.className = 'msg msg-system';
    div.textContent = m.text + " - " + messageDate || '';
  } else {
    div.className = `msg ${m.from === 'visitor' ? 'msg-user' : 'msg-agent'}`;
    div.innerHTML = `
      <div>${escapeHtml(m.text || '')}</div>
      <div class="msg-time">${formatTime(m.created_at)}</div>
    `;
  }

  document.getElementById('chat-messages')?.appendChild(div);
}

function extractMessageDate(ts) {
  if (!ts) return '';
  const d = new Date(ts);
  return d.toDateString();
}

function formatMessageDateLabel(ts) {
  if (!ts) return '';

  const d = new Date(ts);
  const now = new Date();

  const isToday = d.toDateString() === now.toDateString();

  const yesterday = new Date();
  yesterday.setDate(yesterday.getDate() - 1);

  const isYesterday = d.toDateString() === yesterday.toDateString();

  if (isToday) return 'Today';
  if (isYesterday) return 'Yesterday';

  return d.toLocaleDateString([], {
    weekday: 'long',
    day: 'numeric',
    month: 'short',
    year: 'numeric'
  });
}

function joinChat() {
  fetch('/agent/chat/join', {
    method: 'POST',
    headers: {
      'Content-Type': 'application/json',
      'X-CSRF-TOKEN': csrf()
    },
    body: JSON.stringify({ uuid: currentUuid })
  }).then(() => {
    document.getElementById('join-btn')?.classList.add('d-none');
    document.getElementById('leave-btn')?.classList.remove('d-none');
    setChatInputEnabled(true);
  });
}


function leaveChat() {
  fetch('/agent/chat/leave', {
    method: 'POST',
    headers: {
      'Content-Type': 'application/json',
      'X-CSRF-TOKEN': csrf()
    },
    body: JSON.stringify({ uuid: currentUuid })
  }).then(() => {
    document.getElementById('join-btn')?.classList.remove('d-none');
    document.getElementById('leave-btn')?.classList.add('d-none');
    setChatInputEnabled(false);
  });
}




/* =============================
   Send message
============================= */
function sendAgentMessage() {
  const input = document.getElementById('agent-text');
  const text = (input?.value || '').trim();
  if (!text || !currentUuid) return;

  input.value = '';

  fetch('/agent/chat/send', {
    method: 'POST',
    headers: {
      'Content-Type': 'application/json',
      'X-CSRF-TOKEN': csrf()
    },
    body: JSON.stringify({ uuid: currentUuid, message: text })
  });
}

function formatTime(ts) {
  if (!ts) return '';
  const d = new Date(ts);
  return d.toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' });
}

function escapeHtml(str) {
  return str
    .replace(/&/g, '&amp;')
    .replace(/</g, '&lt;')
    .replace(/>/g, '&gt;')
    .replace(/"/g, '&quot;')
    .replace(/'/g, '&#039;');
}


/* =============================
   Close chat
============================= */
function closeChat() {
  if (!currentUuid) return;

  fetch('/agent/chat/close', {
    method: 'POST',
    headers: {
      'Content-Type': 'application/json',
      'X-CSRF-TOKEN': csrf()
    },
    body: JSON.stringify({ uuid: currentUuid })
  }).then(() => {
    // disable input & refresh UI
    setChatInputEnabled(false);
    currentUuid = null;
    document.getElementById('chat-window')?.classList.add('d-none');
    document.getElementById('chat-empty')?.classList.remove('d-none');
    loadChats(true);
  });
}

/* =============================
   Fetch new messages for open chat
============================= */
function fetchNewMessages() {
  if (!currentUuid) return;

  fetch(`/agent/messages/${currentUuid}?after_id=${lastMessageId}`)
    .then(r => r.json())
    .then(data => {
      const msgs = data.messages || [];
      if (!msgs.length) return;

      msgs.forEach(m => appendMessage(m));
      scrollToBottom();

      // whenever we received new messages in open chat, mark read
      fetch(`/agent/chat/mark-read/${currentUuid}`, {
        method: 'POST',
        headers: { 'X-CSRF-TOKEN': csrf() }
      }).then(() => loadChats());
    });
}

function clearUnreadForCurrentChatInList() {
  if (!currentUuid) return;

  const li = document.querySelector(`.chat-item[data-uuid="${currentUuid}"]`);
  if (!li) return;

  li.classList.remove('unread');
  const badge = li.querySelector('.unread-badge');
  if (badge) badge.remove();
}

/* =============================
   SSE: Realtime list + open chat updates
   - We refresh list on ANY event (debounced)
   - We fetch messages only if the event is for currentUuid
============================= */
let refreshTimer = null;


function refreshListDebounced() {
  if (refreshTimer) return;

  refreshTimer = setTimeout(() => {
    refreshTimer = null;

    loadChats().then(() => {
      // 🔥 Step 4: never show unread badge on currently open chat
      clearUnreadForCurrentChatInList();
    });

  }, 600);
}

document.addEventListener('click', initMessageSound, { once: true });
document.addEventListener('keydown', initMessageSound, { once: true });

function startAgentSSE() {
  if (eventSource) {
    eventSource.close();
    eventSource = null;
  }

  eventSource = new EventSource(`/agent/events?last_id=${lastEventId}`);

  eventSource.addEventListener('message', function (e) {
    const eventId = Number(e.lastEventId || 0);
    if (!eventId || seenEventIds.has(eventId)) return;

    seenEventIds.add(eventId);
    lastEventId = eventId;

    let data = {};
    try { data = JSON.parse(e.data || '{}'); } catch { }

    refreshListDebounced();

    const isCurrentChat = data.conversation_uuid === currentUuid;

    // 🔔 PLAY SOUND CONDITIONS
    if (data.type === 'message') {
      // play sound if:
      // - message is from visitor
      // - OR chat is not currently open
      if (data.from === 'visitor' || !isCurrentChat) {
        playMessageSound();
      }
    }

    if (isCurrentChat) {
      fetchNewMessages();
      clearUnreadForCurrentChatInList();
    }
  });


  eventSource.onerror = function () {
    if (eventSource) {
      eventSource.close();
      eventSource = null;
    }
    setTimeout(startAgentSSE, 3000);
  };
}
