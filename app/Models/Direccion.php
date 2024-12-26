<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Direccion extends Model
{
    use HasFactory;
    protected $table = 'direcciones';

    protected $fillable = [
        'registro_socio_id',
        'departamento',
        'provincia',
        'distrito',
        'tipo_vivienda',
        'direccion',
        'referencia',
        'telefono',
        'correo'
    ];

    public function registroSocio()
    {
        return $this->belongsTo(RegistroSocio::class);
    }
}
