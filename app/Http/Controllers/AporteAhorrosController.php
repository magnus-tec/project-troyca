<?php

namespace App\Http\Controllers;

use App\Models\AporteAhorro;
use App\Models\DatosPersonale;
use App\Models\DetalleAporte;
use App\Models\RegistroSocio;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class AporteAhorrosController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = AporteAhorro::with('registroSocio.datosPersonales')->where('estado', 0);

        if (auth()->user()->hasRole('admin')) {
            // Si el usuario es admin, realizamos la consulta completa si hay filtro
            if ($request->has('buscar') && !empty($request->buscar)) {
                $searchTerm = $request->buscar;
                $query->whereHas('registroSocio.datosPersonales', function ($q) use ($searchTerm) {
                    $q->where('dni', 'LIKE', '%' . $searchTerm . '%');
                });
            }
        } else {
            // Si no es admin, solo mostramos registros si se mandó un filtro
            if ($request->has('buscar') && !empty($request->buscar)) {
                $searchTerm = $request->buscar;
                $query->whereHas('registroSocio.datosPersonales', function ($q) use ($searchTerm) {
                    $q->where('dni', 'LIKE', '%' . $searchTerm . '%');
                });
            } else {
                // Si no hay filtro, no mostramos nada
                $aportes = [];
                return view('aporte-ahorros.index', compact('aportes'));
            }
        }
        $aportes = $query->paginate(10);
        return view('aporte-ahorros.index', compact('aportes'));
    }
    public function findAll()
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
        return response()->json($aportes);
    }


    public function generarVoucher($aporteDetalleId)
    {
        try {
            $aporteDetalleInfo = DetalleAporte::find($aporteDetalleId);
            $aporteId = $aporteDetalleInfo->aporte_id;
            $aporteInfo = AporteAhorro::find($aporteId);
            $socioCodigo = RegistroSocio::find($aporteInfo->registro_socio_id);
            $socioInfo = DatosPersonale::where('registro_socio_id', $aporteInfo->registro_socio_id)->first();
            $pdf = PDF::loadView('pdfs.voucher_aporte', compact('aporteDetalleInfo', 'aporteInfo', 'socioCodigo', 'socioInfo'))->setPaper([0, 0, 226.77, 200], 'portrait');
            return $pdf->stream('voucher_aporte.pdf');
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Error al generar el voucher'
            ], 500);
        }
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('aporte-ahorros.nuevo-aporte', [
            'nombre_completo' => null,
            'id_socio' => null,
            'error' => null
        ]);
    }
    public function adicionar($dni)
    {
        $cliente = DatosPersonale::where('dni', $dni)->first();
        if ($cliente) {
            //buscamos si el cliente tiene ya un aporte ahorro
            $aporte = AporteAhorro::where('registro_socio_id', $cliente->registro_socio_id)->first();
            if ($aporte) {
                return view('aporte-ahorros.nuevo-aporte', [
                    'id_socio' => $cliente->registro_socio_id,
                    'nombre_completo' => $cliente->nombres . ' ' . $cliente->apellido_paterno . ' ' . $cliente->apellido_materno,
                    'total_ahorros' => $aporte->total_aportes
                ]);
            }
        }
        return view('aporte-ahorros.nuevo-aporte', ['error' => 'Cliente no encontrado']);
    }
    public function buscarSocio($dni)
    {
        $cliente = DatosPersonale::where('dni', $dni)->first();

        if ($cliente) {
            //verificar si el cliente tiene ya un aporte ahorro
            $aporte = AporteAhorro::where('registro_socio_id', $cliente->registro_socio_id)->first();
            if ($aporte) {
                return response()->json([
                    'success' => true,
                    'socio' => [
                        'id_socio' => $cliente->registro_socio_id,
                        'nombre_completo' => $cliente->nombres . ' ' . $cliente->apellido_paterno . ' ' . $cliente->apellido_materno,
                        'total_ahorros' => $aporte->total_aportes
                    ]
                ]);
            } else {
                return response()->json(
                    [
                        'success' => true,
                        'socio' => [
                            'id_socio' => $cliente->registro_socio_id,
                            'nombre_completo' => $cliente->nombres . ' ' . $cliente->apellido_paterno . ' ' . $cliente->apellido_materno,
                            'total_ahorros' => 0
                        ]
                    ]
                );
            }
        }

        return response()->json([
            'success' => false,
            'message' => 'Socio no encontrado'
        ], 404);
    }
    /**
     * Store a newly created resource in storage.
     */
    public function generateCodigoAporte()
    {
        $lastCodigo = AporteAhorro::max('codigo') ?? '0000000';
        $nextCodigo = intval($lastCodigo) + 1;
        return str_pad($nextCodigo, 7, '0', STR_PAD_LEFT);
    }
    public function generateCodigoAporteCuotas()
    {
        $lastCodigo = DetalleAporte::max('codigo') ?? '0000000';
        $nextId = intval($lastCodigo) + 1;
        return str_pad($nextId, 7, '0', STR_PAD_LEFT);
    }

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
                $aporte->codigo = $this->generateCodigoAporte();
                $aporte->save();
            }
            $socio = RegistroSocio::find($request->clientes)->with('datosPersonales',)->first();

            $aporteDetalle = new DetalleAporte();
            $aporteDetalle->aporte_id = $aporte->id;
            $aporteDetalle->monto = $request->monto;
            $aporteDetalle->estado = 0;
            $aporteDetalle->codigo = $this->generateCodigoAporteCuotas();
            $aporteDetalle->save();

            return response()->json([
                'success' => true,
                'message' => 'Aporte guardado con éxito',
                'nuevoTotal' => $aporte->total_aportes,
                'aporteDetalle' => $aporteDetalle->id,
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
        try {
            $aporte = AporteAhorro::with('registroSocio.datosPersonales')->find($id);
            $aporteDetalles = DetalleAporte::where('aporte_id', $id)->get();
            $pdf = Pdf::loadView('pdfs.aporte-ahorros', compact('aporte', 'aporteDetalles'));
            return $pdf->stream('aporte-ahorros_' . $aporte->id . '.pdf');
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error al generar el PDF',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}
