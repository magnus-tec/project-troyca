<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DatosPersonale extends Model
{
    use HasFactory;
    protected $fillable = [
        'registro_socio_id',
        'apellido_paterno',
        'apellido_materno',
        'nombres',
        'dni',
        'fecha_nacimiento',
        'estado_civil',
        'profesion_ocupacion',
        'nacionalidad',
        'sexo'
    ];

    protected $casts = [
        'fecha_nacimiento' => 'date',
    ];

    public function registroSocio()
    {
        return $this->hasOne(RegistroSocio::class);
    }
}
