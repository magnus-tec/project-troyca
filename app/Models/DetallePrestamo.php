<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetallePrestamo extends Model
{
    use HasFactory;
    protected $table = 'detalles_prestamo';

    protected $fillable = [
        'prestamos_id',
        'monto',
        'modalidad',
        'tem',
        'cantidad_cuotas',
        'cuota',
        'f_primera_cuota',
        'ted',
    ];
    public function prestamo()
    {
        return $this->belongsTo(Prestamo::class, 'prestamos_id');
    }
}
