<?php

namespace Ezead\SupportChatCore\Models;

use Illuminate\Database\Eloquent\Model;

class SupportConversation extends Model
{
    protected $fillable = [
        'uuid','user_id','visitor_name','visitor_email','visitor_phone',
        'status','assigned_agent_id','unread_count'
    ];

    public function messages() {
        return $this->hasMany(\Ezead\SupportChatCore\Models\SupportMessage::class);
    }
    // user can be null (if handled by ai or unassigned)
    public function user() {
        return $this->belongsTo(config('support-chat.user_model'), 'user_id');
        }
}
