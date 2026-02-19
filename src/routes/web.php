<?php

use Illuminate\Support\Facades\Route;
use Ezead\SupportChatCore\Http\Controllers\SupportChatController;
use Ezead\SupportChatCore\Http\Controllers\AgentChatController;

$publicPrefix = config('support-chat.routes.public_prefix', 'support-chat');
$agentPrefix  = config('support-chat.routes.agent_prefix', 'agent');

$publicMiddleware = config('support-chat.routes.public_middleware', ['web']);
$agentMiddleware  = config('support-chat.routes.agent_middleware', ['web','auth']);

Route::middleware($publicMiddleware)->prefix($publicPrefix)->group(function () {
    Route::post('/start',   [SupportChatController::class, 'start']);
    Route::post('/message', [SupportChatController::class, 'send']);
    Route::get('/messages', [SupportChatController::class, 'messages']);
    Route::get('/events',   [SupportChatController::class, 'events']); // SSE
    Route::get('/resume',   [SupportChatController::class, 'resume']);
    Route::post('/end',     [SupportChatController::class, 'end']);
});

Route::middleware($agentMiddleware)->prefix($agentPrefix)->group(function () {
    Route::get('/',                 [AgentChatController::class, 'index']);
    Route::get('/chats',            [AgentChatController::class, 'chats']);
    Route::get('/messages/{uuid}',  [AgentChatController::class, 'messages']);
    Route::post('/chat/send',       [AgentChatController::class, 'send']);
    Route::get('/events',           [AgentChatController::class, 'events']); // SSE
    Route::post('/chat/close',      [AgentChatController::class, 'close']);
    Route::post('/chat/mark-read/{uuid}', [AgentChatController::class, 'markRead']);
    Route::post('/chat/join',       [AgentChatController::class, 'join']);
    Route::post('/chat/leave',      [AgentChatController::class, 'leave']);
});
