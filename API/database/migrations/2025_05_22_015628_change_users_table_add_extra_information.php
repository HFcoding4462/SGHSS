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
        Schema::table('users', function (Blueprint $table) {
            $table->string('cpf');
            $table->integer('idade');
            $table->integer('sexo_id')->nullable();

            $table->foreign('sexo_id')->references('id')->on('sexos');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['sexo_id']);
            $table->dropColumn(['sexo_id', 'idade', 'cpf']);
        });
    }
};
