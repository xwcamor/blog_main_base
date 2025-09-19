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
        Schema::create('downloads', function (Blueprint $table) {
            $table->id();

            // Tipo de archivo generado
            $table->enum('type', ['pdf', 'excel', 'word']);

            // Nombre del archivo
            $table->string('filename');

            // Ruta del archivo en el storage
            $table->string('path');

            // Disco usado (local, s3, r2, etc.)
            $table->string('disk')->default('local');

            // Usuario dueño de la descarga
            $table->foreignId('user_id')->constrained();

            // Estado del proceso
            $table->enum('status', ['pending', 'processing', 'ready', 'expired', 'failed'])->default('pending');

            // Mensaje de error si falla el job
            $table->text('error_message')->nullable();

            // Expira (ejemplo: al final del día)
            $table->timestamp('expires_at')->nullable();

            // Momento en que el usuario descargó
            $table->timestamp('downloaded_at')->nullable();

            // created_at = cuando se pidió
            // updated_at = cuando cambió de estado
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('downloads');
    }
};
