<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('exames', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('consulta_id');
            $table->string('medico');
            $table->string('descricao');
            $table->string('prescricao');
            $table->string('data');
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('consulta_id')->references('id')->on('notificacao')->onDelete('cascade');
        });
    }


    public function down(): void
    {
        Schema::dropIfExists('exames');
    }
};
