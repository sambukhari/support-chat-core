<?php

namespace Ezead\SupportChatCore\Models;

use Illuminate\Database\Eloquent\Model;

class SupportMessage extends Model
{
    protected $fillable = [
        'conversation_id','sender_type','sender_id','body'
    ];

    public function conversation() {
        return $this->belongsTo(\Ezead\SupportChatCore\Models\SupportConversation::class);
    }
    //sender can be null (if visitor or system) or user (if agent)
    public function sender()
    {
        return $this->belongsTo(config('support-chat.user_model'), 'sender_id');
    }
}

