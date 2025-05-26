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
        Schema::create('consultas', function (Blueprint $table) {
            $table->id();
            $table->integer('paciente_id')->nullable();
            $table->integer('medico_id')->nullable();
            $table->date('data');
            $table->text('resultado')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('paciente_id')->references('id')->on('users')->onDelete('set null');
            $table->foreign('medico_id')->references('id')->on('users')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('consultas');
    }
};
