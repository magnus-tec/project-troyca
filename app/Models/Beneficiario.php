<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Beneficiario extends Model
{
    use HasFactory;

    protected $fillable = [
        'registro_socio_id',
        'apellidos_nombres',
        'dni',
        'fecha_nacimiento',
        'parentesco',
        'sexo'
    ];

    protected $casts = [
        'fecha_nacimiento' => 'date',
    ];

    public function registroSocio()
    {
        return $this->belongsTo(RegistroSocio::class);
    }
}
