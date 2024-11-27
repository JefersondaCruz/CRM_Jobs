<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('candidates', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->text('experiences')->nullable();
            $table->text('skills')->nullable();
            $table->string('phone')->nullable();
            $table->text('social_media')->nullable();
            $table->string('CEP')->nullable();
            $table->integer('house_number')->nullable();
            $table->string('profile_picture')->nullable();
            $table->text('about')->nullable();
            $table->timestamps();

            $table->foreign('user_id')
            ->references('id')->on('users')
            ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('candidates');
    }
};

