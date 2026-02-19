# Ezead Support Chat Core

Realtime Support Chat (Core) for Laravel (no AI).
- Visitor widget endpoints (start, send, messages, SSE events, resume, end)
- Agent panel endpoints (list, open, join/leave, send, close, SSE events)
- Tables: support_conversations, support_messages, support_events (+ unread_count)

## Install

```bash
composer require ezead/support-chat-core
php artisan vendor:publish --tag=support-chat-core-config
php artisan vendor:publish --tag=support-chat-assets
php artisan migrate
```

## Views
- Agent panel: `support-chat::agent.chat`
- Widget snippet: `support-chat::widget.support-chat`

## Notes
Uses Server-Sent Events (SSE) for realtime updates (works on shared hosting).
