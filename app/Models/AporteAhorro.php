<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AporteAhorro extends Model
{
    use HasFactory;
    protected $fillable = [
        'registro_socio_id',
        'total_aportes',
        'estado',
    ];
    public function registroSocio()
    {
        return $this->belongsTo(RegistroSocio::class, 'registro_socio_id');
    }
}
