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
            <select name="producto" id=""
                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-1 focus:ring-green-500">
                <option value="credito-prendario">credito prendario</option>
                <option value="credito-consumo">credito consumo</option>
                <option value="credito-hipotecario">credito hipotecario</option>
                <option value="credito-mype">credito mype</option>
            </select>
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
            <input type="number" name="dni"
                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-1 focus:ring-green-500">
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">
                Asesor
            </label>
            <select name="asesor" id=""
                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-1 focus:ring-green-500">
                @foreach ($asesores as $asesor)
                    <option value="{{ $asesor->id }}">{{ $asesor->name }}</option>
                @endforeach
            </select>
            {{-- <input type="text" name="asesor"
                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-1 focus:ring-green-500"> --}}
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">
                Expediente
            </label>
            <input type="text" name="expediente"
                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-1 focus:ring-green-500"
                disabled>
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
                <option value="semanal">Semanal</option>

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
            <input type="number" name="cuota" maxlength="8" disabled
                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-1 focus:ring-green-500">
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">
                F.Primera Cuota
            </label>
            <input type="date" name="fecha_p_cuota" maxlength="8"
                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-1 focus:ring-green-500">
        </div>
        {{-- <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">
                TAsa de interes diario
            </label>
            <input type="text" name="ted" maxlength="8" disabled
                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-1 focus:ring-green-500">
        </div> --}}
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
    document.getElementById('formPrestamo').addEventListener('submit', function(event) {
        event.preventDefault();

        let fecha_solicitud = document.querySelector('input[name="fecha_solicitud"]').value;
        let fecha_desembolso = document.querySelector('input[name="fecha_desembolso"]').value;
        let monto_prestamo = document.querySelector('input[name="monto_prestamo"]').value;
        let tem = document.querySelector('input[name="tem"]').value;
        let cantidad_cuotas = document.querySelector('input[name="cantidad_cuotas"]').value;
        let cuota = document.querySelector('input[name="cuota"]').value;
        let fecha_p_cuota = document.querySelector('input[name="fecha_p_cuota"]').value;
        // let ted = document.querySelector('input[name="ted"]').value;

        if (fecha_solicitud > fecha_desembolso) {
            Swal.fire({
                title: 'Error',
                text: 'La fecha de solicitud no puede ser mayor a la fecha de desembolso.',
                icon: 'error',
                confirmButtonText: 'Aceptar'
            });
            return;
        }
        const form = event.target;
        const formData = new FormData(form);
        formData.append('expediente', document.querySelector('input[name="expediente"]').value);
        formData.append('cuota', document.querySelector('input[name="cuota"]').value);
        formData.append('tem', document.querySelector('input[name="tem"]').value);
        let listadoPagos = document.querySelector('input[name="listado_pagos"]').value;


        fetch(form.action, {
                method: form.method,
                body: JSON.stringify(Object.fromEntries(formData)),
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            })
            .then(response => {
                if (!response.ok) {
                    return response.json().then(err => {
                        let errorMessages = '';
                        for (let field in err.errors) {
                            errorMessages += `${err.errors[field].join(', ')}\n`;
                        }
                        if (errorMessages) {
                            Swal.fire({
                                title: 'Errores de Validación',
                                text: errorMessages,
                                icon: 'error',
                                confirmButtonText: 'Aceptar'
                            });
                        } else if (err.error) {
                            Swal.fire({
                                title: 'Error',
                                text: err
                                    .error,
                                icon: 'error',
                                confirmButtonText: 'Aceptar'
                            });
                            codigoExpediente();
                            // limpiarPrestamo();
                        } else if (err.errorPago) {
                            Swal.fire({
                                title: 'Error',
                                text: err
                                    .errorPago,
                                icon: 'error',
                                confirmButtonText: 'Aceptar'
                            })
                            codigoExpediente();

                        }

                        throw new Error('Error en la respuesta del servidor');
                    });

                }

                return response.json();
            })
            .then(data => {
                if (data.success) {
                    Swal.fire({
                        icon: 'success',
                        title: '¡Éxito!',
                        text: data.message,
                        showConfirmButton: false,
                        timer: 1500
                    })
                    codigoExpediente();
                    limpiarPrestamo();

                }
            })
            .catch(error => {
                console.error('Error:', error);
            });
    });

    function limpiarPrestamo() {
        document.querySelector('input[name="fecha_solicitud"]').value = '';
        document.querySelector('input[name="fecha_desembolso"]').value = '';
        document.querySelector('input[name="garantia"]').value = '';
        document.querySelector('input[name="detalle_garantia"]').value = '';
        document.querySelector('input[name="dni"]').value = '';
        document.getElementById('tabla-pagos').innerHTML = '';
        document.querySelector('input[name="monto_prestamo"]').value = '';
        document.querySelector('input[name="tem"]').value = '';
        document.querySelector('input[name="cantidad_cuotas"]').value = '';
        document.querySelector('input[name="fecha_p_cuota"]').value = '';
        document.querySelector('input[name="cuota"]').value = '';
        document.querySelector('input[name="ted"]').value = '';
    }

    function redondearHaciaArriba(numero, decimales) {
        const factor = Math.pow(10, decimales);
        return Math.ceil(numero * factor) / factor;
    }

    function calculandoCuota() {
        let fechaPrimeraCuota = document.querySelector('input[name="fecha_p_cuota"]').value;
        let tasaInteres, numPagos, cuota, tasaDiaria, amortizacion, saldoCapital;
        let listadoPagos = [];
        const modalidad = document.querySelector('select[name="modalidad_pago"]').value;
        const montoPrestamo = parseFloat(document.querySelector('input[name="monto_prestamo"]').value);
        const tasa = parseFloat(document.querySelector('input[name="tem"]').value) / 100;
        const cantidadCuotas = parseInt(document.querySelector('input[name="cantidad_cuotas"]').value);
        saldoCapital = montoPrestamo;
        let calculoElevado = Math.pow(1 + tasa, cantidadCuotas);

        cuota = (saldoCapital * tasa * calculoElevado) / (calculoElevado - 1);
        document.querySelector('input[name="cuota"]').value = redondearHaciaArriba(cuota, 2);
        console.log(cuota)
        let fecha = new Date(fechaPrimeraCuota);
        let montoPagado = 0;
        for (let i = 0; i < cantidadCuotas; i++) {
            console.log("bucle");
            let fechaPago = new Date(fecha);
            let fechaVencimiento;
            if (modalidad === "diario") {
                fechaPago.setDate(fecha.getDate() + i);
                fechaVencimiento = new Date(fecha.getDate() + i + 1);
            } else if (modalidad === "semanal") {
                fechaPago.setDate(fecha.getDate() + i * 7);
                fechaVencimiento = new Date(fecha.getDate() + i * 7 + 1);
            } else if (modalidad === "mensual") {
                fechaPago.setMonth(fecha.getMonth() + i);
                fechaVencimiento = new Date(fecha.getFullYear(), fecha.getMonth() + i + 1,
                    0);
            }
            let fechaFormateada = fechaPago.toISOString().split('T')[0];
            let fechaVencimientoFormateada = fechaVencimiento.toISOString().split('T')[0];

            interes = saldoCapital * tasa;
            montoPagado += cuota;
            amortizacion = cuota - interes;
            saldoCapital -= amortizacion;
            listadoPagos.push({
                // fecha: fechaFormateada,
                fechaVencimiento: fechaFormateada,
                monto: cuota.toFixed(2),
                saldoCapital: saldoCapital.toFixed(2),
                interes: (tasaDiaria * 100).toFixed(4),
                montoPagado: montoPagado.toFixed(2),
                tem: tasa,
                amortizacion: amortizacion.toFixed(2),
                interes: interes.toFixed(2),
                pagado: false
            });
        }
        console.log("before")
        mostrarTablaPagos(listadoPagos);
        console.log("after")
        document.getElementById('listado_pagos').value = JSON.stringify(listadoPagos);
    }

    document.querySelector('#generarCuota').addEventListener('click', function(event) {
        event.preventDefault();
        calculandoCuota();
    });

    function mostrarTablaPagos(pagos) {
        console.log("tabla")
        const tablaDiv = document.getElementById('tabla-pagos');
        tablaDiv.innerHTML = '';

        const cabecera = `
            <table class="w-full table-auto border-collapse">
            <thead>
                <th class="border px-4 py-2">Nro Cuota</th>
                <th class="border px-4 py-2">Fecha de Vencimiento</th>
                <th class="border px-4 py-2">Saldo Capital</th>
                <th class="border px-4 py-2">Amortizacion</th>
                <th class="border px-4 py-2">Interes</th>
                <th class="border px-4 py-2">Cuota</th>
                <th class="border px-4 py-2">Mora</th>
                <th class="border px-4 py-2">Subtotal</th>
                <th class="border px-4 py-2">Monto Pagado</th>
                </tr>
            </thead>
            <tbody>
        `;

        let filas = '';
        console.log(pagos)
        pagos.forEach((pago, index) => {
            filas += `
        <tr>
            <td class="border px-4 py-2">Cuota ${index + 1}</td>
            <td class="border px-4 py-2">${pago.fechaVencimiento}</td>
            <td class="border px-4 py-2">${pago.saldoCapital}</td>
            <td class="border px-4 py-2">${pago.amortizacion}</td>
            <td class="border px-4 py-2">${pago.interes}</td>
            <td class="border px-4 py-2">${pago.monto}</td>
            <td class="border px-4 py-2">0.00</td>
            <td class="border px-4 py-2">${pago.monto}</td>
            <td class="border px-4 py-2">0.00</td>

        </tr>
        `;
        });

        const tablaCompleta = cabecera + filas + `</tbody></table>`;
        tablaDiv.innerHTML = tablaCompleta;
    }

    function codigoExpediente() {
        fetch('/expediente', {
                method: 'GET',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error(`HTTP error! Status: ${response.status}`);
                }
                return response.json();
            })
            .then(data => {
                console.log(data.expediente);
                document.querySelector('input[name="expediente"]').value = data.expediente;
            })
            .catch(error => {
                console.error('Error:', error);

            });
    }
    document.addEventListener('DOMContentLoaded', function() {
        codigoExpediente();
    })
</script>
