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
        Schema::create('presuntos_delegados', function (Blueprint $table) {
            $table->id();
            
            // Datos Personales
            $table->string('nombres');
            $table->string('apellido_paterno');
            $table->string('apellido_materno')->nullable();
            $table->string('rfc', 13)->nullable()->index();
            $table->enum('genero', ['H', 'M', 'O'])->nullable();
            $table->string('telefono')->nullable();
            $table->string('email')->nullable();
            $table->string('numero_personal')->unique()->nullable();
            $table->string('uudd')->nullable(); // Unidad / Dependencia
            $table->string('folio')->unique()->nullable();
            
            // Control de Expediente (Acta de Asamblea)
            $table->string('acta_asamblea_path')->nullable(); // Para guardar el PDF/Imagen del acta
            
            // Token y QR para el Check-in en la entrada
            $table->string('codigo_qr_token')->unique()->nullable();
            
            // Relaciones clave
            $table->foreignId('delegacion_id')->constrained('delegaciones')->cascadeOnDelete();
            $table->foreignId('created_by')->constrained('users'); // Quién lo registró (Capturista)
            
            // Flujo de Estados (Actualizado al Ciclo de Vida del Congreso)
            $table->enum('status', [
                'REGISTRADO', 
                'EN_REVISION', 
                'ACREDITADO', 
                'RECHAZADO', 
                'OBSERVADO'
            ])->default('REGISTRADO');
            
            $table->text('motivo_rechazo_observacion')->nullable(); // Notas de la comisión si hay observaciones
            $table->timestamp('dictaminado_at')->nullable();
            
            // Control de asistencia a la plenaria (Check-in)
            $table->boolean('asistencia_plenaria')->default(false);
            $table->timestamp('checkin_at')->nullable();
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('presuntos_delegados');
    }
};
