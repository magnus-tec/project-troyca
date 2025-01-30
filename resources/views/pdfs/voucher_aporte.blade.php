 <!DOCTYPE html>
 <html lang="es">

 <head>
     <meta charset="UTF-8">
     <meta http-equiv="X-UA-Compatible" content="IE=edge">
     <meta name="viewport" content="width=device-width, initial-scale=1.0">
     <title>Voucher de Aporte</title>
     <style>
         body {
             font-family: 'Roboto Mono', monospace;
             color: #333;
             font-weight: 700;
             /* Bold */

         }

         body,
         html {
             margin: 0 auto;
             padding: 0;
             width: 98%;
             height: 98%;
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
             color: #000000;
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
             font-size: 12.5px;
         }

         p {
             margin: 0px;
             padding: 0px;
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
             background-color: #eeeeee;
             color: #000000;
             padding: 5px;
             text-align: center;
             font-size: 13px;
         }

         .message {
             font-weight: bold;
             color: #000000;
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
             <span style="font-size:15px;display: block;">LA TROYCA</span>
             <span style="font-size: 12px;display: block;">Cooperativa de ahorro y crédito</span>
             <span style="font-size: 11px;font-weight: normal;color: #000000;display: block;"> <strong
                     style="color: #000000;">Recibo de Aporte</strong></span>

         </div>
         <div class="section">
             <table style="width: 100%; border: 0;">
                 <tr>
                     <td style="width: 35%; text-align: left;">Nro Doc:</td>
                     <td style="width: 75%; text-align: left;">{{ $aporteDetalleInfo->codigo }}</td>
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

         <div class="section" style="margin-bottom: 0px;border-bottom: none;">
             <table style="width: 100%; border: 0;">
                 <tr>
                     <td style="width: 35%; text-align: left;">Cuenta:</td>
                     <td style="width: 75%; text-align: left;">{{ $socioCodigo->numero_socio }}</td>
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
                 <tr>
                     <td style="text-align: left;">Monto:</td>
                     <td style="text-align: left;">{{ $aporteDetalleInfo->monto }}</td>
                 </tr>
             </table>
         </div>

         {{-- <div class="section" style="border-top: 0.1px solid #e0e0e0;margin-bottom: 0px;border-bottom: none;">
             <table style="width: 100%;">
                 <tr>
                     <td style="width: 35%;">Monto:</td>
                     <td style="width: 75%;">{{ $aporteDetalleInfo->monto }}</td>
                 </tr>
             </table>
         </div> --}}
         <div class="total-amount">
             <p><strong>Total de Aporte:</strong> {{ $aporteInfo->total_aportes }}</p>
         </div>


         <div class="message" style="font-size: 9px;">
             <p>Aporte guardado con éxito</p>
         </div>
     </div>
 </body>

 </html>
