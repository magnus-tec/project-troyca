<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RegistroSocio extends Model
{
    use HasFactory;

    protected $fillable = ['numero_socio', 'estado'];

    public function datosPersonales()
    {
        return $this->hasOne(DatosPersonale::class, 'registro_socio_id');
    }

    public function getNombreCompletoAttribute()
    {
        return $this->datosPersonales
            ? "{$this->datosPersonales->apellido_paterno} {$this->datosPersonales->apellido_materno} {$this->datosPersonales->nombres}"
            : '';
    }

    public function direccion()
    {
        return $this->hasOne(Direccion::class, 'registro_socio_id');
    }

    public function informacionLaboral()
    {
        return $this->hasOne(InformacionLaboral::class, 'registro_socio_id');
    }

    public function conyuge()
    {
        return $this->hasOne(Conyuge::class, 'registro_socio_id');
    }

    public function beneficiarios()
    {
        return $this->hasMany(Beneficiario::class, 'registro_socio_id');
    }
}
