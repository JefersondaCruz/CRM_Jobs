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
        Schema::create('job_applications', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('job_opening_id');
            $table->unsignedBigInteger('candidate_id');
            $table->enum('status',['Pendente', 'Aprovado', 'Rejeitado'])->default('Pendente');
            $table->timestamps();

            $table->foreign('job_opening_id')
            ->references('id')->on('job_openings')
            ->onDelete('cascade');

            $table->foreign('candidate_id')
            ->references('id')->on('candidates')
            ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('job_applications');
    }
};
