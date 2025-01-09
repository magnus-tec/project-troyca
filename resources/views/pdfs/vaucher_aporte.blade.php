{{-- <!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Voucher de Aporte</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            /* background-color: #f4f4f4; */
            color: #333;
        }

        .container {
            width: 80%;
            margin: 0 auto;
            /* background-color: #fff; */
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            border: 1px solid #ccc;
        }

        h1 {
            color: #2c3e50;
            border-bottom: 2px solid #ecf0f1;
            padding-bottom: 5px;
            margin-bottom: 20px;
        }

        p,
        ul {
            font-size: 14px;
            line-height: 1.8;
        }

        ul {
            padding-left: 20px;
        }

        li {
            margin-bottom: 10px;
        }

        .section-title {
            font-size: 16px;
            font-weight: bold;
            color: #2980b9;
            margin-bottom: 10px;
        }

        .details {
            margin-bottom: 20px;
        }

        .total-amount {
            background-color: #f1c40f;
            color: white;
            padding: 10px;
            border-radius: 5px;
            text-align: center;
            font-size: 18px;
            margin-bottom: 30px;
        }

        .message {
            font-size: 16px;
            font-weight: bold;
            color: #27ae60;
            text-align: center;
        }
    </style>
</head>

<body>
    <div class="container">
        <span class="text-center">La Troyca
            Cooperativa de ahorro y crédito</span>

        <div class="details">
            <p class="section-title">Detalles del Aporte</p>
            <ul>
                <li><strong>Monto:</strong> {{ $aporteDetalleInfo->monto }}</li>
            </ul>
        </div>

        <div class="details">
            <p class="section-title">Detalles del Socio</p>
            <ul>
                <li><strong>Código de Socio:</strong> {{ $socioCodigo->numero_socio }}</li>
                <li><strong>Nombre Completo:</strong> {{ $socioInfo->nombres }} {{ $socioInfo->apellido_paterno }}
                    {{ $socioInfo->apellido_materno }}</li>
                <li><strong>DNI:</strong> {{ $socioInfo->dni }}</li>
            </ul>
        </div>

        <div class="total-amount">
            <p><strong>Total de Aporte:</strong> {{ $aporteInfo->total_aportes }}</p>
        </div>

        <div class="message">
            <p>Aporte guardado con éxito</p>
        </div>
    </div>
</body>

</html> --}}
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Voucher de Aporte</title>
    <style>
        body {
            font-family: 'Helvetica Neue', Arial, sans-serif;
            margin: 0;
            padding: 20px;
            /* background-color: #f5f5f5; */
            color: #333;
        }

        .container {
            width: 60%;
            margin: 0 auto;
            background-color: #ffffff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            border: 1px solid #e0e0e0;
        }

        .header {
            text-align: center;
            padding: 10px 0;
            border-bottom: 2px solid #e0e0e0;
        }

        .header span {
            font-size: 24px;
            color: #0a134e;
            font-weight: bold;
        }

        .section {
            margin: 20px 0;
        }

        .section-title {
            font-size: 18px;
            font-weight: bold;
            color: #0a134e;
            margin-bottom: 10px;
        }

        ul {
            list-style: none;
            padding: 0;
            font-size: 16px;
        }

        li {
            padding: 8px 0;
            border-bottom: 1px solid #e0e0e0;
        }

        .total-amount {
            background-color: #0a134e;
            color: #ffffff;
            padding: 15px;
            border-radius: 5px;
            text-align: center;
            font-size: 20px;
            margin: 20px 0;
        }

        .message {
            font-size: 18px;
            font-weight: bold;
            color: #0a134e;
            text-align: center;
            margin: 20px 0;
        }

        @media (max-width: 768px) {
            .container {
                width: 90%;
                padding: 15px;
            }

            .section-title {
                font-size: 16px;
            }

            ul {
                font-size: 14px;
            }

            .total-amount {
                font-size: 18px;
            }

            .message {
                font-size: 16px;
            }
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="header">
            <span>La Troyca Cooperativa</span><br>
            <small>Cooperativa de ahorro y crédito</small>
        </div>

        <div class="section">
            <p class="section-title">Detalles del Aporte</p>
            <ul>
                <li><strong>Monto:</strong> {{ $aporteDetalleInfo->monto }}</li>
                <li><strong>Fecha y Hora:</strong> {{ $aporteDetalleInfo->fecha_registro }}</li>
            </ul>
        </div>

        <div class="section">
            <p class="section-title">Detalles del Socio</p>
            <ul>
                <li><strong>Código de Socio:</strong> {{ $socioCodigo->numero_socio }}</li>
                <li><strong>Nombre Completo:</strong> {{ $socioInfo->nombres }} {{ $socioInfo->apellido_paterno }}
                    {{ $socioInfo->apellido_materno }}</li>
                <li><strong>DNI:</strong> {{ $socioInfo->dni }}</li>
            </ul>
        </div>

        <div class="total-amount">
            <p><strong>Total de Aporte:</strong> {{ $aporteInfo->total_aportes }}</p>
        </div>

        <div class="message">
            <p>Aporte guardado con éxito</p>
        </div>
    </div>
</body>

</html>
