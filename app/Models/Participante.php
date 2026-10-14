<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Participante extends Model
{
    protected $table = 'presuntos_delegados';

    protected $fillable = [
        'nombres',
        'apellido_paterno',
        'apellido_materno',
        'rfc',
        'genero',
        'telefono',
        'email',
        'numero_personal',
        'uudd',
        'folio',
        'acta_asamblea_path',
        'codigo_qr_token',
        'delegacion_id',
        'created_by',
        'status',
        'motivo_rechazo_observacion',
        'dictaminado_at',
        'asistencia_plenaria',
        'checkin_at',
    ];

    /**
     * El participante pertenece a una delegación
     */
    public function delegacion() : BelongsTo
    {
        return $this->belongsTo(Delegacion::class, 'delegacion_id');
    }

    protected function nombre(): Attribute
    {
        return Attribute::make(
            // Al guardar o actualizar, convierte automáticamente a mayúsculas UTF-8
            set: fn (string $value) => mb_strtoupper(trim($value), 'UTF-8'),
        );
    } 

    protected function apellidoPaterno(): Attribute
    {
        return Attribute::make(
            // Al guardar o actualizar, convierte automáticamente a mayúsculas UTF-8
            set: fn (string $value) => mb_strtoupper(trim($value), 'UTF-8'),
        );
    }

    protected function apellidoMaterno(): Attribute
    {
        return Attribute::make(
            // Al guardar o actualizar, convierte automáticamente a mayúsculas UTF-8
            set: fn (string $value) => mb_strtoupper(trim($value), 'UTF-8'),
        );
    }

    protected function rfc(): Attribute
    {
        return Attribute::make(
            // Al guardar o actualizar, convierte automáticamente a mayúsculas UTF-8
            set: fn (string $value) => mb_strtoupper(trim($value), 'UTF-8'),
        );
    }

    /**
     * Relacionamos el usuario que creo el registro de los presuntos_delegados
     */
    public function creador() : BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    

    public function getNombreCompletoAttribute()
    {
        // return "{$this->nombres} {$this->apellido_paterno} {$this->apellido_materno}";

        /**
         * Concatenamos los campos de nombre completo y eliminamos espacios adicionales, 
         * esto es útil para evitar problemas con espacios en blanco al buscar por nombre completo. 
         * Por ejemplo, si un participante tiene un apellido materno vacío, no queremos que haya un espacio 
         * extra al final del nombre completo. Al usar trim() y implode(), 
         * garantizamos que el formato del nombre completo sea consistente sin importar si algunos campos están vacíos o no.
         */
        return trim(implode(' ', [
            $this->nombres,
            $this->apellido_paterno,
            $this->apellido_materno,
        ]));        
    }    

    protected static function booted()
    {
        static::creating(function ($participante) {
            // 1. Asignar el creador automáticamente
            $participante->created_by = auth()->id() ?? 1;

            // 2. Generar UUID primero (lo necesitamos para el QR)
            $participante->uudd = (string) Str::uuid();


            // 3. Generar Folio ÚNICO con reintento automático
            $year = now()->format('Y');
            do {
                $nuevoFolio = "SNTE56-CNE-{$year}-" . strtoupper(bin2hex(random_bytes(3)));
                // Verificamos si este folio ya existe en la tabla
                $existe = static::where('folio', $nuevoFolio)->exists();
            } while ($existe);
            $participante->folio = $nuevoFolio;

            // 4. Generar la URL del QR
            $participante->codigo_qr = url("/validar/{$participante->uudd}");            

        });
    }    

    protected $casts = [
        'descargado_at' => 'datetime',
    ];
   
}
