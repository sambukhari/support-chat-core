<?php
namespace Ezead\SupportChatCore\Models;

use Illuminate\Database\Eloquent\Model;

class SupportEvent extends Model
{
    protected $fillable = [
        'conversation_id',
        'conversation_uuid',
        'type',
    ];
}
