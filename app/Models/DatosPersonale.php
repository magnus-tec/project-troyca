<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Models\Role;

class DatosPersonale extends Model
{
    use HasFactory;
    protected $fillable = [
        'registro_socio_id',
        'apellido_paterno',
        'apellido_materno',
        'nombres',
        'dni',
        'fecha_nacimiento',
        'estado_civil',
        'profesion_ocupacion',
        'nacionalidad',
        'sexo'
    ];

    protected $casts = [
        'fecha_nacimiento' => 'date',
    ];

    // public function registroSocio()
    // {
    //     return $this->hasOne(RegistroSocio::class);
    // }
    public function registroSocio()
    {
        return $this->belongsTo(RegistroSocio::class);
    }
    protected static function booted()
    {
        static::created(function ($datosPersonales) {
            $registroSocio = $datosPersonales->registroSocio;

            if ($registroSocio && !$registroSocio->user) {
                $direccion = $registroSocio->direccion;

                $email = $direccion ? $direccion->correo : null;

                $user = User::create([
                    'name' => $datosPersonales->nombres,
                    'email' => $email,
                    'password' => $datosPersonales->dni,
                ]);
                // Asignar el rol automáticamente
                $role = Role::where('name', 'user')->first(); // Asegúrate de usar el nombre del rol adecuado
                if ($role) {
                    $user->assignRole($role); // Asocia el rol al usuario
                }

                // Asocia el usuario al registroSocio
                $registroSocio->user()->associate($user);
                $registroSocio->save();
            }
        });
    }
}
