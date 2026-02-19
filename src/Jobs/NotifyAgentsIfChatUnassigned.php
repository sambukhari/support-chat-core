<?php

namespace Ezead\SupportChatCore\Jobs;

use Ezead\SupportChatCore\Models\SupportConversation;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Bus\Queueable;   
use Ezead\SupportChatCore\Models\SupportMessage;
use Ezead\SupportChatCore\Models\SupportEvent;

class NotifyAgentsIfChatUnassigned implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(public int $conversationId) {}

   public function handle()
    {
        $conv = SupportConversation::find($this->conversationId);

        if (!$conv || $conv->user_id || $conv->status === 'closed') return;

        // AI TAKES OVER INSTEAD OF EMAIL
        // $conv->update([
        //     'user_id' => config('app.ai_agent_id'),
        //     'handled_by' => 'ai',
        //     'ai_started_at' => now(),
        //     'status' => 'assigned',
        // ]);

        SupportMessage::create([
            'conversation_id' => $conv->id,
            'sender_type' => 'system',
            'sender_id' => null,
            'body' => "⏰ This conversation has been waiting for an agent to join for a while. We apologize for the delay. Our support staff has been notified and will join shortly. Thank you for your patience.",
        ]);

        SupportEvent::create([
            'conversation_id' => $conv->id,
            'conversation_uuid' => $conv->uuid,
            'type' => 'message',
        ]);
    }
}