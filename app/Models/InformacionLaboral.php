<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InformacionLaboral extends Model
{
    use HasFactory;
    protected $table = 'informacion_laboral';

    protected $fillable = [
        'registro_socio_id',
        'situacion',
        'institucion_empresa',
        'direccion_laboral',
        'telefono_laboral',
        'cargo'
    ];

    public function registroSocio()
    {
        return $this->belongsTo(RegistroSocio::class);
    }
}
