<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Conyuge extends Model
{
    use HasFactory;
    protected $table = 'conyuges';

    protected $primaryKey = 'id';

    protected $fillable = [
        'registro_socio_id',
        'apellidos_nombres',
        'dni',
        'fecha_nacimiento',
        'celular',
        'ocupacion',
        'direccion'
    ];

    protected $casts = [
        'fecha_nacimiento' => 'date',
    ];

    public function registroSocio()
    {
        return $this->belongsTo(RegistroSocio::class);
    }
}
