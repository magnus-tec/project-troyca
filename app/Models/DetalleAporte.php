<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetalleAporte extends Model
{
    use HasFactory;
    protected $table = 'detalles_aportes';

    protected $fillable = [
        'aporte_id',
        'monto',
        'estado',
        'codigo',
        'user_register',
    ];
    public function aporteAhorro()
    {
        return $this->belongsTo(AporteAhorro::class, 'aporte_id');
    }
    public function user()
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
