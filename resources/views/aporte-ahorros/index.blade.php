<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Aportes y Ahorros
        </h2>
    </x-slot>

    <div class="container mx-auto px-4 py-12">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl font-semibold text-gray-800">Registro de Aportes</h2>
            @can('buscar-aporte')
                <form method="GET" action="{{ route('aportes.index') }}" class="flex items-center">
                    <input type="text" name="buscar" placeholder="Buscar aporte..." value="{{ request('buscar') }}"
                        class="border border-gray-300 rounded-lg py-2 px-4 mr-2">
                    <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded-lg">
                        Buscar
                    </button>
                </form>
            @endcan
            @can('registro-aporte')
                <a href="{{ route('aportes.create') }}"
                    class="bg-blue-500 hover:bg-green-600 text-white font-bold py-2 px-4 rounded-lg flex items-center transition-all duration-300">
                    Agregar
                </a>
            @endcan
        </div>

        @if (session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-md mb-4 shadow-lg">
                {{ session('success') }}
            </div>
        @endif

        @if (session('error'))
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-md mb-4 shadow-lg">
                {{ session('error') }}
            </div>
        @endif

        <!-- Lista de socios registrados -->
        <div class="bg-white rounded-lg shadow-lg overflow-x-auto mb-5">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-3 py-1 text-left text-xs  font-medium text-gray-500 uppercase tracking-wider">
                            Codigo
                        </th>
                        <th class="px-3 py-1 text-left text-xs  font-medium text-gray-500 uppercase tracking-wider">
                            Nombres y Apellidos
                        </th>
                        @can('ver-total-aporte')
                            <th class="px-3 py-1 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Total de Aportes
                            </th>
                        @endcan
                        <th class="px-3 py-1 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Fecha de Registro
                        </th>
                        @can('acciones-aporte')
                            <th class="px-3 py-1 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Acciones
                            </th>
                        @endcan
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($aportes as $aporte)
                        <tr>
                            <td class="px-3 py-1 whitespace-nowrap">
                                <div class="text-sm font-medium text-gray-900">
                                    {{ $aporte->codigo }}
                                </div>
                            </td>
                            <td class="px-3 py-1 whitespace-nowrap">
                                <div class="text-sm font-medium text-gray-900">
                                    {{ $aporte->registroSocio->datosPersonales->apellido_paterno }}
                                    {{ $aporte->registroSocio->datosPersonales->apellido_materno }}
                                    {{ $aporte->registroSocio->datosPersonales->nombres }}
                                </div>
                            </td>
                            @can('ver-total-aporte')
                                <td class="px-3 py-1 whitespace-nowrap">
                                    <div class="text-sm font-medium text-gray-900">
                                        {{ $aporte->total_aportes }}
                                    </div>
                                </td>
                            @endcan
                            <td class="px-3 py-1 whitespace-nowrap">
                                <div class="text-sm font-medium text-gray-900">
                                    {{ $aporte->fecha_registro }}
                                </div>
                            </td>

                            @can('ver-pdf-aporte')
                                <td class="px-3 py-1 whitespace-nowrap text-sm font-medium">
                                    <a href="{{ route('aporte-pdf', $aporte->id) }}" target="_blank"
                                        class="text-green-600 hover:text-green-800 mr-3 transition duration-200">
                                        PDF
                                    </a>
                                </td>
                            @endcan
                            @can('registro-aporte')
                                <td>
                                    <a href="{{ route('aportes.adicionar', $aporte->registroSocio->datosPersonales->dni) }}"
                                        class="bg-green-500 hover:bg-green-600 font-size-sm text-white rounded-lg flex items-center transition-all duration-300 px-2 py-1"
                                        style="width: 80px;">
                                        <i class="bi bi-plus-circle-fill"></i> Aporte
                                    </a>
                                </td>
                            @endcan
                            </td>

                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="px-3 py-1 text-center text-gray-500">
                                No hay registros disponibles
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

        </div>
        @if ($aportes instanceof \Illuminate\Pagination\LengthAwarePaginator && $aportes->count() > 0)
            {{ $aportes->links() }}
        @endif
    </div>
</x-app-layout>
