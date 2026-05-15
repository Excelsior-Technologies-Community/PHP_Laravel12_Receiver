<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('receivers', function (Blueprint $table) {
            $table->id();
            $table->string('sender_name', 100);
            $table->text('message');
            $table->string('email', 100)->nullable();
            $table->string('phone', 20)->nullable();
            $table->enum('priority', ['low', 'medium', 'high'])->default('medium');
            $table->boolean('is_read')->default(false);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('receivers');
    }
};