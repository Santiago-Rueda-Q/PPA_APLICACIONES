<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('incidentes', function (Blueprint $table) {
            $table->id();
            $table->string('codigo')->unique(); // INC-2025-0001

            // Relaciones
            $table->foreignId('solicitante_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('categoria_id')->constrained('categorias_incidentes');
            $table->foreignId('salon_id')->nullable()->constrained('salones');
            $table->foreignId('asignado_a')->nullable()->constrained('users');

            // Información del incidente
            $table->string('titulo');
            $table->text('descripcion');
            $table->enum('prioridad', ['baja', 'media', 'alta', 'urgente'])->default('media');
            $table->enum('estado', [
                'pendiente',
                'asignado',
                'en_proceso',
                'resuelto',
                'cerrado',
                'cancelado'
            ])->default('pendiente');

            // Fechas
            $table->timestamp('fecha_asignacion')->nullable();
            $table->timestamp('fecha_inicio_atencion')->nullable();
            $table->timestamp('fecha_resolucion')->nullable();
            $table->timestamp('fecha_cierre')->nullable();

            // Información adicional
            $table->text('solucion')->nullable();
            $table->text('observaciones')->nullable();
            $table->json('evidencias')->nullable(); // URLs de archivos

            $table->timestamps();
            $table->softDeletes();

            // Índices
            $table->index('estado');
            $table->index('prioridad');
            $table->index('solicitante_id');
            $table->index('asignado_a');
            $table->index('created_at');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('incidentes');
    }
};
