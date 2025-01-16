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
        'codigo',
        'user_register',
    ];
    public function registroSocio()
    {
        return $this->belongsTo(RegistroSocio::class, 'registro_socio_id');
    }
    protected function user()
    {
        return $this->belongsTo(User::class, 'user_register', 'id');
    }
    protected static function booted()
    {
        static::creating(function ($model) {
            $model->user_register = auth()->id();
        });
    }
}
