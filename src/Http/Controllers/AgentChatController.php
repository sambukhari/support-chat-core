<?php

namespace Ezead\SupportChatCore\Http\Controllers;

use Ezead\SupportChatCore\Models\SupportConversation;
use Ezead\SupportChatCore\Models\SupportMessage;
use Ezead\SupportChatCore\Models\SupportEvent;
use Illuminate\Http\Request;
use Ezead\SupportChatCore\Support\AgentPresence;

class AgentChatController extends \Illuminate\Routing\Controller
{
    public function index()
    {
        $hide_footer = true;
        return view('support-chat::agent.chat', compact('hide_footer'));
    }

    /**
     * Chat list for tabs
     */
    public function chats(Request $r)
    {
        $tab = $r->get('tab', 'active');

        $q = SupportConversation::query();

        if ($tab === 'closed') {
            $q->where('status', 'closed');
        } else {
            $q->where('status', '!=', 'closed');
        }

        return $q->orderBy('updated_at', 'desc')
        ->get([
            'uuid',
            'visitor_name',
            'visitor_email',
            'status',
            'unread_count',
            'updated_at',
            'user_id',
        ]);
    }

    /**
     * Mark chat as read (ONLY when agent opens chat)
     */
    public function markRead($uuid)
    {
        $conv = SupportConversation::where('uuid', $uuid)->firstOrFail();
    
        $conv->update([
            'unread_count' => 0,
            'status' => 'assigned',
        ]);
    
        $conv->touch();
    
        return response()->json(['ok' => true]);
    }


    /**
     * Fetch messages
     */
    public function messages($uuid, Request $r)
    {
        $conv = SupportConversation::where('uuid', $uuid)->firstOrFail();
        $afterId = (int) $r->get('after_id', 0);        
        $conv->update([
            'unread_count' => 0,
        ]);
        $conv->touch();

       $msgs = SupportMessage::where('conversation_id', $conv->id)
            ->where('id', '>', $afterId)
            ->orderBy('id')
            ->get(['id', 'sender_type', 'body', 'created_at']);

        return response()->json([
            'assigned_user_id' => $conv->user_id,
            
            'messages' => $msgs->map(fn ($m) => [
                'id' => $m->id,
                'text' => $m->body,
                'from' => $m->sender_type,
                'created_at' => $m->created_at->toDateTimeString(),
            ])
        ]);
    }

    public function join(Request $r)
    {
        $conv = SupportConversation::where('uuid', $r->uuid)->firstOrFail();

        if ($conv->status === 'closed') {
            abort(403);
        }

        if ($conv->user_id) { return response()->json(['ok' => true]); }


        $conv->update([
            'user_id' => auth()->id(),
            
        ]);
        

        SupportMessage::create([
            'conversation_id' => $conv->id,
            'sender_type' => 'system',
            'body' => 'Agent '.auth()->user()->name.' joined the chat',
        ]);

        SupportEvent::create([
            'conversation_id' => $conv->id,
            'conversation_uuid' => $conv->uuid,
            'type' => 'message',
        ]);
        

        return response()->json(['ok' => true]);
    }

    public function leave(Request $r)
    {
        $conv = SupportConversation::where('uuid', $r->uuid)->firstOrFail();

        if ($conv->user_id !== auth()->id()) {
            abort(403);
        }

        $conv->update([
            'user_id' => null,
            'status' => 'pending',
        ]);

        SupportMessage::create([
            'conversation_id' => $conv->id,
            'sender_type' => 'system',
            'body' => 'Agent left the chat',
        ]);

        SupportEvent::create([
            'conversation_id' => $conv->id,
            'conversation_uuid' => $conv->uuid,
            'type' => 'message',
        ]);

        return response()->json(['ok' => true]);
    }



    /**
     * Agent sends message
     */
    public function send(Request $r)
    {
        $conv = SupportConversation::where('uuid', $r->uuid)->firstOrFail();

        if ($conv->status === 'closed') {
            abort(403);
        }
        if ($conv->user_id !== auth()->id()) {
            abort(403, 'You must join the chat first.');
        }

        SupportMessage::create([
            'conversation_id' => $conv->id,
            'sender_type' => 'agent',
            'sender_id' => auth()->id(),
            'body' => $r->message,
        ]);

        SupportEvent::create([
            'conversation_id' => $conv->id,
            'conversation_uuid' => $conv->uuid,
            'type' => 'message',
        ]);

        $conv->touch();

        return response()->json(['ok' => true]);
    }

    /**
     * Close chat
     */
    public function close(Request $r)
    {
        $conv = SupportConversation::where('uuid', $r->uuid)->firstOrFail();

        $conv->update(['status' => 'closed']);

        SupportEvent::create([
            'conversation_id' => $conv->id,
            'conversation_uuid' => $conv->uuid,
            'type' => 'status_change',
        ]);

        return response()->json(['ok' => true]);
    }

    /**
     * SSE for agent
     */
    public function events(Request $r)
    {
        // 🔥 MARK AGENT ONLINE
        AgentPresence::markOnline(auth()->id());

        $lastId = (int) $r->get('last_id', 0);
        $start = time();
        $timeout = 25;

        return response()->stream(function () use ($lastId, $start, $timeout) {

            while (time() - $start < $timeout) {

                $events = SupportEvent::where('id', '>', $lastId)
                    ->orderBy('id')
                    ->limit(50)
                    ->get(['id', 'conversation_uuid', 'type']);

                if ($events->count()) {
                    foreach ($events as $ev) {
                        echo "id: {$ev->id}\n";
                        echo "event: message\n";
                        echo "data: " . json_encode([
                            'event_id' => $ev->id,
                            'conversation_uuid' => $ev->conversation_uuid,
                            'type' => $ev->type,
                        ]) . "\n\n";
                        $lastId = $ev->id;
                    }
                    ob_flush(); flush();
                    return;
                }

                usleep(500000);
            }

        }, 200, [
            'Content-Type' => 'text/event-stream',
            'Cache-Control' => 'no-cache',
            'Connection' => 'keep-alive',
        ]);
    }
}
