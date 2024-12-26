<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalle de Aporte</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 14px;
            color: #333;
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
        }
        .header h1 {
            font-size: 24px;
            margin: 0;
        }
        .header p {
            margin: 5px 0;
        }
        .info-section {
            margin-bottom: 20px;
        }
        .info-section table {
            width: 100%;
            border-collapse: collapse;
        }
        .info-section th, .info-section td {
            text-align: left;
            padding: 8px;
        }
        .info-section th {
            background-color: #f4f4f4;
        }
        .info-section td {
            border-bottom: 1px solid #ddd;
        }
        .table-details {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        .table-details th, .table-details td {
            border: 1px solid #ddd;
            text-align: center;
            padding: 10px;
        }
        .table-details th {
            background-color: #f4f4f4;
        }
        .total {
            text-align: right;
            margin-top: 20px;
            font-size: 18px;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>Detalle de Aportes</h1>
        {{-- @dd($aporte) --}}
    </div>
    <div class="info-section">
        <h3>Información del Socio</h3>
        <table>
            <tr>
                <th>Nombre Completo</th>
                <td>{{ $aporte->registroSocio->datosPersonales->nombres }} {{ $aporte->registroSocio->datosPersonales->apellido_paterno }} {{$aporte->registroSocio->datosPersonales->apellido_materno}}</td>
            </tr>
            <tr>
                <th>Documento de Identidad</th>
                <td>{{ $aporte->registroSocio->datosPersonales->dni }}</td>
            </tr>
            <tr>
                <th>Código de Socio</th>
                <td>{{ $aporte->registroSocio->numero_socio }}</td>
            </tr>
            <tr>
                <th>Total de Aportes</th>
                <td>S/ {{ number_format($aporte->total_aportes, 2) }}</td>
            </tr>
        </table>
    </div>

    <h3>Detalle de Aportes</h3>
    <table class="table-details">
        <thead>
            <tr>
                <th>#</th>
                <th>Fecha</th>
                <th>Aporte</th>
            </tr>
        </thead>
        <tbody>
            @foreach($aporteDetalles as $index => $detalle)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ \Carbon\Carbon::parse($detalle->created_at)->format('d/m/Y H:i') }}</td>
                    <td>S/ {{ number_format($detalle->monto, 2) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="total">
        Total General: S/ {{ number_format($aporte->total_aportes, 2) }}
    </div>

</body>
</html>
