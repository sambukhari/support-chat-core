<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
  public function up(): void
  {
    Schema::create('support_events', function (Blueprint $table) {
      $table->bigIncrements('id');
      $table->unsignedBigInteger('conversation_id')->index();
      $table->uuid('conversation_uuid')->index();
      $table->string('type')->default('message'); // message, status, etc
      $table->timestamps();

      $table->index(['conversation_uuid', 'id']);
      $table->index(['conversation_id', 'id']);
    });
  }

  public function down(): void
  {
    Schema::dropIfExists('support_events');
  }
};
