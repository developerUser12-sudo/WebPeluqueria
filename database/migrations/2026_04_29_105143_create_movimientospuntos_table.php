<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('movimientospuntos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_usuario')->constrained('users')->onDelete('cascade');
            $table->foreignId('id_cupon')->nullable()->constrained('cupones')->nullOnDelete();
            $table->foreignId('id_cupongenerado')->nullable()->constrained('cuponesgenerados')->nullOnDelete();

            $table->string('motivo');
            $table->string('puntos');
            $table->boolean('pendiente')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('movimientospuntos');
    }
};
