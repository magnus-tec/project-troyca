<x-app-layout>
    <x-slot name="header">
    </x-slot>
    <div class="container mt-6 mx-auto">
        <div class="mb-4">
            <div>
                <div class=" mx-auto p-8 bg-white rounded-lg shadow-md border border-gray-300">
                    <h3 class="text-sm font-semibold text-gray-500 mb-4  pb-2">Información de Préstamo</h3>
                    <div class="grid grid-cols-1 sm:grid-cols-3 lg:grid-cols-3 gap-4 text-gray-500 mb-5">
                        <div>
                            <div class=" py-2">
                                <span class="font-semibold text-sm">Monto: </span>
                                <span>${{ $detallePrestamo->monto }}</span>
                            </div>
                            <div class=" py-2 text-sm">
                                <span class="font-semibold">Modalidad: </span>
                                <span>{{ $detallePrestamo->modalidad }}</span>
                            </div>
                            <div class=" py-2 text-sm">
                                <span class="font-semibold">Tea: </span>
                                <span></span>
                            </div>
                            <div class=" py-2 text-sm">
                                <span class="font-semibold">Cuota: </span>
                                <span>{{ $detallePrestamo->cuota }}</span>
                            </div>
                        </div>
                        <div>
                            <div class=" py-2 text-sm">
                                <span class="font-semibold">Cuotas: </span>
                                <span>{{ $detallePrestamo->cantidad_cuotas }}</span>
                            </div>
                            <div class=" py-2 text-sm">
                                <span class="font-semibold">Tasa de Interés: </span>
                                <span>{{ $detallePrestamo->tem }}%</span>
                            </div>
                            <div class="py-2 text-sm">
                                <span class="font-semibold">F. Primera Cuota: </span>
                                <span>{{ $detallePrestamo->f_primera_cuota }}</span>
                            </div>
                        </div>


                    </div>
                    <div class="overflow-x-auto    rounded-lg">
                        <table class="min-w-full bg-white table-auto shadow-md mx-auto">
                            <thead class="bg-gray-100 border-b">
                                <tr>
                                    <th class="px-3 py-1 text-left text-sm font-medium text-gray-600">Cuota</th>
                                    <th class="px-3 py-1 text-left text-sm font-medium text-gray-600">Fecha Vencimiento
                                    </th>
                                    <th class="px-3 py-1 text-left text-sm font-medium text-gray-600">Saldo Capital</th>
                                    <th class="px-3 py-1 text-left text-sm font-medium text-gray-600">Amortizacion</th>
                                    <th class="px-3 py-1 text-left text-sm font-medium text-gray-600">Interes</th>
                                    <th class="px-3 py-1 text-left text-sm font-medium text-gray-600">Cuota</th>
                                    <th class="px-3 py-1 text-left text-sm font-medium text-gray-600">Mora</th>
                                    <th class="px-3 py-1 text-left text-sm font-medium text-gray-600">Subtotal</th>
                                    <th class="px-3 py-1 text-left text-sm font-medium text-gray-600">Monto Pago</th>
                                    <th class="px-3 py-1 text-left text-sm font-medium text-gray-600">Fecha Pago</th>
                                    @can('pagar-prestamo')
                                        <th class="px-3 py-1 text-left text-sm font-medium text-gray-600">Estado</th>
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
                                        <td class="px-3 py-1 text-sm text-gray-800">Cuota {{ $contador++ }}</td>
                                        <td class="px-3 py-1 text-sm text-gray-800">{{ $cuota->fecha_vencimiento }}</td>
                                        <td class="px-3 py-1 text-sm text-gray-800">
                                            ${{ number_format($cuota->saldo_capital, 2) }}
                                        </td>
                                        <td class="px-3 py-1 text-sm text-gray-800">
                                            ${{ number_format($cuota->amortizacion, 2) }}
                                        </td>
                                        <td class="px-3 py-1 text-sm text-gray-800">
                                            ${{ number_format($cuota->interes, 2) }}</td>
                                        <td class="px-3 py-1 text-sm text-gray-800">
                                            ${{ number_format($cuota->cuota, 2) }}</td>
                                        <td class="px-3 py-1 text-sm text-gray-800">
                                            ${{ number_format($cuota->mora, 2) }}</td>
                                        <td class="px-3 py-1 text-sm text-gray-800">
                                            ${{ number_format($cuota->subtotal, 2) }}</td>
                                        <td class="px-3 py-1 text-sm text-gray-800">
                                            ${{ number_format($cuota->monto_pago, 2) }}
                                        </td>
                                        <td class="px-3 py-1 text-sm text-gray-800">
                                            {{ $cuota->fecha_pago_realizado && $cuota->estado == 1 ? $cuota->fecha_pago_realizado : 'SIN PAGAR' }}
                                        </td>
                                        @can('pagar-prestamo')
                                            <td class="px-3 py-1">
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
                        class="mt-6  from-indigo-50 via-purple-50 to-pink-50 shadow-xl rounded-xl p-5 flex justify-between items-center">
                        <div class="">
                            <span class="text-sm font-semibold text-gray-500">Cuota: </span>
                            <span id="total-cuota" class="text-sm  text-gray-500">${{ $totalCuota }}</span>
                        </div>
                        <div class="">
                            <span class="text-sm font-semibold text-gray-500">Amortización: </span>
                            <span id="total-amortizacion"
                                class="text-sm  text-gray-600">${{ $totalAmortizacion }}</span>
                        </div>
                        <div class="">
                            <span class="text-sm font-semibold text-gray-500">Interés: </span>
                            <span id="total-interes" class="text-sm  text-gray-500">${{ $totalInteres }}</span>
                        </div>
                        <div class="">
                            <span class="text-sm font-semibold text-gray-500">Mora: </span>
                            <span id="total-mora" class="text-sm  text-gray-500">${{ $totalMora }}</span>
                        </div>
                        <div class="">
                            <span class="text-sm font-semibold text-gray-500">Subtotal: </span>
                            <span id="total-subtotal" class="text-sm  text-gray-500">${{ $subtotal }}</span>
                        </div>
                        <div class="">
                            <span class="text-sm font-semibold text-gray-500">Total Pagado: </span>
                            <span id="total-pagado" class="text-sm  text-gray-500">${{ $totalPagado }}</span>
                        </div>
                    </div>
                </div>

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
