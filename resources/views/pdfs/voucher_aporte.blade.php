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
             color: #333;

         }

         body,
         html {
             margin: 0 auto;
             padding: 0;
             width: 95%;
             height: 95%;
         }

         .container {
             margin: 0 auto;
             background-color: #ffffff;
             padding: 0.3px;
         }

         .header {
             text-align: center;
             padding: 10px 0;
         }

         .header span {
             color: #0a134e;
             font-weight: bold;
         }

         span {
             margin: 0px;
             padding: 0px;
         }

         .section {
             border-bottom: 0.1px solid #e0e0e0;

         }

         .section table {
             font-size: 9px;
         }

         .section-title {
             font-size: 18px;
             font-weight: bold;
             color: #0a134e;
         }

         ul {
             list-style: none;
             padding: 0;
             font-size: 16px;
         }

         li {
             padding: 0.5px 0;
         }

         .total-amount {
             background-color: #0a134e;
             color: #ffffff;
             padding: 1px;
             text-align: center;
             font-size: 10px;
         }

         .message {
             font-size: 3px;
             font-weight: bold;
             color: #0a134e;
             text-align: center;
         }

         @media (max-width: 768px) {
             .container {}

             .section-title {
                 font-size: 5px;
             }

             ul {
                 font-size: 5px;
             }

             .total-amount {
                 font-size: 5px;
             }

             .message {
                 font-size: 5px;
             }
         }
     </style>
 </head>

 <body>
     <div class="container">
         <div class="header" style="display: flex; flex-direction: column; align-items: center;">
             <span style="font-size:9px;display: block;">LA TROYCA</span>
             <span style="font-size: 8px;display: block;">Cooperativa de ahorro y crédito</span>
             <span style="font-size: 7px;font-weight: normal;color: #000000;display: block;">Recibo de <strong
                     style="color: #0a134e;">Aporte</strong></span>

         </div>
         <div class="section">
             <table style="width: 100%; border: 0;">
                 <tr>
                     <td style="width: 50%; text-align: left;">Nro Doc:</td>
                     <td style="width: 50%; text-align: left;">{{ $aporteDetalleInfo->codigo }}</td>
                 </tr>
                 <tr>
                     <td style="text-align: left;">Fecha:</td>
                     <td style="text-align: left;">{{ $aporteDetalleInfo->fecha_registro }}</td>
                 </tr>
                 <tr>
                     <td style="text-align: left;">Usuario:</td>
                     <td style="text-align: left;">{{ auth()->user()->name }}</td>
                 </tr>
                 <tr>
                     <td style="text-align: left;">Fecha Imp:</td>
                     <td style="text-align: left;">{{ now('America/Lima')->format('Y-m-d H:i:s') }}</td>
                 </tr>
             </table>
         </div>

         <div class="section" style="margin-bottom: 25px;border-bottom: none;">
             <table style="width: 100%; border: 0;">
                 <tr>
                     <td style="width: 50%; text-align: left;">Cuenta:</td>
                     <td style="width: 50%; text-align: left;">{{ $socioCodigo->numero_socio }}</td>
                 </tr>
                 <tr>
                     <td style="text-align: left;">Socio:</td>
                     <td style="text-align: left;">{{ $socioInfo->nombres }} {{ $socioInfo->apellido_paterno }}
                         {{ $socioInfo->apellido_materno }}</td>
                 </tr>
                 <tr>
                     <td style="text-align: left;">Pago:</td>
                     <td style="text-align: left;">Efectivo APP Movil</td>
                 </tr>
             </table>
         </div>

         <div class="section" style="border-top: 0.1px solid #e0e0e0;margin-bottom: 5px;border-bottom: none;">
             <table style="width: 100%;">
                 <tr>
                     <td style="width: 50%; text-align: left;">Monto:</td>
                     <td style="width: 50%; text-align: right;">{{ $aporteDetalleInfo->monto }}</td>
                 </tr>
             </table>
         </div>
         <div class="total-amount">
             <p><strong>Total de Aporte:</strong> {{ $aporteInfo->total_aportes }}</p>
         </div>


         <div class="message" style="font-size: 8px;">
             <p>Aporte guardado con éxito</p>
         </div>
     </div>
 </body>

 </html>
