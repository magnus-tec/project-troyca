<?php

namespace App\Http\Controllers;

use App\Models\DetallePrestamo;
use App\Models\Prestamo;
use App\Models\PrestamoCuota;
use App\Models\RegistroSocio;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Dotenv\Exception\ValidationException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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
            ->get();

        if ($prestamos->isEmpty()) {
            $prestamos = collect([]);
        }
        return view('estado-cuenta.index', compact('prestamos'));
    }




    public function findAll()
    {
        if (!auth()->user()->hasRole('admin')) {
            $prestamos = Prestamo::where('estado', 0)
                // ->where('registro_socios_id', auth()->user()->id)
                ->with('registroSocio.datosPersonales')
                ->get();
        } else {
            $prestamos = Prestamo::where('estado', 0)
                ->with('registroSocio.datosPersonales')
                ->get();
        }

        // Retornar los préstamos como respuesta JSON
        return response()->json($prestamos);
    }
    public function storePrestamo(Request $request)
    {
        // return response()->json($request->all());
        $prestamo = Prestamo::create([
            'fecha_solicitud' => $request->fecha_solicitud,
            'registro_socio_id' => $request->registro_socio_id,
            'producto' => $request->producto,
            'garantia' => $request->garantia,
            'detalle_garantia' => $request->detalle_garantia,
            'fecha_desembolso' => $request->fecha_desembolso,
            'dni' => $request->dni,
            'asesor' => $request->asesor,
            'expediente' => $request->expediente,
            'estado' => 0,
        ]);

        $detalle_prestamo = DetallePrestamo::create([
            'prestamos_id' => $prestamo->id,
            'monto' => $request->monto,
            'modalidad' => $request->modalidad,
            'tem' => $request->tem,
            'cantidad_cuotas' => $request->cantidad_cuotas,
            'cuota' => $request->cuota,
            'f_primera_cuota' => $request->f_primera_cuota,
            'ted' => $request->ted,
        ]);

        $listado_pagos = json_decode($request->listado_pagos, true);
        foreach ($listado_pagos as $pago) {
            PrestamoCuota::create([
                'prestamos_id' => $prestamo->id,
                'fecha_pago' => $pago['fecha'],
                'fecha_vencimiento' => $pago['fechaVencimiento'],
                'cuota' => $pago['monto'],
                'saldo_capital' => $pago['saldoCapital'],
                'subtotal' => $pago['subtotal'],
                'ted' => $pago['interesDiario'],
                'monto_pago' => $pago['montoPagado'],
                'estado' => 0,
            ]);
        }

        // Retornar una respuesta JSON con los datos creados
        return response()->json([
            'message' => 'Préstamo creado con éxito.',
            'prestamo' => $prestamo,
            'detalle_prestamo' => $detalle_prestamo,
            'listado_pagos' => $listado_pagos,
        ], 201);
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

        $totalPagado = PrestamoCuota::where('estado', 1)->sum('cuota');
        return response()->json([
            'estado' => $cuota->estado,
            'mensaje' => $cuota->estado == 1 ? 'Pagado' : 'Pendiente',
            'totalPagado' => number_format($totalPagado, 2),
            'fechaPago' => $cuota->fecha_pago_realizado
        ]);
    }
    public function generarPDFBase64($id): JsonResponse
    {
        $prestamo = Prestamo::with('registroSocio.datosPersonales')->find($id);

        if (!$prestamo) {
            return response()->json(['error' => 'El préstamo no fue encontrado'], 404);
        }

        $detalles = DetallePrestamo::where('prestamos_id', $id)->first();
        $prestamoCuotas = PrestamoCuota::where('prestamos_id', $id)->where('estado', 1)->get();

        $pdf = Pdf::loadView('pdfs.prestamo', compact('prestamo', 'detalles', 'prestamoCuotas'));

        $pdfContent = $pdf->output();

        $base64Pdf = base64_encode($pdfContent);

        return response()->json([
            'message' => 'PDF generado correctamente',
            'pdf_base64' => $base64Pdf,
            'file_name' => 'prestamo_' . $prestamo->id . '.pdf',
        ]);
    }
    public function findOne($id)
    {
        $estadoCuenta = PrestamoCuota::where('prestamos_id', $id)->with('prestamo')->get();

        if (!$estadoCuenta) {
            return response()->json([
                'error' => 'Estado de cuenta no encontrado.'
            ], 404);
        }

        return response()->json($estadoCuenta);
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

        return view('estado-cuenta.nuevo-prestamo', compact('socios'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $request->validate([
                'fecha_solicitud' => 'required|date',
                'dni' => 'required|string|max:8',
                'fecha_desembolso' => 'required|date',
            ], [
                'fecha_solicitud.required' => 'La fecha de solicitud es obligatoria.',
                'dni.required' => 'El DNI es obligatorio.',
                'dni.max' => 'El DNI no debe tener más de 8 caracteres.',
                'fecha_desembolso.required' => 'La fecha de desembolso es obligatoria.',
            ]);
        } catch (ValidationException $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
        try {
            $prestamo = Prestamo::create([
                'fecha_solicitud' => $request->fecha_solicitud,
                'registro_socio_id' => $request->clientes,
                'producto' => $request->producto,
                'garantia' => $request->garantia,
                'detalle_garantia' => $request->detalle_garantia,
                'fecha_desembolso' => $request->fecha_desembolso,
                'dni' => $request->dni,
                'asesor' => $request->asesor,
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
                'ted' => $request->ted,
            ]);
            $listado_pagos = json_decode($request->listado_pagos, true);
            foreach ($listado_pagos as $pago) {
                PrestamoCuota::create([
                    'prestamos_id' => $prestamo->id,
                    'fecha_pago' => $pago['fecha'],
                    'fecha_vencimiento' => $pago['fechaVencimiento'],
                    'cuota' => $pago['monto'],
                    'saldo_capital' => $pago['saldoCapital'],
                    'subtotal' => $pago['subtotal'],
                    'ted' => $pago['interesDiario'],
                    'monto_pago' => $pago['montoPagado'],
                    'estado' => 0,
                ]);
            }
            // Retornar una respuesta de éxito
            return response()->json(['success' => true, 'message' => 'Préstamo guardado con éxito']);
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => 'Ocurrió un error al guardar el préstamo: ' . $e->getMessage()]);
        }
    }
    public function generarPDF($id)
    {
        try {
            $prestamo = Prestamo::with('registroSocio.datosPersonales')->find($id);

            $detalles = DetallePrestamo::where('prestamos_id', $id)->first();
            $prestamoCuotas = PrestamoCuota::where('prestamos_id', $id)->where('estado', 1)->get();

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
        $cuotas = PrestamoCuota::where('prestamos_id', $id)->get();
        return view('estado-cuenta.pagar-prestamo', compact('cuotas'));
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

        $totalPagado = PrestamoCuota::where('estado', 1)->sum('cuota');


        return response()->json([
            'estado' => $cuota->estado,
            'mensaje' => $cuota->estado == 1 ? 'Pagado' : 'Pendiente',
            'totalPagado' => number_format($totalPagado, 2),
            'fechaPago' => $cuota->fecha_pago_realizado

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
