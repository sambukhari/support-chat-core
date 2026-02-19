<?php

use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'support-chat'], function () {
    Route::get('/', function () {
        return view('support-chat::chat');
    });
});
