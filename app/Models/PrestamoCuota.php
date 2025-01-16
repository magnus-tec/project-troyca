<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PrestamoCuota extends Model
{
    use HasFactory;
    protected $table = 'prestamo_cuotas';
    protected $fillable = [
        'prestamos_id',
        'fecha_vencimiento',
        'cuota',
        'saldo_capital',
        'subtotal',
        'interes',
        'monto_pago',
        'fecha_pago_realizado',
        'estado',
        'mora',
        'amortizacion'

    ];
    public function prestamo()
    {
        return $this->belongsTo(Prestamo::class, 'prestamos_id');
    }
}
