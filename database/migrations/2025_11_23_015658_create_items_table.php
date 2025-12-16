<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('items', function (Blueprint $table) {
            // PK = item_id (to match your ERD)
            $table->id('item_id');

            // FK -> users.id
            $table->foreignId('user_id')
                  ->constrained('users')
                  ->onDelete('cascade');

            $table->string('item_name');
            $table->decimal('item_price', 10, 2);
            $table->string('item_condition');
            $table->string('item_category');
            $table->text('item_description')->nullable();

            // status: available / reserved / sold
            $table->enum('item_status', ['available', 'reserved', 'sold'])
                  ->default('available');

            // image path in storage (e.g. "items/12345.jpg")
            $table->string('item_image')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('items');
    }
};
