<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Aportes y Ahorros
        </h2>
    </x-slot>

    <div class="container mx-auto px-4 py-12">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl font-semibold text-gray-800">Registro de Aportes</h2>
            @can('registro-aporte')
                <a href="{{ route('aportes.create') }}"
                    class="bg-green-500 hover:bg-green-600 text-white font-bold py-2 px-4 rounded-lg flex items-center transition-all duration-300">
                    {{-- <i data-lucide="plus-circle" class="w-5 h-5 mr-2"></i> --}}
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
                        <th class="px-3 py-1 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Total de Aportes
                        </th>
                        <th class="px-3 py-1 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Fecha de Registro
                        </th>
                        <th class="px-3 py-1 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Acciones
                        </th>
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
                            <td class="px-3 py-1 whitespace-nowrap">
                                <div class="text-sm font-medium text-gray-900">
                                    {{ $aporte->total_aportes }}
                                </div>
                            </td>
                            <td class="px-3 py-1 whitespace-nowrap">
                                <div class="text-sm font-medium text-gray-900">
                                    {{ $aporte->fecha_registro }}
                                </div>
                            </td>
                            <td class="px-3 py-1 whitespace-nowrap text-sm font-medium">
                                <a href="{{ route('aporte-pdf', $aporte->id) }}" target="_blank"
                                    class="text-green-600 hover:text-green-800 mr-3 transition duration-200">
                                    PDF
                                </a>
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
        {{ $aportes->links() }}
    </div>
</x-app-layout>
