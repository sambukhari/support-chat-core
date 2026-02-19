<?php
namespace Ezead\SupportChatCore\Http\Controllers;
use Ezead\SupportChatCore\Models\SupportConversation;
use Ezead\SupportChatCore\Models\SupportMessage;
use Ezead\SupportChatCore\Models\SupportEvent;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

use Ezead\SupportChatCore\Support\AgentPresence;
use Ezead\SupportChatCore\Jobs\NotifyAgentsIfChatUnassigned;

class SupportChatController extends \Illuminate\Routing\Controller
{
    public function start(Request $r)
    {
        $uuid = (string) Str::uuid();
        // if user is logged in, then override name/email/phone
        if (auth()->check()) {
            $user = auth()->user();
            $r->merge([
                'name' => $user->name,
                'email' => $user->email,
                // 'phone' => $user->phone,
            ]);
        }
        $conv = SupportConversation::create([
            'uuid' => $uuid,
            'visitor_name' => $r->name,
            'visitor_email' => $r->email,
            // 'visitor_phone' => $r->phone,
            'status' => 'pending',
            'unread_count' => 1
        ]);
        // 🔔 NOTIFICATION LOGIC
        $onlineAgents = AgentPresence::onlineAgents();

        if ($onlineAgents->isEmpty()) {
            // Notify Human agents by email and join AI agent immediately
            NotifyAgentsIfChatUnassigned::dispatch($conv->id)->delay(now()->addMinute());
        } else {
            // reuse existing job timing
            NotifyAgentsIfChatUnassigned::dispatch($conv->id)
                ->delay(now()->addMinute());
                // Event so agent list can light up
            SupportEvent::create([
                'conversation_id' => $conv->id,
                'conversation_uuid' => $conv->uuid,
                'type' => 'message',
            ]);
        }
       

        
        

        return response()->json(['uuid' => $uuid, 'waiting_for_agent' => !$onlineAgents->isEmpty()]);
    }
    public function end(Request $r)
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

    public function send(Request $r)
    {
        $conv = SupportConversation::where('uuid', $r->uuid)->firstOrFail();

        if ($conv->handled_by !== 'ai') {
            $conv->increment('unread_count');
        }

        SupportMessage::create([
            'conversation_id' => $conv->id,
            'sender_type' => 'visitor',
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

    // Fetch messages (only new)
    public function messages(Request $r)
    {
        $conv = SupportConversation::where('uuid', $r->uuid)->firstOrFail();
        $afterId = (int) ($r->get('after_id', 0));

        $msgs = SupportMessage::where('conversation_id', $conv->id)
            ->where('id', '>', $afterId)
            ->orderBy('id')
            ->get(['id','sender_type','body','created_at','sender_id']);
            

        return response()->json([
            'messages' => $msgs->map(fn($m) => [
                'id' => $m->id, 
                'text' => $m->body,
                'sender_name' => $m->sender_type === 'visitor' ? ' ' : ($m->sender_id  !== null  ? $m->sender->name : 'Virtual Assistant'),
                'created_at' => $m->created_at->toDateTimeString(),
                'from' => $m->sender_type === 'visitor' ? 'user' : 'agent',
                'sender_type' => $m->sender_type,
            ])
        ]);
    }

    // Resume (load full history once)
    public function resume(Request $r)
    {
        $conv = SupportConversation::where('uuid', $r->uuid)->first();

        if (!$conv || $conv->status ==="closed") return response()->json(['valid' => false]);

        $msgs = SupportMessage::where('conversation_id', $conv->id)
            ->orderBy('id')
            ->get(['id','sender_type','body', 'sender_id']);

        return response()->json([
            'valid' => true,
            'messages' => $msgs->map(fn($m) => [
                'id' => $m->id,
                'status' => $m->status,
                'text' => $m->body,
                'sender_name' => $m->sender_type === 'visitor' ? ' ' : ($m->sender_id  !== null  ? $m->sender->name : 'Virtual Assistant'),

                'from' => $m->sender_type === 'visitor' ? 'user' : 'agent',
                'sender_type' => $m->sender_type,
            ])
        ]);
    }

    // SSE: only notifies "new event exists"
    public function events(Request $r)
    {
        $uuid = $r->uuid;
        $lastId = (int) ($r->get('last_id', 0));
        $start = time();
        $timeout = 25; // short-lived: prevents hanging server

        return response()->stream(function () use ($uuid, $lastId, $start, $timeout) {

            while (time() - $start < $timeout) {
                $events = SupportEvent::where('conversation_uuid', $uuid)
                    ->where('id', '>', $lastId)
                    ->orderBy('id')
                    ->limit(20)
                    ->get(['id','conversation_uuid','type']);

                if ($events->count()) {
                    foreach ($events as $ev) {
                        echo "id: {$ev->id}\n";
                        echo "data: " . json_encode([
                            'event_id' => $ev->id,
                            'conversation_uuid' => $ev->conversation_uuid,
                            'type' => $ev->type,
                        ]) . "\n\n";
                        $lastId = $ev->id;
                    }
                    ob_flush(); flush();
                    return; // end request; client reconnects
                }

                usleep(500000); // 0.5s
            }

        }, 200, [
            'Content-Type' => 'text/event-stream',
            'Cache-Control' => 'no-cache',
            'Connection' => 'keep-alive',
        ]);
    }
}

