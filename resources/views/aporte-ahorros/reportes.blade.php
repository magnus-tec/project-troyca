<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Reporte de aportes
        </h2>
    </x-slot>
    <div class=" container mx-auto p-6">
        <div class="bg-white rounded-lg shadow-lg  mb-5">
            <div class="flex justify-between items-center mb-6 mt-6 p-3">
                <h2 class="text-2xl font-semibold text-gray-800">Historial de Aportes</h2>
                <form class="flex items-center" id="formBuscarPorFecha">
                    <label for="">Desde: </label>
                    <input type="date" name="fecha_desde" id="fecha_desde"
                        class="border border-gray-300 rounded-lg py-2 px-4 mr-2">
                    <label for="">Hasta: </label>
                    <input type="date" name="fecha_hasta" id="fecha_hasta"
                        class="border border-gray-300 rounded-lg py-2 px-4 mr-2">

                    <button type="submit"
                        class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded-lg">
                        Buscar
                    </button>
                </form>
            </div>
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-3 py-1 text-left text-xs  font-medium text-gray-500 uppercase tracking-wider">
                            Codigo
                        </th>
                        <th class="px-3 py-1 text-left text-xs  font-medium text-gray-500 uppercase tracking-wider">
                            Nombres y Apellidos
                        </th>
                        <th class="px-3 py-1 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Monto de Aporte
                        </th>
                        <th class="px-3 py-1 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Fecha de Registro
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200" id="tbodyAportes">
                </tbody>
            </table>

        </div>
        @if ($aportes instanceof \Illuminate\Pagination\LengthAwarePaginator && $aportes->count() > 0)
            {{ $aportes->links() }}
        @endif
    </div>
    @if (session('error'))
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
            <strong class="font-bold">Error!</strong>
            <span class="block sm:inline">{{ session('error') }}</span>
        </div>
    @endif

    @if (session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
            <strong class="font-bold">Éxito!</strong>
            <span class="block sm:inline">{{ session('success') }}</span>
        </div>
    @endif
    <script>
        function finAllAportes() {
            let desde = document.getElementById('fecha_desde').value;
            let hasta = document.getElementById('fecha_hasta').value;
            fetch(`/aporte/reportes?fecha_desde=${desde}&fecha_hasta=${hasta}`)
                .then(response => response.json())
                .then(data => {
                    console.log(data);
                    document.getElementById('tbodyAportes').innerHTML = '';
                    data.forEach(aporte => {
                        let row = document.createElement('tr');
                        row.innerHTML = `
                                <td class="px-3 py-1 whitespace-nowrap">
                                    <div class="text-sm font-medium text-gray-900">
                                        ${aporte.codigo}
                                    </div>
                                </td>
                                 <td class="px-3 py-1 whitespace-nowrap">
                                    <div class="text-sm font-medium text-gray-900">
                                        ${aporte.registro_socio}
                                    </div>
                                </td>
                                <td class="px-3 py-1 whitespace-nowrap">
                                    <div class="text-sm font-medium text-gray-900">
                                        ${aporte.monto}
                                    </div>
                                </td>
                                <td class="px-3 py-1 whitespace-nowrap">
                                    <div class="text-sm font-medium text-gray-900">
                                        ${aporte.fecha_registro}
                                    </div>
                                </td>
                                <td class="px-3 py-1 whitespace-nowrap">
                                    <div class="text-sm font-medium text-gray-900">
                                        ${aporte.user ? aporte.user.name : 'No Especificado'}
                                    </div>
                                </td>
                            `;
                        document.getElementById('tbodyAportes').appendChild(row);
                    });

                })
        }
        document.getElementById('formBuscarPorFecha').addEventListener('submit', function(event) {
            event.preventDefault();
            finAllAportes();
        });
        document.addEventListener('DOMContentLoaded', () => {
            fecha_desde = document.getElementById('fecha_desde');
            fecha_hasta = document.getElementById('fecha_hasta');
            let today = new Date().toISOString().split('T')[0];
            fecha_desde.value = today;
            fecha_hasta.value = today;
            if (fecha_desde && fecha_hasta) {
                finAllAportes();
            }
        });
    </script>
</x-app-layout>
