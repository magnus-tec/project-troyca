<?php

namespace App\Http\Controllers;

use App\Models\AporteAhorro;
use App\Models\DatosPersonale;
use App\Models\DetalleAporte;
use App\Models\RegistroSocio;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class AporteAhorrosController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $aporteSocioId = RegistroSocio::where('user_id', auth()->user()->id)->first()->id ?? null;
        $aportes = AporteAhorro::where('estado', 0)
            ->when(!auth()->user()->hasRole('admin'), function ($query) use ($aporteSocioId) {
                if ($aporteSocioId) {
                    return $query->where('registro_socio_id', $aporteSocioId);
                }
            })
            ->with('registroSocio.datosPersonales')
            ->get();
        return view('aporte-ahorros.index', compact('aportes'));
    }
    public function generarVoucher($nuevoTotal, $aporteDetalleId)
    {
        $aporteDetalleInfo = DetalleAporte::find($aporteDetalleId);
        $aporteId = $aporteDetalleInfo->aporte_id;
        $aporteInfo = AporteAhorro::find($aporteId);
        $socioCodigo = RegistroSocio::find($aporteInfo->registro_socio_id);
        $socioInfo = DatosPersonale::find($aporteInfo->registro_socio_id);
        $pdf = PDF::loadView('pdfs.vaucher_aporte', compact('aporteDetalleInfo', 'aporteInfo', 'socioCodigo', 'socioInfo'));
        return $pdf->stream('voucher_aporte.pdf');
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
        return view('aporte-ahorros.nuevo-aporte', compact('socios'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $aporte = AporteAhorro::where('registro_socio_id', $request->clientes)->first();
            if ($aporte) {
                $nuevoTotal = $aporte->total_aportes + $request->monto;
                $aporte->update(['total_aportes' => $nuevoTotal]);
            } else {
                $aporte = new AporteAhorro();
                $aporte->registro_socio_id = $request->clientes;
                $aporte->estado = 0;
                $aporte->total_aportes = $request->monto;
                $aporte->save();
            }
            $socio = RegistroSocio::find($request->clientes)->with('datosPersonales',)->first();

            $aporteDetalle = new DetalleAporte();
            $aporteDetalle->aporte_id = $aporte->id;
            $aporteDetalle->monto = $request->monto;
            $aporteDetalle->estado = 0;
            $aporteDetalle->save();

            return response()->json([
                'success' => true,
                'message' => 'Aporte guardado con éxito',
                'nuevoTotal' => $aporte->total_aportes,
                'aporteDetalle' => $aporteDetalle->id,
                // 'aporte' => $aporte,
                'socio' => $socio->id
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'error' => $e->getMessage()
            ]);
        }
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
    public function totalAportes($id)
    {
        $total = AporteAhorro::where('registro_socio_id', $id)->value('total_aportes');
        $totalAporte = $total == null ? $total = 0 : $total;
        return response()->json([
            'total' => $totalAporte
        ]);
    }
    public function generarPDF($id)
    {
        $aporte = AporteAhorro::with('registroSocio.datosPersonales')->find($id);
        $aporteDetalles = DetalleAporte::where('aporte_id', $id)->get();
        $pdf = Pdf::loadView('pdfs.aporte-ahorros', compact('aporte', 'aporteDetalles'));
        return $pdf->stream('aporte-ahorros_' . $aporte->id . '.pdf');
    }
}
