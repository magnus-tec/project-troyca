<?php

namespace App\Http\Controllers;

use App\Models\DetallePrestamo;
use App\Models\Prestamo;
use App\Models\PrestamoCuota;
use App\Models\RegistroSocio;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class EstadoDeCuentaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $prestamos = Prestamo::where('estado', 0)->with('registroSocio.datosPersonales')->get();
        return view('estado-cuenta.index', compact('prestamos'));
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
        return redirect()->route('prestamos.index')->with('success', 'Préstamo guardado con éxito');
    }
    public function generarPDF($id)
    {
        $prestamo = Prestamo::with('registroSocio.datosPersonales')->find($id);

        $detalles = DetallePrestamo::where('prestamos_id', $id)->first();
        $prestamoCuotas = PrestamoCuota::where('prestamos_id', $id)->where('estado', 1)->get();

        $pdf = Pdf::loadView('pdfs.prestamo', compact('prestamo', 'detalles', 'prestamoCuotas'));

        // return $pdf->download('prestamo_' . $prestamo->id . '.pdf');
        return $pdf->stream('prestamo_' . $prestamo->id . '.pdf');
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
