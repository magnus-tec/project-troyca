<?php

namespace App\Http\Controllers;

use App\Models\DatosPersonale;
use App\Models\DetalleAporte;
use App\Models\DetallePrestamo;
use App\Models\Prestamo;
use App\Models\PrestamoCuota;
use App\Models\RegistroSocio;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Dotenv\Exception\ValidationException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException as ValidationValidationException;

class EstadoDeCuentaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $registroSocioId = RegistroSocio::where('user_id', auth()->user()->id)->first()->id ?? null;
        $prestamos = Prestamo::where('estado', 0)
            ->when(!auth()->user()->hasRole('admin'), function ($query) use ($registroSocioId) {
                if ($registroSocioId) {
                    return $query->where('registro_socio_id', $registroSocioId);
                }
            })
            ->with('registroSocio.datosPersonales')
            ->paginate(10);
        return view('estado-cuenta.index', compact('prestamos'));
    }
    public function consultaCliente(Request $request)
    {
        // Verificar que el parámetro dni esté presente
        $dni = $request->input('dni');

        if (!$dni) {
            return response()->json(['error' => 'DNI no proporcionado'], 400);
        }

        // Buscar el cliente por su DNI
        $cliente = DatosPersonale::where('dni', $dni)->first();

        if ($cliente) {
            return response()->json([
                'id_socio' => $cliente->registro_socio_id,
                'nombre_completo' => $cliente->nombres . ' ' . $cliente->apellido_paterno . ' ' . $cliente->apellido_materno
            ]);
        }

        return response()->json(['error' => 'Cliente no encontrado'], 404);
    }
    public function generarNumeroExpediente()
    {
        $lastCodigo = Prestamo::max('expediente') ?? '0000000';
        $nextId = intval($lastCodigo) + 1;
        return response()->json(['expediente' => str_pad($nextId, 7, '0', STR_PAD_LEFT)]);
    }
    public function findAll()
    {
        try {
            $registroSocioId = RegistroSocio::where('user_id', auth()->user()->id)->first()->id ?? null;

            $prestamos = Prestamo::where('estado', 0)
                ->when(!auth()->user()->hasRole('admin'), function ($query) use ($registroSocioId) {
                    if ($registroSocioId) {
                        return $query->where('registro_socio_id', $registroSocioId);
                    }
                })
                ->with('registroSocio.datosPersonales', 'asesor')
                ->get();

            return response()->json($prestamos);
        } catch (\Throwable $th) {
            return response()->json(['error' => $th->getMessage()], 500);
        }
    }
    public function getSociosDisponibles()
    {
        $socios = RegistroSocio::where('registro_socios.estado', 0)
            ->join('datos_personales', 'registro_socios.id', '=', 'datos_personales.registro_socio_id')
            ->select(
                'registro_socios.id',
                DB::raw("CONCAT(datos_personales.nombres, ' ', datos_personales.apellido_paterno, ' ', datos_personales.apellido_materno) AS nombre_completo")
            )
            ->get();

        if ($socios->isEmpty()) {
            return response()->json([
                'message' => 'No hay socios disponibles en este momento.'
            ], 404);
        }
        return response()->json([
            'socios' => $socios
        ], 200);
    }
    public function pagarCuotaApi($id)
    {
        $cuota = PrestamoCuota::find($id);
        if (!$cuota) {
            return response()->json([
                'error' => 'Cuota no encontrada.'
            ], 404);
        }
        $fechaActual = Carbon::now()->format('Y-m-d');
        $cuota->estado = ($cuota->estado == 1) ? 0 : 1;
        $cuota->fecha_pago_realizado = $cuota->estado == 1 ? $fechaActual : null;
        $cuota->save();

        $totalPagado = PrestamoCuota::where('prestamos_id', $cuota->prestamos_id)->where('estado', 1)->sum('cuota');
        $totalAmortizacion = PrestamoCuota::where('prestamos_id', $cuota->prestamos_id)->sum('amortizacion');

        $totalInteres = PrestamoCuota::where('prestamos_id', $cuota->prestamos_id)->sum('interes');
        $totalCuota = PrestamoCuota::where('prestamos_id', $cuota->prestamos_id)->sum('subtotal');
        $subtotal = $totalCuota - $totalPagado;
        $totalMora = PrestamoCuota::where('prestamos_id', $cuota->prestamos_id)->sum('mora');

        return response()->json([
            'estado' => $cuota->estado,
            'mensaje' => $cuota->estado == 1 ? 'Pagado' : 'Pendiente',
            'totalPagado' => number_format($totalPagado, 2),
            'fechaPago' => $cuota->fecha_pago_realizado,
            'totalAmortizacion' => number_format($totalAmortizacion, 2),
            'totalInteres' => number_format($totalInteres, 2),
            'totalCuota' => number_format($totalCuota, 2),
            'totalMora' => number_format($totalMora, 2),
            'subtotal' => number_format($subtotal, 2),
        ]);
    }
    public function findOne($id)
    {
        try {
            $estadoCuenta = PrestamoCuota::where('prestamos_id', $id)->with('prestamo')->get();
            $totalPagado = PrestamoCuota::where('prestamos_id', $id)->where('estado', 1)->sum('cuota');
            $totalAmortizacion = PrestamoCuota::where('prestamos_id', $id)->sum('amortizacion');
            $totalInteres = PrestamoCuota::where('prestamos_id', $id)->sum('interes');
            $totalCuota = PrestamoCuota::where('prestamos_id', $id)->sum('subtotal');
            $subtotal = $totalCuota - $totalPagado;
            $totalMora = PrestamoCuota::where('prestamos_id', $id)->sum('mora');
            if (!$estadoCuenta) {
                return response()->json([
                    'error' => 'Estado de cuenta no encontrado.'
                ], 404);
            }

            return response()->json($estadoCuenta);
        } catch (\Throwable $th) {
            return response()->json(['error' => $th->getMessage()], 500);
        }
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $socios = RegistroSocio::where('registro_socios.estado', 0)
            ->join('datos_personales', 'registro_socios.id', '=', 'datos_personales.registro_socio_id')
            ->select(
                'registro_socios.id',
                DB::raw("CONCAT(datos_personales.nombres, ' ', datos_personales.apellido_paterno, ' ', datos_personales.apellido_materno) AS nombre_completo")
            )
            ->get();
        $roles = ['userHelpAdmin', 'admin'];

        $asesores = User::role($roles)->get();

        return view('estado-cuenta.nuevo-prestamo', compact('socios', 'asesores'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $expedienteExistente = Prestamo::where('expediente', $request->input('expediente'))->exists();
        if ($expedienteExistente) {
            return response()->json(['error' => 'El número de expediente ya ha sido utilizado, vuelve a guardarlo.'], 422);
        }
        if (!$request->listado_pagos) {
            return response()->json(['errorPago' => 'Genere sus cuotas'], 422);
        }
        // DB::beginTransaction();

        try {
            $request->validate(
                [
                    'fecha_solicitud' => 'required|date',
                    'dni' => 'required|string|max:8',
                    'fecha_desembolso' => 'required|date',
                    'cliente' => 'required',
                ],
                [
                    'fecha_solicitud.required' => 'La fecha de solicitud es obligatoria.',
                    'dni.required' => 'El DNI es obligatorio.',
                    'dni.max' => 'El DNI no debe tener más de 8 caracteres.',
                    'fecha_desembolso.required' => 'La fecha de desembolso es obligatoria.',
                    'cliente.required' => 'El cliente es obligatorio.',
                ]
            );
        } catch (ValidationValidationException $e) {
            return response()->json(['errors' => $e->errors()], 500);
        }
        try {
            $request->validate(
                [
                    'monto_prestamo' => 'required',
                    'tem' => 'required',
                    'cantidad_cuotas' => 'required',
                    'cuota' => 'required',
                    'fecha_p_cuota' => 'required',
                ],
                [
                    'required' => 'Llena los campos para calcular las cuotas',
                ]
            );
        } catch (ValidationValidationException   $e) {
            return response()->json(['error' => 'Llena todos los campos para calcular las cuotas.'], 422);
        }
        try {
            $prestamo = Prestamo::create([
                'fecha_solicitud' => $request->fecha_solicitud,
                'registro_socio_id' => $request->cliente,
                'producto' => $request->producto,
                'garantia' => $request->garantia,
                'detalle_garantia' => $request->detalle_garantia,
                'fecha_desembolso' => $request->fecha_desembolso,
                'dni' => $request->dni,
                'asesor_id' => $request->asesor,
                'expediente' => $request->expediente,
                'estado' => 0,

            ]);

            $detalle_prestamo = DetallePrestamo::create([
                'prestamos_id' => $prestamo->id,
                'monto' => $request->monto_prestamo,
                'modalidad' => $request->modalidad_pago,
                'tem' => $request->tem,
                'cantidad_cuotas' => $request->cantidad_cuotas,
                'cuota' => $request->cuota,
                'f_primera_cuota' => $request->fecha_p_cuota,
                // 'ted' => $request->ted,
            ]);

            $listado_pagos = json_decode($request->listado_pagos, true);
            foreach ($listado_pagos as $pago) {
                PrestamoCuota::create([
                    'prestamos_id' => $prestamo->id,
                    // 'fecha_pago' => $pago['fecha'],
                    'fecha_vencimiento' => $pago['fechaVencimiento'],
                    'cuota' => $pago['monto'],
                    'saldo_capital' => $pago['saldoCapital'],
                    'subtotal' => $pago['monto'],
                    'interes' => $pago['interes'],
                    'amortizacion' => $pago['amortizacion'],
                    'monto_pago' => $pago['montoPagado'],
                    'estado' => 0,
                ]);
            }
            // DB::commit();
            return response()->json(['success' => true, 'message' => 'Préstamo guardado con éxito']);
        } catch (\Exception $e) {
            // DB::rollBack();
            return response()->json(['error' => 'Ocurrió un error al guardar el préstamo.'], 500);
        }
    }
    public function generarPDF($id)
    {
        try {
            $prestamo = Prestamo::with('registroSocio.datosPersonales')->find($id);

            $detalles = DetallePrestamo::where('prestamos_id', $id)->first();
            $prestamoCuotas = PrestamoCuota::where('prestamos_id', $id)->get();

            $pdf = Pdf::loadView('pdfs.prestamo', compact('prestamo', 'detalles', 'prestamoCuotas'));

            return $pdf->stream('prestamo_' . $prestamo->id . '.pdf');
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error al generar el PDF',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
    public function generarPago($id)
    {
        $detallePrestamo = DetallePrestamo::where('prestamos_id', $id)->first();
        $cuotas = PrestamoCuota::where('prestamos_id', $id)->get();
        $totalPagado = PrestamoCuota::where('prestamos_id', $id)->where('estado', 1)->sum('cuota');
        $totalAmortizacion = PrestamoCuota::where('prestamos_id', $id)->sum('amortizacion');
        $totalInteres = PrestamoCuota::where('prestamos_id', $id)->sum('interes');
        $totalCuota = PrestamoCuota::where('prestamos_id', $id)->sum('subtotal');
        $subtotal = $totalCuota - $totalPagado;
        $totalMora = PrestamoCuota::where('prestamos_id', $id)->sum('mora');
        return view('estado-cuenta.pagar-prestamo', compact('cuotas', 'totalPagado', 'totalAmortizacion', 'totalInteres', 'totalCuota', 'subtotal', 'totalMora', 'detallePrestamo'));
    }
    public function pagarCuota($id)
    {

        $cuota = PrestamoCuota::find($id);
        $fechaActual = Carbon::now()->format('Y-m-d');
        $cuota->estado = ($cuota->estado == 1) ? 0 : 1;
        if ($cuota->estado == 1) {
            $cuota->fecha_pago_realizado = $fechaActual;
        } else {
            $cuota->fecha_pago_realizado = null;
        }
        $cuota->save();

        $totalPagado = PrestamoCuota::where('prestamos_id', $cuota->prestamos_id)->where('estado', 1)->sum('cuota');
        $totalAmortizacion = PrestamoCuota::where('prestamos_id', $cuota->prestamos_id)->sum('amortizacion');

        $totalInteres = PrestamoCuota::where('prestamos_id', $cuota->prestamos_id)->sum('interes');
        $totalCuota = PrestamoCuota::where('prestamos_id', $cuota->prestamos_id)->sum('subtotal');
        $subtotal = $totalCuota - $totalPagado;
        $totalMora = PrestamoCuota::where('prestamos_id', $cuota->prestamos_id)->sum('mora');

        return response()->json([
            'estado' => $cuota->estado,
            'mensaje' => $cuota->estado == 1 ? 'Pagado' : 'Pendiente',
            'totalPagado' => number_format($totalPagado, 2),
            'fechaPago' => $cuota->fecha_pago_realizado,
            'totalAmortizacion' => number_format($totalAmortizacion, 2),
            'totalInteres' => number_format($totalInteres, 2),
            'totalCuota' => number_format($totalCuota, 2),
            'totalMora' => number_format($totalMora, 2),
            'subtotal' => number_format($subtotal, 2),

        ]);
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
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
