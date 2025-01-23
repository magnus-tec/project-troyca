<?php

namespace App\Http\Controllers;

use App\Models\DatosPersonale;
use App\Models\RegistroSocio;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class RegistroSocioController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    // public function index(Request $request)
    // {
    //     $query = RegistroSocio::with('datosPersonales');

    //     // return response()->json(["auth" => auth()->user(), "isAdmin" => auth()->user()->hasRole('admin')]);
    //     if (auth()->user()->hasRole('admin')) {
    //         return response()->json(["auth" => auth()->user(), "isAdmin" => auth()->user()->hasRole('admin')]);

    //         if ($request->has('buscar') && $request->buscar) {
    //             $searchTerm = $request->buscar;
    //             $searchParts = explode(' ', $searchTerm);
    //             if (count($searchParts) > 1) {
    //                 $query->where(function ($q) use ($searchParts) {
    //                     if (count($searchParts) >= 3) {
    //                         $q->whereHas('datosPersonales', function ($query) use ($searchParts) {
    //                             $query->where('apellido_paterno', 'LIKE', '%' . $searchParts[0] . '%')
    //                                 ->orWhere('apellido_materno', 'LIKE', '%' . $searchParts[1] . '%')
    //                                 ->orWhere('nombres', 'LIKE', '%' . $searchParts[2] . '%');
    //                         });
    //                     } else {
    //                         $q->whereHas('datosPersonales', function ($query) use ($searchParts) {
    //                             $query->where('apellido_paterno', 'LIKE', '%' . $searchParts[0] . '%')
    //                                 ->orWhere('apellido_materno', 'LIKE', '%' . $searchParts[1] . '%');
    //                         });
    //                     }
    //                 });
    //             } else {
    //                 $query->where(function ($q) use ($searchParts) {
    //                     $q->whereHas('datosPersonales', function ($query) use ($searchParts) {
    //                         $query->where('nombres', 'LIKE', '%' . $searchParts[0] . '%')
    //                             ->orWhere('apellido_paterno', 'LIKE', '%' . $searchParts[0] . '%')
    //                             ->orWhere('apellido_materno', 'LIKE', '%' . $searchParts[0] . '%')
    //                             ->orWhere('dni', 'LIKE', '%' . $searchParts[0] . '%');
    //                     });
    //                 });
    //             }
    //             $query->orWhere('numero_socio', 'LIKE', '%' . $searchTerm . '%');
    //         }
    //     } else {
    //         if ($request->has('buscar') && !empty($request->buscar)) {
    //             // return response()->json(["auth" => auth()->user(), "isAdminffffff" => auth()->user()->hasRole('admin')]);
    //             $searchTerm = $request->buscar;
    //             $searchParts = explode(' ', $searchTerm);
    //             if (count($searchParts) > 1) {
    //                 $query->where(function ($q) use ($searchParts) {
    //                     if (count($searchParts) >= 3) {
    //                         $q->whereHas('datosPersonales', function ($query) use ($searchParts) {
    //                             $query->where('apellido_paterno', 'LIKE', '%' . $searchParts[0] . '%')
    //                                 ->orWhere('apellido_materno', 'LIKE', '%' . $searchParts[1] . '%')
    //                                 ->orWhere('nombres', 'LIKE', '%' . $searchParts[2] . '%');
    //                         });
    //                     } else {
    //                         $q->whereHas('datosPersonales', function ($query) use ($searchParts) {
    //                             $query->where('apellido_paterno', 'LIKE', '%' . $searchParts[0] . '%')
    //                                 ->orWhere('apellido_materno', 'LIKE', '%' . $searchParts[1] . '%');
    //                         });
    //                     }
    //                 });
    //             } else {
    //                 $query->where(function ($q) use ($searchParts) {
    //                     $q->whereHas('datosPersonales', function ($query) use ($searchParts) {
    //                         $query->where('nombres', 'LIKE', '%' . $searchParts[0] . '%')
    //                             ->orWhere('apellido_paterno', 'LIKE', '%' . $searchParts[0] . '%')
    //                             ->orWhere('apellido_materno', 'LIKE', '%' . $searchParts[0] . '%')
    //                             ->orWhere('dni', 'LIKE', '%' . $searchParts[0] . '%');
    //                     });
    //                 });
    //             }
    //             $query->orWhere('numero_socio', 'LIKE', '%' . $searchTerm . '%');
    //         }
    //     }
    //     $registros = $query->get();

    //     return view('socios.registrar-socios', compact('registros'));
    // }
    public function index(Request $request)
    {
        $query = RegistroSocio::with('datosPersonales');

        if (auth()->user()->hasRole('admin')) {
            // Si el usuario es admin, realizamos la consulta completa si hay filtro
            if ($request->has('buscar') && !empty($request->buscar)) {
                $searchTerm = $request->buscar;
                $searchParts = explode(' ', $searchTerm);
                if (count($searchParts) > 1) {
                    $query->where(function ($q) use ($searchParts) {
                        if (count($searchParts) >= 3) {
                            $q->whereHas('datosPersonales', function ($query) use ($searchParts) {
                                $query->where('apellido_paterno', 'LIKE', '%' . $searchParts[0] . '%')
                                    ->orWhere('apellido_materno', 'LIKE', '%' . $searchParts[1] . '%')
                                    ->orWhere('nombres', 'LIKE', '%' . $searchParts[2] . '%');
                            });
                        } else {
                            $q->whereHas('datosPersonales', function ($query) use ($searchParts) {
                                $query->where('apellido_paterno', 'LIKE', '%' . $searchParts[0] . '%')
                                    ->orWhere('apellido_materno', 'LIKE', '%' . $searchParts[1] . '%');
                            });
                        }
                    });
                } else {
                    $query->where(function ($q) use ($searchParts) {
                        $q->whereHas('datosPersonales', function ($query) use ($searchParts) {
                            $query->where(
                                'nombres',
                                'LIKE',
                                '%' . $searchParts[0] . '%'
                            )
                                ->orWhere('apellido_paterno', 'LIKE', '%' . $searchParts[0] . '%')
                                ->orWhere('apellido_materno', 'LIKE', '%' . $searchParts[0] . '%')
                                ->orWhere('dni', 'LIKE', '%' . $searchParts[0] . '%');
                        });
                    });
                }
                $query->orWhere('numero_socio', 'LIKE', '%' . $searchTerm . '%');
            }
        } else {
            // Si no es admin, solo mostramos registros si se mandó un filtro
            if ($request->has('buscar') && !empty($request->buscar)) {
                $searchTerm = $request->buscar;
                $searchParts = explode(' ', $searchTerm);
                if (count($searchParts) > 1) {
                    $query->where(function ($q) use ($searchParts) {
                        if (count($searchParts) >= 3) {
                            $q->whereHas('datosPersonales', function ($query) use ($searchParts) {
                                $query->where('apellido_paterno', 'LIKE', '%' . $searchParts[0] . '%')
                                    ->orWhere('apellido_materno', 'LIKE', '%' . $searchParts[1] . '%')
                                    ->orWhere('nombres', 'LIKE', '%' . $searchParts[2] . '%');
                            });
                        } else {
                            $q->whereHas('datosPersonales', function ($query) use ($searchParts) {
                                $query->where('apellido_paterno', 'LIKE', '%' . $searchParts[0] . '%')
                                    ->orWhere('apellido_materno', 'LIKE', '%' . $searchParts[1] . '%');
                            });
                        }
                    });
                } else {
                    $query->where(function ($q) use ($searchParts) {
                        $q->whereHas('datosPersonales', function ($query) use ($searchParts) {
                            $query->where('nombres', 'LIKE', '%' . $searchParts[0] . '%')
                                ->orWhere('apellido_paterno', 'LIKE', '%' . $searchParts[0] . '%')
                                ->orWhere('apellido_materno', 'LIKE', '%' . $searchParts[0] . '%')
                                ->orWhere('dni', 'LIKE', '%' . $searchParts[0] . '%');
                        });
                    });
                }
                $query->orWhere('numero_socio', 'LIKE', '%' . $searchTerm . '%');
            } else {
                // Si no es admin y no se manda filtro, no mostramos nada
                $registros = [];  // Devuelve un arreglo vacío
                return view('socios.registrar-socios', compact('registros'));
            }
        }
        // Si hay búsqueda o si es admin, ejecutamos la consulta
        $registros = $query->get();
        return view('socios.registrar-socios', compact('registros'));
    }
    public function findAll()
    {
        if (!auth()->user()->hasRole('admin')) {
            return response()->json([
                'error' => 'No tienes permiso para acceder a esta información.'
            ], 403);
        }

        $registros = RegistroSocio::with('datosPersonales')->get();
        return response()->json($registros);
    }

    public function getDatosPersonales()
    {
        $activeTab = 'datos-personales';

        return view('socios.datos-personales', compact('activeTab'));
    }

    public function edit($id)
    {
        $socio = RegistroSocio::with('datosPersonales', 'direccion', 'informacionLaboral', 'conyuge', 'beneficiarios')->findOrFail($id);

        return view('socios.editar-socio', compact('socio'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $activeTab = $request->segment(2) ?? 'datos-personales';
        return view('socios.nuevo-registro', compact('activeTab'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // dd($request->input('datosPersonales'));
        // dd($request->all());
        // Validar los datos de datosPersonales
        try {
            $validatedDataPersonal = $request->validate(
                [
                    'datosPersonales.apellido_paterno' => 'nullable|string|max:255',
                    'datosPersonales.apellido_materno' => 'nullable|string|max:255',
                    'datosPersonales.nombres' => 'required|string|max:255',
                    'datosPersonales.dni' => 'required|string|digits:8|unique:datos_personales,dni',
                    'datosPersonales.fecha_nacimiento' => 'nullable|date',
                    'datosPersonales.estado_civil' => 'nullable|string|max:255',
                    'datosPersonales.profesion_ocupacion' => 'nullable|string|max:255',
                    'datosPersonales.nacionalidad' => 'nullable|string|max:255',
                    'datosPersonales.sexo' => 'nullable|string|in:masculino,femenino',
                ],
                [
                    'datosPersonales.dni.unique' => 'El DNI ya ha sido registrado en Datos Personales.',
                    'datosPersonales.dni.required' => 'El DNI es requerido en Datos Personales.',
                    'datosPersonales.dni.digits:8' => 'El DNI debe tener 8 dígitos en Datos Personales.',
                    'datosPersonales.nombres.required' => 'Los nombres son requeridos en Datos Personales.',
                ]
            );
        } catch (ValidationException $e) {
            // Devolver los errores de validación en formato JSON
            return response()->json(['errors' => $e->errors()], 500);
        }
        //Validar los datos de Direccion
        try {
            $validatedDataDireccion = $request->validate(
                [
                    'direcciones.departamento' => 'nullable|string|max:255',
                    'direcciones.provincia' => 'nullable|string|max:255',
                    'direcciones.distrito' => 'nullable|string|max:255',
                    'direcciones.tipo_vivienda' => 'nullable|string|max:255',
                    'direcciones.direccion' => 'nullable|string|max:255',
                    'direcciones.referencia' => 'nullable|string|max:255',
                    'direcciones.telefono' => 'nullable|string|max:255',
                    'direcciones.correo' => 'required|string|email|unique:direcciones,correo',
                ],
                [
                    'direcciones.correo.unique' => 'El correo que ingresa en Direccion Domiciciliara ya ha sido registrado.',
                    'direcciones.correo.required' => 'El correo  de Direccion Domiciciliara  es requerido.',
                ]
            );
        } catch (ValidationException $e) {
            // Devolver los errores de validación en formato JSON
            return response()->json(['errors' => $e->errors()], 500);
        }
        //Validar los datos de Informacion Laboral
        $validatedDataInformacionLaboral = $request->validate([
            'datosLaborales.situacion' => 'nullable|string|max:255',
            'datosLaborales.institucion_empresa' => 'nullable|string|max:255',
            'datosLaborales.direccion_laboral' => 'nullable|string|max:255',
            'datosLaborales.telefono_empresa' => 'nullable|string|max:255',
            'datosLaborales.cargo' => 'nullable|string|max:255',
        ]);

        //Validar los datos de Conyuge
        try {
            $validatedDataConyuge = $request->validate([
                'conyuges.apellidos_nombres' => 'nullable|string|max:255',
                'conyuges.dni' => 'nullable|string|digits:8|unique:conyuges,dni',
                'conyuges.fecha_nacimiento' => 'nullable|date',
                'conyuges.celular' => 'nullable|string|max:255',
                'conyuges.ocupacion' => 'nullable|string',
                'conyuges.direccion' => 'nullable|string',
            ], [
                'conyuges.dni.unique' => 'El DNI ya ha sido registrado en Datos del Conyuge.',
                'conyuges.dni.digits:8' => 'El DNI debe tener 8 dígitos en Datos del Conyuge.',
            ]);
        } catch (ValidationException $e) {
            // Devolver los errores de validación en formato JSON
            return response()->json(['errors' => $e->errors()], 500);
        }

        $validatedDataBeneficiarios = $request->validate([
            'beneficiarios' => 'array',  // Verifica que es un array
            'beneficiarios.*.apellidos_nombres' => 'nullable|string|max:255',
            'beneficiarios.*.dni' => 'nullable|string|digits:8',
            'beneficiarios.*.fecha_nacimiento' => 'nullable|date',
            'beneficiarios.*.parentesco' => 'nullable|string|max:255',
            'beneficiarios.*.sexo' => 'nullable|string|in:masculino,femenino',
        ]);

        try {
            DB::enableQueryLog();

            DB::transaction(function () use ($validatedDataPersonal, $validatedDataInformacionLaboral, $validatedDataDireccion, $validatedDataConyuge, $validatedDataBeneficiarios) {
                $registro = RegistroSocio::create([
                    'numero_socio' => $this->generarNumeroSocio(),
                    'estado' => 0,
                ]);
                if (!empty(array_filter($validatedDataConyuge['conyuges']))) {
                    $registro->conyuge()->create($validatedDataConyuge['conyuges']);
                }
                if (!empty(array_filter($validatedDataDireccion['direcciones']))) {
                    $registro->direccion()->create($validatedDataDireccion['direcciones']);
                }
                if (!empty(array_filter($validatedDataInformacionLaboral['datosLaborales']))) {
                    $registro->informacionLaboral()->create($validatedDataInformacionLaboral['datosLaborales']);
                }
                if (!empty(array_filter($validatedDataPersonal['datosPersonales']))) {
                    $registro->datosPersonales()->create($validatedDataPersonal['datosPersonales']);
                }

                if (!empty($validatedDataBeneficiarios['beneficiarios']) && is_array($validatedDataBeneficiarios['beneficiarios'])) {
                    $beneficiarios = $validatedDataBeneficiarios['beneficiarios'];
                    if (array_keys($beneficiarios) !== range(0, count($beneficiarios) - 1)) {
                        $beneficiarios = [$beneficiarios];
                    }
                    if (!empty($beneficiarios)) {
                        $registro->beneficiarios()->createMany($beneficiarios);
                    }
                }
            });
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
            dd($e->getMessage());
        }
        return response()->json(['message' => 'Socio registrado con éxito']);
    }


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, RegistroSocio $socio)
    {
        $socio = RegistroSocio::findOrFail($socio->id);

        if ($request->has('datosPersonales')) {
            $socio->datosPersonales()->updateOrCreate(
                ['registro_socio_id' => $socio->id],
                $request->datosPersonales
            );
        }

        if ($request->has('direccionDomiciliaria')) {
            $socio->direccion()->updateOrCreate(
                ['registro_socio_id' => $socio->id],
                $request->direccionDomiciliaria
            );
            if (isset($request->direccionDomiciliaria['correo'])) {
                $email = $request->direccionDomiciliaria['correo'];
                $user = $socio->user;
                if ($user) {
                    $user->update(['email' => $email]);
                }
            }
        }

        if ($request->has('datosLaborales')) {
            $socio->informacionLaboral()->updateOrCreate(
                ['registro_socio_id' => $socio->id],
                $request->datosLaborales
            );
        }

        if ($request->has('conyuge')) {
            $socio->conyuge()->updateOrCreate(
                ['registro_socio_id' => $socio->id],
                $request->conyuge
            );
        }
        if ($request->has('beneficiariosActualizar')) {
            foreach ($request->beneficiariosActualizar as $beneficiarioData) {
                $beneficiario = $socio->beneficiarios()->find($beneficiarioData['id']);
                if ($beneficiario) {
                    $beneficiario->update($beneficiarioData);
                } else {
                    return response()->json(['error' => 'Beneficiario no encontrado para actualizar.'], 404);
                }
            }
        }

        if ($request->has('beneficiariosNuevos')) {
            foreach ($request->beneficiariosNuevos as $beneficiarioData) {
                $socio->beneficiarios()->create($beneficiarioData);
            }
        }


        return response()->json(['message' => 'Socio actualizado con éxito.']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            $registro = RegistroSocio::findOrFail($id);
            $registro->estado = $registro->estado == 0 ? 1 : 0;
            $registro->save();
            return response()->json([
                'success' => true,
                'newState' => $registro->estado
            ]);
        } catch (\Exception $e) {
            return response()->json(['success' => false]);
        }
    }
    public function generarPDF(RegistroSocio $registro)
    {
        $path = public_path('images/backgrounds_registro_socio/menbrete final.png');
        $imageData = base64_encode(file_get_contents($path));
        $src = 'data:image/jpeg;base64,' . $imageData;
        $pdf = Pdf::loadView('pdfs.registro_socio', compact('registro', 'src'));
        return $pdf->stream('registro_socio_' . $registro->numero_socio . '.pdf');
    }

    private function generarNumeroSocio()
    {
        $ultimoRegistro = RegistroSocio::latest()->first();

        if ($ultimoRegistro) {
            // Extraer la parte numérica ignorando cualquier prefijo ('SOC' o 'S')
            $ultimoNumero = intval(preg_replace('/[^0-9]/', '', $ultimoRegistro->numero_socio));
        } else {
            $ultimoNumero = 0;
        }

        $nuevoNumero = $ultimoNumero + 1;
        return 'S' . str_pad($nuevoNumero, 7, '0', STR_PAD_LEFT);
    }
}
