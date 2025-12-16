<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('item_likes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');

            // items.item_id is the PK
            $table->unsignedBigInteger('item_id');
            $table->foreign('item_id')
                  ->references('item_id')
                  ->on('items')
                  ->onDelete('cascade');

            $table->timestamps();

            $table->unique(['user_id', 'item_id']); // one like per user per item
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('item_likes');
    }
};
