<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
       Schema::create('support_conversations', function (Blueprint $table) {
        $table->id();
        $table->uuid('uuid')->unique();
    
        $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
        $table->string('visitor_name')->nullable();
        $table->string('visitor_email')->nullable();
        $table->string('visitor_phone')->nullable();
    
        $table->enum('status', ['pending','assigned','closed'])->default('pending');
        $table->foreignId('assigned_agent_id')->nullable()->constrained('users')->nullOnDelete();
    
        $table->timestamps();
    });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('support_conversations');
    }
};
