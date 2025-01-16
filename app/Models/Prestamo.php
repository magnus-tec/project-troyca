<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Prestamo extends Model
{
    use HasFactory;
    protected $fillable = [
        'fecha_solicitud',
        'registro_socio_id',
        'producto',
        'garantia',
        'detalle_garantia',
        'fecha_desembolso',
        'dni',
        'asesor',
        'expediente',
        'estado',
        'asesor_id',
        'user_register'
    ];

    public function registroSocio()
    {
        return $this->belongsTo(RegistroSocio::class);
    }
    protected static function booted()
    {
        static::creating(function ($model) {
            $model->user_register = auth()->id();
        });
    }
    public function asesor()
    {
        return $this->belongsTo(User::class, 'asesor_id', 'id');
    }
    public function user()
    {
        return $this->belongsTo(User::class, 'user_register', 'id');
    }
}
