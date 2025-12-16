<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('chats', function (Blueprint $table) {
            $table->id();                              // chat_id
            $table->unsignedBigInteger('item_id');     // item_id (FK to items)
            $table->unsignedBigInteger('chat_by_id');  // sender
            $table->unsignedBigInteger('chat_for_id'); // receiver
            $table->string('chat_message', 255);       // message text
            $table->timestamps();                      // created_at = chat_timestamp

            $table->foreign('item_id')->references('id')->on('items')->onDelete('cascade');
            $table->foreign('chat_by_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('chat_for_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('chats');
    }
};
