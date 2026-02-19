<?php

namespace Ezead\SupportChatCore\Support;

use Illuminate\Support\Facades\Cache;

class AgentPresence
{
    public static function markOnline(int $agentId): void
    {
        // 3 minutes TTL, refreshed on every SSE reconnect
        Cache::put("agent_online_{$agentId}", true, now()->addMinutes(1));
    }

    public static function onlineAgents()
    {
        $userModel = config('support-chat.user_model');
        $q = $userModel::query();

        if (method_exists($q, 'role')) {
            $q->role(config('support-chat.agent_role', 'agent'));
        } else {
            $q->where(config('support-chat.agent_flag_column', 'is_agent'), true);
        }

        return $q->get()->filter(fn ($agent) => Cache::has("agent_online_{$agent->id}"));
    }

    public static function onlineAgentIds(): array
    {
        return self::onlineAgents()->pluck('id')->all();
    }
}