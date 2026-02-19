<?php

return [
    'user_model' => env('SUPPORT_CHAT_USER_MODEL', App\Models\User::class),

    'agent_role' => env('SUPPORT_CHAT_AGENT_ROLE', 'agent'),
    'agent_flag_column' => env('SUPPORT_CHAT_AGENT_FLAG_COLUMN', 'is_agent'),

    'routes' => [
        'public_prefix' => env('SUPPORT_CHAT_PUBLIC_PREFIX', 'support-chat'),
        'agent_prefix'  => env('SUPPORT_CHAT_AGENT_PREFIX', 'agent'),
        'public_middleware' => ['web'],
        'agent_middleware'  => ['web', 'auth'],
    ],

    'agent_layout' => env('SUPPORT_CHAT_AGENT_LAYOUT', 'layouts.app'),
];
