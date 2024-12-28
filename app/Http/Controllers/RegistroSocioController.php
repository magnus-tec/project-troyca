<?php

namespace App\Http\Controllers;

use App\Models\DatosPersonale;
use App\Models\RegistroSocio;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RegistroSocioController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $registros = RegistroSocio::with('datosPersonales')->get();
        return view('socios.registrar-socios', compact('registros'));
    }

    public function getDatosPersonales()
    {
        $activeTab = 'datos-personales';

        return view('socios.datos-personales', compact('activeTab'));
    }
    public function getDireccion()
    {
        $activeTab = 'direccion';

        return view('socios.direccion', compact('activeTab'));
    }
    public function storeDatosPersonales(Request $request)
    {
        $request->validate([
            'apellido_paterno' => 'required',
            'apellido_materno' => 'required',
            'nombres' => 'required',
            'dni' => 'required|unique:datos_personales,dni',
            'fecha_nacimiento' => 'required|date',
            'estado_civil' => 'required',
            'profesion_ocupacion' => 'nullable|string',
            'nacionalidad' => 'required',
            'sexo' => 'required',
        ]);

        DB::transaction(function () use ($request) {
            $registro = RegistroSocio::create([
                'numero_socio' => $this->generarNumeroSocio(),
                'estado' => 'activo',
            ]);

            $registro->datosPersonales()->create($request->all());
        });

        return redirect()->route('registro.direccion');
    }

    public function storeDireccion(Request $request)
    {
        $request->validate([
            'departamento' => 'required',
            'provincia' => 'required',
            'distrito' => 'required',
            'tipo_vivienda' => 'required|in:propia,alquilada,familiar,otro',
            'direccion' => 'required',
            'referencia' => 'nullable',
            'telefono' => 'nullable',
            'correo' => 'nullable|email',
        ]);

        $registro = RegistroSocio::latest()->first();

        if (!$registro) {
            // If no RegistroSocio is found, redirect back with an error message
            return redirect()->route('registro.datos-personales')->with('error', 'Por favor, complete los datos personales primero.');
        }

        try {
            DB::transaction(function () use ($request, $registro) {
                $registro->direccion()->create($request->all());
            });

            return redirect()->route('registro.laboral');
        } catch (\Exception $e) {
            // Log the error
            \Log::error('Error al guardar la dirección: ' . $e->getMessage());

            // Redirect back with an error message
            return redirect()->back()->with('error', 'Hubo un problema al guardar la dirección. Por favor, inténtelo de nuevo.');
        }
    }

    public function storeLaboral(Request $request)
    {
        $request->validate([
            'situacion_laboral' => 'required',
            'empresa' => 'required',
            'direccion_laboral' => 'required',
            'telefono_laboral' => 'required',
            'cargo' => 'required',
        ]);

        $registro = RegistroSocio::latest()->first();
        $registro->informacionLaboral()->create($request->all());

        return redirect()->route('registro.conyuge');
    }

    public function storeConyuge(Request $request)
    {
        $request->validate([
            'apellidos_nombres' => 'required',
            'dni' => 'required|unique:conyuges,dni',
            'fecha_nacimiento' => 'required|date',
            'celular' => 'nullable',
            'ocupacion' => 'required',
            'direccion' => 'required',
        ]);

        $registro = RegistroSocio::latest()->first();

        if (!$registro) {
            return redirect()->route('registro.datos-personales')->with('error', 'Por favor, complete los datos personales primero.');
        }

        try {
            DB::transaction(function () use ($request, $registro) {
                $registro->conyuge()->create($request->all());
            });

            return redirect()->route('registro.beneficiarios')->with('success', 'Datos del cónyuge guardados exitosamente.');
        } catch (\Exception $e) {
            \Log::error('Error al guardar los datos del cónyuge: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Hubo un problema al guardar los datos del cónyuge. Por favor, inténtelo de nuevo.');
        }
    }

    public function storeBeneficiarios(Request $request)
    {
        $request->validate([
            'beneficiarios.*.apellidos_nombres' => 'required',
            'beneficiarios.*.dni' => 'required|digits:8',
            'beneficiarios.*.fecha_nacimiento' => 'required|date',
            'beneficiarios.*.parentesco' => 'required',
            'beneficiarios.*.sexo' => 'required|in:masculino,femenino',
        ]);

        $registro = RegistroSocio::latest()->first();

        if (!$registro) {
            return redirect()->route('registro.datos-personales')->with('error', 'Por favor, complete los datos personales primero.');
        }

        try {
            DB::transaction(function () use ($request, $registro) {
                foreach ($request->beneficiarios as $beneficiario) {
                    $registro->beneficiarios()->create($beneficiario);
                }
            });

            return redirect()->route('registrar-socios')->with('success', 'Beneficiarios registrados exitosamente.');
        } catch (\Exception $e) {
            \Log::error('Error al guardar los beneficiarios: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Hubo un problema al guardar los beneficiarios. Por favor, inténtelo de nuevo.');
        }
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

        // Validar los datos de datosPersonales
        $validatedDataPersonal = $request->validate([
            'datosPersonales.apellido_paterno' => 'nullable|string|max:255',
            'datosPersonales.apellido_materno' => 'nullable|string|max:255',
            'datosPersonales.nombres' => 'nullable|string|max:255',
            'datosPersonales.dni' => 'nullable|string|unique:datos_personales,dni',
            'datosPersonales.fecha_nacimiento' => 'nullable|date',
            'datosPersonales.estado_civil' => 'nullable|string|max:255',
            'datosPersonales.profesion_ocupacion' => 'nullable|string|max:255',
            'datosPersonales.nacionalidad' => 'nullable|string|max:255',
            'datosPersonales.sexo' => 'nullable|string|in:masculino,femenino',
        ]);
        //Validar los datos de Direccion
        $validatedDataDireccion = $request->validate([
            'direccionDomiciliaria.departamento' => 'nullable|string|max:255',
            'direccionDomiciliaria.provincia' => 'nullable|string|max:255',
            'direccionDomiciliaria.distrito' => 'nullable|string|max:255',
            'direccionDomiciliaria.tipo_vivienda' => 'nullable|string|max:255',
            'direccionDomiciliaria.direccion' => 'nullable|string|max:255',
            'direccionDomiciliaria.referencia' => 'nullable|string|max:255',
            'direccionDomiciliaria.telefono' => 'nullable|string|max:255',
            'direccionDomiciliaria.correo' => 'nullable|string|email|max:255',
        ]);
        //Validar los datos de Informacion Laboral
        $validatedDataInformacionLaboral = $request->validate([
            'datosLaborales.situacion' => 'nullable|string|max:255',
            'datosLaborales.institucion_empresa' => 'nullable|string|max:255',
            'datosLaborales.direccion_laboral' => 'nullable|string|max:255',
            'datosLaborales.telefono_empresa' => 'nullable|string|max:255',
            'datosLaborales.cargo' => 'nullable|string|max:255',
        ]);

        //Validar los datos de Conyuge
        $validatedDataConyuge = $request->validate([
            'conyuges.apellidos_nombres' => 'nullable|string|max:255',
            'conyuges.dni' => 'nullable|string',
            'conyuges.fecha_nacimiento' => 'nullable|date',
            'conyuges.celular' => 'nullable|string|max:255',
            'conyuges.ocupacion' => 'nullable|string',
            'conyuges.direccion' => 'nullable|string',
        ]);

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
                if (!empty(array_filter($validatedDataDireccion['direccionDomiciliaria']))) {
                    $registro->direccion()->create($validatedDataDireccion['direccionDomiciliaria']);
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
            dd($e->getMessage());
        }
        return redirect()->route('socios.index')->with('success', 'Socio registrado con éxito.');
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
    public function update(Request $request, RegistroSocio $registro)
    {
        $request->validate([
            'apellido_paterno' => 'required',
            'apellido_materno' => 'required',
            'nombres' => 'required',
            'dni' => 'required|unique:datos_personales,dni,' . $registro->datosPersonales->id,
            'fecha_nacimiento' => 'required|date',
            'estado_civil' => 'required',
            'profesion' => 'required',
            'nacionalidad' => 'required',
            'sexo' => 'required',
            'departamento' => 'required',
            'provincia' => 'required',
            'distrito' => 'required',
            'tipo_vivienda' => 'required',
            'direccion' => 'required',
            'situacion_laboral' => 'required',
            'empresa' => 'required',
            'direccion_laboral' => 'required',
            'telefono_laboral' => 'required',
            'cargo' => 'required',
        ]);

        DB::transaction(function () use ($request, $registro) {
            $registro->datosPersonales()->update([
                'apellido_paterno' => $request->apellido_paterno,
                'apellido_materno' => $request->apellido_materno,
                'nombres' => $request->nombres,
                'dni' => $request->dni,
                'fecha_nacimiento' => $request->fecha_nacimiento,
                'estado_civil' => $request->estado_civil,
                'profesion_ocupacion' => $request->profesion,
                'nacionalidad' => $request->nacionalidad,
                'sexo' => $request->sexo,
            ]);

            $registro->direccion()->update([
                'departamento' => $request->departamento,
                'provincia' => $request->provincia,
                'distrito' => $request->distrito,
                'tipo_vivienda' => $request->tipo_vivienda,
                'direccion' => $request->direccion,
                'referencia' => $request->referencia,
                'telefono' => $request->telefono,
                'correo' => $request->correo,
            ]);

            $registro->informacionLaboral()->update([
                'situacion' => $request->situacion_laboral,
                'institucion_empresa' => $request->empresa,
                'direccion_laboral' => $request->direccion_laboral,
                'telefono_laboral' => $request->telefono_laboral,
                'cargo' => $request->cargo,
            ]);

            if ($request->has('nombre_conyuge')) {
                $registro->conyuge()->updateOrCreate(
                    ['registro_socio_id' => $registro->id],
                    [
                        'apellidos_nombres' => $request->nombre_conyuge,
                        'dni' => $request->dni_conyuge,
                        'fecha_nacimiento' => $request->fecha_nacimiento_conyuge,
                        'celular' => $request->celular_conyuge,
                        'ocupacion' => $request->ocupacion_conyuge,
                        'direccion' => $request->direccion_conyuge,
                    ]
                );
            }

            if ($request->has('beneficiarios')) {
                $registro->beneficiarios()->delete();
                foreach ($request->beneficiarios as $beneficiario) {
                    $registro->beneficiarios()->create([
                        'apellidos_nombres' => $beneficiario['nombre'],
                        'dni' => $beneficiario['dni'],
                        'fecha_nacimiento' => $beneficiario['fecha_nacimiento'],
                        'parentesco' => $beneficiario['parentesco'],
                        'sexo' => $beneficiario['sexo'],
                    ]);
                }
            }
        });

        return redirect()->route('registrar-socios')->with('success', 'Registro de socio actualizado con éxito.');
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
        return $pdf->download('registro_socio_' . $registro->numero_socio . '.pdf');
    }

    private function generarNumeroSocio()
    {
        $ultimoRegistro = RegistroSocio::latest()->first();
        $ultimoNumero = $ultimoRegistro ? intval(substr($ultimoRegistro->numero_socio, 3)) : 0;
        $nuevoNumero = $ultimoNumero + 1;
        return 'SOC' . str_pad($nuevoNumero, 6, '0', STR_PAD_LEFT);
    }
}
