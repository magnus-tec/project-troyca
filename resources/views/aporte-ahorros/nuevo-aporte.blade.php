<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{-- Registro de Socio --}}
        </h2>
    </x-slot>
    <div class="container mx-auto px-4">
        <div class="mb-6">
            <h2 class="text-2xl font-semibold text-gray-800">Nuevo Registro de Aporte y Ahorro</h2>
            <p class="text-gray-600">Complete la información en cada sección</p>
        </div>

        <div class="bg-white rounded-lg shadow-md">
            <div class="border-b border-gray-200">
                <nav class="flex space-x-8 px-6">
                    <a href="{{ route('prestamos.create') }}"
                        class="group inline-flex items-center py-4 px-1 border-b-2 font-medium text-sm border-green-500 text-green-600' hover:text-gray-700 hover:border-gray-300' }}">
                        <i data-lucide="user" class="w-5 h-5 mr-2 text-green-500'  group-hover:text-gray-500' }}"></i>
                        Datos de Solicitud
                    </a>
                </nav>
            </div>
            <div class="p-6">
                @include('aporte-ahorros.datos-aporte', [
                    'nombre_completo' => $nombre_completo,
                    'id_socio' => $id_socio,
                    'total_ahorros' => $total_ahorros,
                ])
            </div>
        </div>
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
</x-app-layout>
