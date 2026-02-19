@extends(config('support-chat.agent_layout', 'layouts.app'))
<style>
    .chat_system {
        height: 100svh;
        background-color: #f0f2f5;
    }

    .chat_system .agent-chat {
        font-family: 'Inter', 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        color: #333;
    }

    .chat_system .sidebarfixed {
        width: 265px;
        position: fixed;
        top: 10%;
        height: 90svh;
        overflow-y: auto;
        z-index: 9;
        background: linear-gradient(180deg, #1f294c 0%, #252f5c 100%);
    }

    .chat_system .agent-chat .chat-messages {
        overflow-y: auto;
        scrollbar-width: none;
        -ms-overflow-style: none;
    }

    .chat_system .agent-chat .chat-messages::-webkit-scrollbar {
        display: none;
    }

    .chat_system .agent-chat .chat-sidebar {
        height: 100%;
        background: linear-gradient(180deg, #1f294c 0%, #252f5c 100%);
        color: #fff;
        border-right: 1px solid #ccc;
        display: flex;
        flex-direction: column;
        overflow: hidden;
        transition: all 0.3s ease;
    }

    .chat_system .agent-chat .chat-sidebar-header {
        padding: 20px 15px;
        background: rgba(37, 47, 92, 0.95);
        box-shadow: inset 0 -1px 0 rgba(255, 255, 255, 0.05);
        border-bottom: 1px solid #333;
    }

    .chat_system .agent-chat .tab-wrap {
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .chat_system .agent-chat .tab-btn {
        font-size: 12px;
        line-height: 18px;
        background: rgba(255, 255, 255, 0.05);
        border: none;
        color: #cbd1e0;
        padding: 7px 15px;
        border-radius: 30px;
        font-weight: 500;
        cursor: pointer;
        position: relative;
        transition: all 0.3s ease;
    }

    .chat_system .agent-chat .tab-btn:hover {
        background: rgba(0, 150, 136, 0.2);
        color: #fff;
    }

    .chat_system .agent-chat .tab-btn.active {
        background: #0074a3;
        color: #fff;
        box-shadow: 0 0 8px rgba(0, 150, 136, 0.5);
    }

    .chat_system .agent-chat #chat-search {
        font-size: 12px;
        line-height: 18px;
        margin-top: 15px;
        background: rgba(255, 255, 255, 0.1);
        color: #fff;
        border: none;
        border-radius: 25px;
        padding: 6px 15px;
        transition: all 0.3s;
    }

    .chat_system .chat-date-divider {
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 12px;
        line-height: 18px;
    }

    .chat_system .agent-chat #chat-search::placeholder {
        color: #fff !important;
    }

    .chat_system .agent-chat #chat-search:focus {
        background: rgba(255, 255, 255, 0.2);
        outline: none;
    }

    .chat_system .agent-chat #chat-list {
        list-style: none;
        margin: 0;
        padding: 0;
        overflow-y: auto;
        flex-grow: 1;
    }

    .chat_system .agent-chat #chat-list li {
        font-size: 12px;
        line-height: 12px;
        padding: 12px 18px;
        border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        cursor: pointer;
        transition: all 0.2s ease-in-out;
        border-radius: 8px;
        margin: 5px 10px;
        display: flex;
        align-content: center;
        align-items: center;
        justify-content: space-between;
        position: relative;
    }

    .chat_system .agent-chat #chat-list li .chat-date {
        font-size: 8px;
        line-height: 12px;
        position: absolute;
        right: 2px;
        top: 1px;
    }

    .chat_system .agent-chat #chat-list li .meta {
        display: flex;
        flex-direction: column;
        gap: 2px;
    }

    .chat_system .agent-chat .total-unread-badge {
        position: absolute;
        top: -6px;
        right: -10px;
        background: #f38521;
        color: #fff;
        font-size: 11px;
        height: 25px;
        display: flex;
        width: 25px;
        border-radius: 50%;
        font-weight: 600;
        box-shadow: 0 0 3px rgba(0, 0, 0, 0.4);
        flex-direction: row;
        flex-wrap: nowrap;
        align-content: center;
        justify-content: center;
        align-items: center;
    }

    .chat_system .unread-badge {
        background: #0074a3;
        height: 15px;
        width: 15px;
        font-size: 9px;
        display: flex;
        flex-direction: row;
        flex-wrap: nowrap;
        align-content: center;
        justify-content: center;
        align-items: center;
        border-radius: 20px;
    }

    .chat_system .agent-chat #chat-list li:hover {
        background: rgba(0, 150, 136, 0.2);
    }

    .chat_system .agent-chat .chat-main {
        height: 85svh;
        display: flex;
        flex-direction: column;
        transition: all 0.3s;
        position: relative;
    }

    .chat_system .agent-chat .chat-empty {
        flex: 1;
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        color: #999;
        font-size: 18px;
    }

    .chat_system .agent-chat .chat-empty i {
        font-size: 70px;
        margin-bottom: 20px;
        color: #0074a3;
        animation: float 2s ease-in-out infinite;
    }

    @keyframes float {

        0%,
        100% {
            transform: translateY(0);
        }

        50% {
            transform: translateY(-10px);
        }
    }

    .chat_system .agent-chat #chat-window {
        display: flex;
        flex-direction: column;
        height: 100%;
        animation: fadeIn 0.3s ease forwards;
    }

    @keyframes fadeIn {
        from {
            opacity: 0;
            transform: translateY(10px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .chat_system .agent-chat .chat-header {
        background: #fff;
        padding: 15px 20px;
        border-bottom: 1px solid #ddd;
        display: flex;
        justify-content: space-between;
        align-items: center;
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.05);
        border-radius: 0 0 10px 10px;
    }

    .chat_system .agent-chat .chat-header strong {
        font-size: 16px;
        color: #1f294c;
    }

    .chat_system .agent-chat .chat-header small {
        font-size: 12px;
        color: #777;
    }

    .chat_system .agent-chat .chat-header .btn {
        background: #f38521 !important;
        border: 0;
        color: #fff;
        display: flex;
        align-items: center;
        gap: 5px;
        font-size: 13px;
        padding: 6px 12px;
        border-radius: 25px;
        transition: all 0.3s;
    }

    .chat_system .agent-chat .chat-header .btn:hover {
        opacity: 0.85;
    }

    .chat_system .agent-chat .chat-messages {
        flex: 1;
        padding: 20px;
        overflow-y: auto;
        background: #e9edf5;
        display: flex;
        flex-direction: column;
        gap: 10px;
    }

    .chat_system .agent-chat .chat-messages .msg {
        max-width: 75%;
        padding: 10px 15px;
        border-radius: 20px;
        position: relative;
        word-wrap: break-word;
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.08);
        font-size: 14px;
        line-height: 1.5;
        transition: all 0.2s ease;
        opacity: 0;
        animation: fadeInMsg 0.3s forwards;
    }

    .chat_system .agent-chat .chat-messages .msg-system {
        font-size: 12px;
        line-height: 18px;
        align-self: center;
        background: #e0e0e0;
        color: #555;
        font-style: italic;
        max-width: 60%;
        text-align: center;
        border-radius: 12px;
        padding: 8px 14px;
    }

    .chat_system .agent-chat .chat-messages .msg-user {
        font-size: 12px;
        line-height: 18px;
        align-self: flex-start;
        background: #ffffff;
        color: #333;
        border-bottom-left-radius: 2px;
    }

    .chat_system .agent-chat .chat-messages .msg-user:hover {
        background: #f1f1f1;
    }

    .chat_system .agent-chat .chat-messages .msg-agent {
        font-size: 12px;
        line-height: 18px;
        align-self: flex-end;
        background: linear-gradient(120deg, #0074a3, #159abc);
        color: #fff;
        border-bottom-right-radius: 2px;
    }

    .chat_system .agent-chat .chat-messages .msg-agent:hover {
        filter: brightness(1.05);
    }

    .chat_system .agent-chat .chat-messages .msg-time {
        display: block;
        font-size: 11px;
        color: rgba(0, 0, 0, 0.45);
        margin-top: 4px;
        text-align: right;
    }

    .chat_system .agent-chat .chat-messages .msg a {
        color: #0066cc;
        text-decoration: underline;
        word-break: break-all;
    }

    .chat_system .agent-chat .chat-messages .msg a:hover {
        text-decoration: none;
        color: #004999;
    }

    .chat_system .agent-chat .chat-messages::-webkit-scrollbar {
        width: 6px;
    }

    .chat_system .agent-chat .chat-messages::-webkit-scrollbar-thumb {
        background-color: rgba(0, 0, 0, 0.2);
        border-radius: 3px;
    }

    @keyframes fadeInMsg {
        to {
            opacity: 1;
        }
    }

    .chat_system .agent-chat .chat-input {
        display: flex;
        gap: 12px;
        padding: 12px 20px;
        background: #fff;
        border-top: 1px solid #ddd;
        border-radius: 0 0 10px 10px;
        box-shadow: 0 -2px 6px rgba(0, 0, 0, 0.05);
    }

    .chat_system .agent-chat .chat-input input#agent-text {
        flex: 1;
        padding: 10px 15px;
        border-radius: 25px;
        border: 1px solid #ccc;
        font-size: 14px;
        outline: none;
        transition: all 0.3s ease;
    }

    .chat_system .agent-chat .chat-input input#agent-text:focus {
        border-color: #0074a3;
        box-shadow: 0 0 8px rgba(0, 150, 136, 0.2);
    }

    .chat_system .agent-chat .chat-input button#send-btn {
        background: #0074a3;
        border: none;
        color: #fff;
        width: 45px;
        height: 45px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 16px;
        cursor: pointer;
        transition: all 0.3s ease;
        box-shadow: 0 3px 6px rgba(0, 0, 0, 0.15);
    }

    .chat_system .agent-chat .chat-input button#send-btn:hover {
        background: #0074a3;
        transform: scale(1.05);
    }

    .chat_system .agent-chat .chat-input button#send-btn i {
        pointer-events: none;
    }

    .chat_system .sidebar-close-btn,
    .chat_system .sidebar-toggle-btn {
        display: none;
    }

    .chat_system .sidebar-pagination {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 6px;
        padding: 10px 10px 14px;
        border-top: 1px solid rgba(255, 255, 255, 0.08);
    }

    .chat_system .sidebar-pagination .sp-btn {
        background: rgba(255, 255, 255, 0.08);
        border: none;
        color: #cbd1e0;
        width: 28px;
        height: 28px;
        border-radius: 50%;
        font-size: 12px;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.25s;
    }

    .chat_system .sidebar-pagination .sp-btn:hover:not(:disabled) {
        background: #0074a3;
        color: #fff;
    }

    .chat_system .sidebar-pagination .sp-btn:disabled {
        opacity: 0.3;
        cursor: not-allowed;
    }

    .chat_system .sidebar-pagination .sp-info {
        font-size: 11px;
        color: rgba(255, 255, 255, 0.5);
        min-width: 60px;
        text-align: center;
    }

    .chat_system .top-row {
        display: flex;
        flex-direction: column;
        gap: 2px;
    }

    @media screen and (max-width:1199px) {
        .chat_system .sidebarfixed {
            width: 215px;
            top: 18%;
        }
    }

    @media screen and (max-width:991px) {
        .chat_system .sidebarfixed {
            width: 170px;
        }

        .chat_system .agent-chat .tab-btn {
            padding: 5px 8px;
        }

        .chat_system #refresh-chats-btn {
            font-size: 10px;
            font-size: 10px;
            padding: 0px;
            line-height: 0;
            width: 20px;
            height: 20px;
            border-radius: 50%;
        }

        .chat_system .agent-chat #chat-list li {
            font-size: 12px;
            line-height: 12px;
            padding: 8px 6px;
        }
    }

    @media screen and (max-width: 767px) {
        .chat_system .sidebarfixed {
            position: static;
            width: 100%;
        }

        .chat_system .agent-chat .chat-sidebar-header {
            background: transparent;
        }

        .chat_system .agent-chat .chat-header {
            border-radius: 10px;
            padding: 4px 8px;
        }

        .chat_system .agent-chat .chat-messages .msg {
            max-width: 95%;
        }

        .chat_system .chat-sidebar {
            position: absolute;
            left: -280px;
            top: 0;
            height: 100vh;
            width: 280px;
            transition: left 0.3s ease;
            z-index: 1000;
            background: white;
        }

        .chat_system .chat-sidebar.active {
            left: 0;
        }

        .chat_system .sidebar-toggle-btn {
            background: transparent;
            border: none;
            font-size: 24px;
            width: 45px;
            height: 45px;
            border: 1px solid;
            border-radius: 50%;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-left: auto;
        }

        .chat_system .sidebar-close-btn {
            position: absolute;
            top: 15px;
            right: 15px;
            display: block;
            background: transparent;
            border: none;
            font-size: 24px;
            color: #fff;
            cursor: pointer;
            padding: 5px;
        }

        .chat_system .chat-content {
            margin-left: 0 !important;
            width: 100%;
        }

        body.sidebar-open::before {
            content: '';
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            z-index: 1000;
        }

        .chat_system .sidebar-open .sidebar-toggle-btn {
            display: none;
        }
    }
</style>
{{-- @push('after_styles_stack') --}}
{{-- <link rel="stylesheet" href="{{ asset('vendor/support-chat/css/agent-chat.css') }}?v={{ filemtime(public_path('vendor/support-chat/css/agent-chat.css')) }}"> --}}
{{-- @end --}}
@section('content')
    <section class="chat_system">
        <div id="agent-chat-container" class="container agent-chat" data-agent-id="{{ auth()->id() }}">
            <div class="row g-0">
                <!-- LEFT: Sidebar -->
                <div class="col-md-3 chat-sidebar">
                    <div class="sidebarfixed">
                        <div class="chat-sidebar-header aleem">
                            <div class="d-flex align-items-center justify-content-between">
                                <div class="tab-wrap">
                                    <button id="tab-active" class="tab-btn active" type="button" data-tab="active">
                                        Active
                                        <span id="total-unread" class="total-unread-badge d-none">0</span>
                                    </button>
                                    <button id="tab-closed" class="tab-btn" type="button" data-tab="closed">
                                        Closed
                                    </button>
                                    <button class="btn btn-sm btn-light" type="button" id="refresh-chats-btn"
                                        title="Refresh">
                                        <i class="fa fa-rotate-right"></i>
                                    </button>
                                    <button class="sidebar-close-btn">
                                        <i class="fa fa-times"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="mt-2">
                                <input id="chat-search" class="form-control form-control-sm"
                                    placeholder="Search name/email..." />
                            </div>
                        </div>
                        <ul id="chat-list" class="chat-list"></ul>
                        <div class="sidebar-pagination" id="sidebar-pagination" style="display:none;">
                            <button class="sp-btn" id="sp-prev"><i class="fa fa-chevron-left"></i></button>
                            <span class="sp-info" id="sp-info">1 / 1</span>
                            <button class="sp-btn" id="sp-next"><i class="fa fa-chevron-right"></i></button>
                        </div>
                    </div>
                </div>
                <!-- RIGHT: Chat Area -->
                <div class="col-md-9">
                    <button class="sidebar-toggle-btn">
                        <i class="fa-solid fa-comment-sms"></i>
                    </button>
                    <div class="chat-main">

                        <!-- Empty State -->
                        <div id="chat-empty" class="chat-empty">
                            <i class="fa fa-comments"></i>
                            <p>Select a chat to start replying</p>
                        </div>
                        <!-- Chat Window -->
                        <div id="chat-window" class="d-none">
                            <div class="chat-header">
                                <div class="d-flex flex-column">
                                    <strong id="chat-user-name"></strong>
                                    <small id="chat-user-email" class="text-muted"></small>
                                    <small id="chat-status" class="text-muted"></small>
                                </div>

                                <div class="d-flex gap-2">
                                    <button id="join-btn" onclick="joinChat()" class="btn btn-sm btn-success d-none">
                                        <i class="fa fa-right-to-bracket"></i> Join
                                    </button>

                                    <button id="leave-btn" onclick="leaveChat()" class="btn btn-sm btn-warning d-none">
                                        <i class="fa fa-right-from-bracket"></i> Leave
                                    </button>

                                    <button id="close-btn" onclick="closeChat()" class="btn btn-sm btn-danger">
                                        <i class="fa fa-circle-xmark"></i> Close
                                    </button>
                                </div>

                            </div>

                            <div id="chat-messages" class="chat-messages"></div>

                            <div class="chat-input" id="agent-chat-input">
                                <input id="agent-text" type="text" placeholder="Type a reply..." />
                                <button id="send-btn" onclick="sendAgentMessage()" type="button">
                                    <i class="fa fa-paper-plane"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
@push('after_styles_stack')
    <!-- <link rel="stylesheet" href="{{ asset('vendor/support-chat/css/agent-chat.css') }}"> -->
@endpush
@push('after_scripts_stack')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const chatSidebar = document.querySelector('.chat-sidebar');
            const toggleBtn = document.querySelector('.sidebar-toggle-btn');
            const closeBtn = document.querySelector('.sidebar-close-btn');

            // Open sidebar
            toggleBtn.addEventListener('click', function() {
                chatSidebar.classList.add('active');
                document.body.classList.add('sidebar-open');
            });

            // Close sidebar
            closeBtn.addEventListener('click', function() {
                chatSidebar.classList.remove('active');
                document.body.classList.remove('sidebar-open');
            });

            // Close sidebar on outside click
            document.addEventListener('click', function(e) {
                if (window.innerWidth <= 767) {
                    if (!chatSidebar.contains(e.target) && !toggleBtn.contains(e.target)) {
                        chatSidebar.classList.remove('active');
                        document.body.classList.remove('sidebar-open');
                    }
                }
            });
        });
    </script>
    <script>
        var _paginationPage = 1;
        var PER_PAGE = 7;

        function applyPagination() {
            var list = document.getElementById('chat-list');
            var paginationEl = document.getElementById('sidebar-pagination');
            var prevBtn = document.getElementById('sp-prev');
            var nextBtn = document.getElementById('sp-next');
            var infoEl = document.getElementById('sp-info');

            if (!list) return;

            var items = Array.from(list.querySelectorAll('li'));
            var total = items.length;
            var totalPages = Math.max(1, Math.ceil(total / PER_PAGE));

            _paginationPage = Math.min(_paginationPage, totalPages);

            var start = (_paginationPage - 1) * PER_PAGE;

            items.forEach(function(li, i) {
                li.style.display = (i >= start && i < start + PER_PAGE) ? '' : 'none';
            });

            paginationEl.style.display = totalPages > 1 ? 'flex' : 'none';
            infoEl.textContent = _paginationPage + ' / ' + totalPages;
            prevBtn.disabled = _paginationPage === 1;
            nextBtn.disabled = _paginationPage === totalPages;
        }

        document.getElementById('sp-prev').addEventListener('click', function() {
            if (_paginationPage > 1) {
                _paginationPage--;
                applyPagination();
            }
        });

        document.getElementById('sp-next').addEventListener('click', function() {
            _paginationPage++;
            applyPagination();
        });

        // Search reset
        document.getElementById('chat-search').addEventListener('input', function() {
            _paginationPage = 1;
        });

        // Tab reset
        document.querySelectorAll('.tab-btn').forEach(function(b) {
            b.addEventListener('click', function() {
                _paginationPage = 1;
            });
        });
    </script>
    <script>
        window.csrfToken = "{{ csrf_token() }}";
    </script>
    <script src="{{ asset('vendor/support-chat/js/agent-chat.js') }}?v={{ filemtime(public_path('vendor/support-chat/js/agent-chat.js')) }}"></script>
@endpush
