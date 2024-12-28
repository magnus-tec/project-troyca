<form action="{{ route('prestamos.store') }}" method="POST" class="space-y-6" id="formPrestamo">
    @csrf
    <div class="grid grid-cols-1 md:grid-cols-5 gap-6">
        <!-- datos de solicitud -->
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">
                Fecha Solicitud
            </label>
            <input type="date" name="fecha_solicitud"
                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-1 focus:ring-green-500">
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">
                Clientes
            </label>
            <select name="clientes"
                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-1 focus:ring-green-500">
                @foreach ($socios as $socio)
                    <option value="{{ $socio->id }}">{{ $socio->nombre_completo }}</option>
                @endforeach
            </select>
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">
                Producto
            </label>
            <input type="text" name="producto"
                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-1 focus:ring-green-500">
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">
                Garantia
            </label>
            <input type="text" name="garantia"
                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-1 focus:ring-green-500">
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">
                Detalle de Garantia
            </label>
            <input type="text" name="detalle_garantia"
                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-1 focus:ring-green-500">
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">
                Fecha Desembolso
            </label>
            <input type="date" name="fecha_desembolso"
                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-1 focus:ring-green-500">
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">
                Dni
            </label>
            <input type="text" name="dni"
                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-1 focus:ring-green-500">
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">
                Asesor
            </label>
            <input type="text" name="asesor"
                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-1 focus:ring-green-500">
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">
                Expediente
            </label>
            <input type="text" name="expediente"
                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-1 focus:ring-green-500">
        </div>
        <!-- CALCULAR CUOTA -->
        <br>
        <div>
            <h1 class="text-2xl font-bold">CALCULAR CUOTA</h1>
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">
                Monto Prestamo
            </label>
            <input type="text" name="monto_prestamo"
                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-1 focus:ring-green-500">
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">
                Modalidad de pago
            </label>
            <select name="modalidad_pago" id="modalidad_pago"
                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-1 focus:ring-green-500">
                <option value="diario">Diario</option>
                <option value="mensual">Mensual</option>
            </select>
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">
                Tasa efectiva mensual
            </label>
            <input type="text" name="tem" maxlength="8"
                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-1 focus:ring-green-500">
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">
                cantidad CUOTA
            </label>
            <input type="text" name="cantidad_cuotas" maxlength="8"
                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-1 focus:ring-green-500">
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">
                CUOTA
            </label>
            <input type="text" name="cuota" maxlength="8"
                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-1 focus:ring-green-500">
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">
                F.Primera Cuota
            </label>
            <input type="date" name="fecha_p_cuota" maxlength="8"
                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-1 focus:ring-green-500">
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">
                TAsa de interes diario
            </label>
            <input type="text" name="ted" maxlength="8"
                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-1 focus:ring-green-500">
        </div>
        <input type="hidden" name="listado_pagos" id="listado_pagos">

        <button type="submit" class="px-4 py-2 bg-green-500 text-white rounded-md hover:bg-green-600"
            id="generarCuota">
            GENERAR CUOTA
        </button>

    </div>

    <div class="mt-6 flex justify-end gap-4">
        <button type="button" onclick="history.back()"
            class="px-4 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-50">
            Cancelar
        </button>
        <button type="submit" class="px-4 py-2 bg-green-500 text-white rounded-md hover:bg-green-600">
            Guardar y Continuar
        </button>
    </div>

</form>
<div id="tabla-pagos"></div>
<script>
    document.querySelector('#generarCuota').addEventListener('click', function(event) {
        event.preventDefault();
        const montoPrestamo = parseFloat(document.querySelector('input[name="monto_prestamo"]').value);
        const tasaAnual = parseFloat(document.querySelector('input[name="tem"]').value) /
            100; // Dividir entre 100 para convertir a decimal
        const cantidadCuotas = parseInt(document.querySelector('input[name="cantidad_cuotas"]').value);
        const modalidad = document.querySelector('select[name="modalidad_pago"]').value;
        const fechaPrimeraCuota = document.querySelector('input[name="fecha_p_cuota"]').value;

        // Verificar que los datos ingresados sean válidos
        if (isNaN(montoPrestamo) || isNaN(tasaAnual) || isNaN(cantidadCuotas) || cantidadCuotas <= 0 || !
            fechaPrimeraCuota) {
            alert("Por favor ingresa todos los datos correctamente.");
            return;
        }
        let tasaInteres, numPagos, cuota, tasaDiaria;
        let listadoPagos = [];
        let saldoCapital = montoPrestamo;
        if (modalidad === "mensual") {
            numPagos = cantidadCuotas;
            tasaInteres = tasaAnual / 12;
        } else {
            numPagos = cantidadCuotas;
            tasaInteres = tasaAnual / 365;
        }

        // Calcular la cuota con la fórmula de amortización
        cuota = (montoPrestamo * Math.pow(1 + tasaInteres, numPagos) * tasaInteres) / (Math.pow(1 + tasaInteres,
            numPagos) - 1);

        // Mostrar la cuota calculada
        document.querySelector('input[name="cuota"]').value = cuota.toFixed(2);

        // Calcular tasa de interés diaria (TED) con la fórmula correcta
        tasaDiaria = Math.pow(1 + tasaAnual, 1 / 365) - 1; // Calcular tasa diaria
        document.querySelector('input[name="ted"]').value = (tasaDiaria * 100).toFixed(
            4); // Mostrar tasa diaria en porcentaje

        // Calcular fechas de los pagos, vencimientos y generar los detalles
        let fecha = new Date(fechaPrimeraCuota);
        let montoPagado = 0;
        for (let i = 0; i < numPagos; i++) {
            let fechaPago = new Date(fecha);
            let fechaVencimiento;
            if (modalidad === "diario") {
                fechaPago.setDate(fecha.getDate() + i);
                fechaVencimiento = new Date(fecha.getDate() + i + 1); // Vence al siguiente día
            } else {
                fechaPago.setMonth(fecha.getMonth() + i);
                fechaVencimiento = new Date(fecha.getFullYear(), fecha.getMonth() + i + 1,
                    0); // Un día antes del siguiente mes
            }
            let fechaFormateada = fechaPago.toISOString().split('T')[0];
            let fechaVencimientoFormateada = fechaVencimiento.toISOString().split('T')[0];

            saldoCapital -= cuota; // Restar la cuota al saldo de capital
            montoPagado += cuota; // Incrementar el monto pagado

            // Agregar al listado de pagos con su interés diario
            listadoPagos.push({
                fecha: fechaFormateada,
                fechaVencimiento: fechaVencimientoFormateada,
                monto: cuota.toFixed(2),
                saldoCapital: saldoCapital.toFixed(2),
                subtotal: (montoPrestamo - saldoCapital).toFixed(2),
                interesDiario: (tasaDiaria * 100).toFixed(4), // Interés diario
                montoPagado: montoPagado.toFixed(2),
                tem: tasaAnual,
                pagado: false // Inicialmente no pagado
            });
        }

        mostrarTablaPagos(listadoPagos);
        document.getElementById('listado_pagos').value = JSON.stringify(listadoPagos);
    });

    // Función para mostrar la tabla de pagos
    function mostrarTablaPagos(pagos) {
        const tablaDiv = document.getElementById('tabla-pagos');
        tablaDiv.innerHTML = ''; // Limpiar la tabla previa

        const cabecera = `
    <table class="w-full table-auto border-collapse">
      <thead>
        <tr>
          <th class="border px-4 py-2">Fecha de Pago</th>
          <th class="border px-4 py-2">Fecha de Vencimiento</th>
          <th class="border px-4 py-2">Monto</th>
          <th class="border px-4 py-2">Saldo Capital</th>
          <th class="border px-4 py-2">Subtotal</th>
          <th class="border px-4 py-2">Monto Pagado</th>
          <th class="border px-4 py-2">Interés Diario (%)</th>
        </tr>
      </thead>
      <tbody>
  `;

        let filas = '';
        pagos.forEach((pago, index) => {
            filas += `
      <tr>
        <td class="border px-4 py-2">${pago.fecha}</td>
        <td class="border px-4 py-2">${pago.fechaVencimiento}</td>
        <td class="border px-4 py-2">${pago.monto}</td>
        <td class="border px-4 py-2">${pago.saldoCapital}</td>
        <td class="border px-4 py-2">${pago.subtotal}</td>
        <td class="border px-4 py-2">${pago.montoPagado}</td>
        <td class="border px-4 py-2">${pago.interesDiario} %</td>
      </tr>
    `;
        });

        const tablaCompleta = cabecera + filas + `</tbody></table>`;
        tablaDiv.innerHTML = tablaCompleta;
    }
</script>
