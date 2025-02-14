<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reporte de Aportes</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            color: #444;
            margin: 0;
            padding: 0;
            font-size: 9px;
        }

        .container {
            width: 95%;
            max-width: 900px;
            margin: 2px auto;
            padding: 5px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        .header {
            text-align: center;
            margin-bottom: 5px;
            padding-bottom: 10px;
        }

        .header h1 {
            margin: 0;
            color: #333;
            font-size: 12px;
        }

        .header p {
            color: #666;
            margin-top: 5px;
        }

        .user-section {
            margin: 10px 0;
            padding: 3px;
            border-radius: 5px;
        }

        .user-section h3 {
            margin: 0;
            color: #333;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 5px;
        }

        th,
        td {
            padding: 2px;
            text-align: left;
            border: 1px solid #ddd;
        }


        th {
            font-weight: 600;
        }


        .total {
            font-weight: bold;
            margin-top: 10px;
            text-align: right;
        }

        .footer {
            text-align: center;
            margin-top: 40px;
            color: #666;
        }

        .footer p {
            margin: 5px 0;
        }

        .footer .signature {
            display: inline-block;
            width: 200px;
            padding-top: 10px;
            margin-top: 10px;
            font-style: italic;
        }
    </style>
</head>

<body>
    <div class="container">

        <div class="header">
            <span>Reporte de Aportes</span>
            <p>Periodo: desde {{ date('d/m/Y', strtotime($fecha_desde)) }} -
                hasta {{ date('d/m/Y', strtotime($fecha_hasta)) }}</p>
        </div>

        @foreach ($aportes as $userId => $data)
            <div class="user-section">
                <span>Registrado por: {{ $data['user']->name ?? 'Desconocido' }}</span>
            </div>

            <table>
                <thead>
                    <tr>
                        <th>Codigo</th>
                        <th>Socio</th>
                        <th>Monto (S/.)</th>
                        <th>Ejecutivo</th>
                        <th>Fecha</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($data['detalles'] as $aporte)
                        <tr>
                            <td>{{ $aporte->codigo }}</td>
                            <td>
                                {{ $aporte->aporteAhorro->registroSocio->datosPersonales->apellido_paterno }}
                                {{ $aporte->aporteAhorro->registroSocio->datosPersonales->apellido_materno }}
                                {{ $aporte->aporteAhorro->registroSocio->datosPersonales->nombres }}
                            </td>
                            <td>{{ number_format($aporte->monto, 2) }}</td>
                            <td>{{ ucfirst($aporte->user->name) }}</td>
                            <td>{{ date('d/m/Y', strtotime($aporte->fecha_registro)) }}</td> --}}
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <div class="total">
                Total Aportes: S/. {{ number_format(array_sum(array_column($data['detalles'], 'monto')), 2) }}
            </div>
        @endforeach
        {{-- 
        <div class="footer">
            <p>_________________________</p>
            <p>Firma del Administrador</p>
            <p class="signature">Fecha: {{ date('d/m/Y') }}</p>
        </div> --}}
    </div>

</body>

</html>
