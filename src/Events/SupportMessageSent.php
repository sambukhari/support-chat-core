<?php

namespace Ezead\SupportChatCore\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class SupportMessageSent implements ShouldBroadcast
{
    public function __construct(
        public string $uuid,
        public array $data
    ) {}

    public function broadcastOn()
    {
        return new Channel('support.conversation.' . $this->uuid);
    }

    public function broadcastAs() {
        return 'message.sent';
    }
}
