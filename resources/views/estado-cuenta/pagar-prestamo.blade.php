<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Registro de Préstamos
        </h2>
    </x-slot>
    <div class="container mt-6 mx-auto">
        <h2 class="text-2xl font-semibold mb-4">Estado de Cuenta - Pagar Préstamo</h2>

        <div class="overflow-x-auto   rounded-lg">
            <table class="min-w-fit bg-white table-auto shadow-md">
                <thead class="bg-gray-100 border-b">
                    <tr>
                        <th class="px-6 py-3 text-left text-sm font-medium text-gray-600">Cuota</th>
                        <th class="px-6 py-3 text-left text-sm font-medium text-gray-600">Fecha Vencimiento</th>
                        <th class="px-6 py-3 text-left text-sm font-medium text-gray-600">Saldo Capital</th>
                        <th class="px-6 py-3 text-left text-sm font-medium text-gray-600">Amortizacion</th>
                        <th class="px-6 py-3 text-left text-sm font-medium text-gray-600">Interes</th>
                        <th class="px-6 py-3 text-left text-sm font-medium text-gray-600">Cuota</th>
                        <th class="px-6 py-3 text-left text-sm font-medium text-gray-600">Mora</th>
                        <th class="px-6 py-3 text-left text-sm font-medium text-gray-600">Subtotal</th>
                        <th class="px-6 py-3 text-left text-sm font-medium text-gray-600">Monto Pago</th>
                        <th class="px-6 py-3 text-left text-sm font-medium text-gray-600">Fecha Pago</th>
                        @can('pagar-prestamo')
                            <th class="px-6 py-3 text-left text-sm font-medium text-gray-600">Estado</th>
                        @endcan
                    </tr>
                </thead>
                <tbody>
                    @php

                        $contador = 1;
                    @endphp

                    @foreach ($cuotas as $cuota)
                        @if ($cuota->estado == 1)
                            @php

                            @endphp
                        @endif

                        <tr class="border-b hover:bg-gray-50">
                            <td class="px-6 py-4 text-sm text-gray-800">Cuota {{ $contador++ }}</td>
                            <td class="px-6 py-4 text-sm text-gray-800">{{ $cuota->fecha_vencimiento }}</td>
                            <td class="px-6 py-4 text-sm text-gray-800">${{ number_format($cuota->saldo_capital, 2) }}
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-800">${{ number_format($cuota->amortizacion, 2) }}
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-800">${{ number_format($cuota->interes, 2) }}</td>
                            <td class="px-6 py-4 text-sm text-gray-800">${{ number_format($cuota->cuota, 2) }}</td>
                            <td class="px-6 py-4 text-sm text-gray-800">${{ number_format($cuota->mora, 2) }}</td>
                            <td class="px-6 py-4 text-sm text-gray-800">${{ number_format($cuota->subtotal, 2) }}</td>
                            <td class="px-6 py-4 text-sm text-gray-800">${{ number_format($cuota->monto_pago, 2) }}</td>
                            <td class="px-6 py-4 text-sm text-gray-800">
                                {{ $cuota->fecha_pago_realizado && $cuota->estado == 1 ? $cuota->fecha_pago_realizado : 'SIN PAGAR' }}
                            </td>
                            @can('pagar-prestamo')
                                <td class="px-6 py-4">
                                    <button
                                        class="px-4 py-2 text-xs font-semibold rounded-full 
                                {{ $cuota->estado == 1 ? 'bg-green-500 text-white' : 'bg-yellow-500 text-white' }} 
                                hover:bg-opacity-80 focus:outline-none"
                                        onclick="cambiarEstado({{ $cuota->id }})">
                                        {{ $cuota->estado == 1 ? 'Pagado' : 'Pendiente' }}
                                    </button>
                                </td>
                            @endcan
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div
            class="mt-6  from-indigo-50 via-purple-50 to-pink-50 shadow-xl rounded-xl p-8 flex justify-between items-center">
            <div class="flex flex-col items-center">
                <h4 class="text-md font-semibold text-gray-700">Cuota</h4>
                <span id="total-cuota" class="text-lg font-bold text-teal-600">${{ $totalCuota }}</span>
            </div>
            <div class="flex flex-col items-center">
                <h4 class="text-md font-semibold text-gray-700">Amortización</h4>
                <span id="total-amortizacion" class="text-lg font-bold text-blue-600">${{ $totalAmortizacion }}</span>
            </div>
            <div class="flex flex-col items-center">
                <h4 class="text-md font-semibold text-gray-700">Interés</h4>
                <span id="total-interes" class="text-lg font-bold text-yellow-500">${{ $totalInteres }}</span>
            </div>
            <div class="flex flex-col items-center">
                <h4 class="text-md font-semibold text-gray-700">Mora</h4>
                <span id="total-mora" class="text-lg font-bold text-red-500">${{ $totalMora }}</span>
            </div>
            <div class="flex flex-col items-center">
                <h4 class="text-md font-semibold text-gray-700">Subtotal</h4>
                <span id="total-subtotal" class="text-lg font-bold text-indigo-600">${{ $subtotal }}</span>
            </div>
            <div class="flex flex-col items-center">
                <h4 class="text-md font-semibold text-gray-700">Total Pagado</h4>
                <span id="total-pagado" class="text-lg font-bold text-green-600">${{ $totalPagado }}</span>
            </div>
        </div>

    </div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script>
        function cambiarEstado(id) {
            $.ajax({
                url: "{{ route('prestamo-pagarCuota', ':id') }}".replace(':id', id),
                type: 'GET',
                success: function(response) {
                    console.log(response);
                    let button = $("button[onclick='cambiarEstado(" + id + ")']");
                    button.text(response.mensaje);
                    button.removeClass('bg-green-500 bg-yellow-500');
                    button.addClass(response.estado == 1 ? 'bg-green-500' : 'bg-yellow-500');
                    $('#total-cuota').text(response.totalCuota);
                    $('#total-amortizacion').text(response.totalAmortizacion);
                    $('#total-interes').text(response.totalInteres);
                    $('#total-mora').text(response.totalMora);
                    $('#total-subtotal').text(response.subtotal);
                    $('#total-pagado').text(response.totalPagado);
                    let row = button.closest('tr');
                    let fechaTd = row.find('td').eq(9);

                    if (response.estado == 1) {
                        fechaTd.text(response.fechaPago);
                    } else {
                        fechaTd.text('SIN PAGAR');
                    }
                },
                error: function() {
                    alert('Ocurrió un error al cambiar el estado');
                }
            });
        }
    </script>
</x-app-layout>
