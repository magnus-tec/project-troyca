<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{-- Registro de Socio --}}
        </h2>
    </x-slot>

    <div class="container mx-auto px-4">
        <div class="mb-6">
            {{-- <h2 class="text-2xl font-semibold text-gray-800">Nuevo Registro de Socio</h2>
            <p class="text-gray-600">Complete la información en cada sección.</p> --}}
        </div>

        <div class="bg-white rounded-lg shadow-md overflow-hidden">
            <!-- Navegación por pestañas -->
            <div class="border-b border-gray-200">
                <nav class="flex space-x-8 px-6 py-4" id="tabs">
                    <a href="javascript:void(0)" data-tab="datos-personales"
                        class="tab-link group inline-flex items-center py-4 px-1 font-medium text-sm border-b-2 text-green-600 border-green-500">
                        <i data-lucide="user" class="w-5 h-5 mr-2"></i>
                        Datos Personales
                    </a>
                    <a href="javascript:void(0)" data-tab="direccionDomiciliaria"
                        class="tab-link group inline-flex items-center py-4 px-1 font-medium text-sm border-b-2 border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300">
                        <i data-lucide="home" class="w-5 h-5 mr-2"></i>
                        Dirección Domiciliaria
                    </a>
                    <a href="javascript:void(0)" data-tab="laboral"
                        class="tab-link group inline-flex items-center py-4 px-1 font-medium text-sm border-b-2 border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300">
                        <i data-lucide="briefcase" class="w-5 h-5 mr-2"></i>
                        Información Laboral
                    </a>
                    <a href="javascript:void(0)" data-tab="conyuge"
                        class="tab-link group inline-flex items-center py-4 px-1 font-medium text-sm border-b-2 border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300">
                        <i data-lucide="heart" class="w-5 h-5 mr-2"></i>
                        Datos del Cónyuge
                    </a>
                    <a href="javascript:void(0)" data-tab="beneficiarios"
                        class="tab-link group inline-flex items-center py-4 px-1 font-medium text-sm border-b-2 border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300">
                        <i data-lucide="users" class="w-5 h-5 mr-2"></i>
                        Beneficiarios
                    </a>
                </nav>
            </div>

            <!-- Contenido de las Pestañas -->
            <div id="tab-content" class="p-6">
                <div id="datos-personales" class="tab-panel">
                    @include('socios.datos-personales')
                    <button type="button" class="next-btn mt-4 px-4 py-2 bg-green-500 text-white rounded"
                        data-next="direccionDomiciliaria">Siguiente</button>
                </div>
                <div id="direccionDomiciliaria" class="tab-panel hidden">
                    @include('socios.direccion')
                    <button type="button" class="back-btn mt-4 px-4 py-2 bg-slate-600 text-white rounded"
                        data-prev="datos-personales">Atras</button>
                    <button type="button" class="next-btn mt-4 px-4 py-2 bg-green-500 text-white rounded"
                        data-next="laboral">Siguiente</button>
                </div>
                <div id="laboral" class="tab-panel hidden">
                    @include('socios.laboral')
                    <button type="button" class="back-btn mt-4 px-4 py-2 bg-slate-600 text-white rounded"
                        data-prev="direccionDomiciliaria">Atras</button>
                    <button type="button" class="next-btn mt-4 px-4 py-2 bg-green-500 text-white rounded"
                        data-next="conyuge">Siguiente</button>
                </div>
                <div id="conyuge" class="tab-panel hidden">
                    @include('socios.conyuge')
                    <button type="button" class="back-btn mt-4 px-4 py-2 bg-slate-600 text-white rounded"
                        data-prev="laboral">Atras</button>
                    <button type="button" class="next-btn mt-4 px-4 py-2 bg-green-500 text-white rounded"
                        data-next="beneficiarios">Siguiente</button>
                </div>
                <div id="beneficiarios" class="tab-panel hidden">
                    @include('socios.beneficiarios')
                    <button type="button" class="back-btn mt-4 px-4 py-2 bg-slate-600 text-white rounded"
                        data-next="conyuge" data-prev="conyuge">Atras</button>
                </div>

            </div>

        </div>
    </div>
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <!-- Mensajes de sesión -->
    {{-- @if (session('errors'))
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
    @endif --}}
    <script>
        // JavaScript para manejar las pestañas
        document.addEventListener('DOMContentLoaded', function() {
            const estadoCivil = document.getElementById('estado_civil_personal');
            const nextButtons = document.querySelectorAll('.next-btn');
            const backButtons = document.querySelectorAll('.back-btn'); // Botones para retroceder

            // Variable para determinar si se debe omitir el panel "Conyuge"
            let skipConyuge = false;

            // Escuchar cambios en el campo de "Estado Civil"
            estadoCivil.addEventListener('change', function() {
                skipConyuge = this.value === 'soltero'; // Si es "Soltero", omitir "Conyuge"
            });

            // Ajustar el comportamiento de los botones "Siguiente"
            nextButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const currentPanel = this.closest('.tab-panel');
                    const nextPanelId = this.getAttribute('data-next');

                    // Si se seleccionó "Soltero" y el siguiente panel es "Conyuge", salta a "Beneficiarios"
                    if (skipConyuge && nextPanelId === 'conyuge') {
                        showTab('beneficiarios'); // Mostrar "Beneficiarios"
                    } else {
                        showTab(nextPanelId); // Comportamiento normal
                    }
                });
            });
            const tabs = document.querySelectorAll('.tab-link');
            const panels = document.querySelectorAll('.tab-panel');

            tabs.forEach(tab => {
                tab.addEventListener('click', function() {
                    const target = this.getAttribute('data-tab');
                    showTab(target);
                });
            });
            backButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const previousPanelId = this.getAttribute('data-prev');

                    // Si se seleccionó "Soltero" y el panel actual es "Beneficiarios", regresa directamente a "Laboral"
                    if (skipConyuge && previousPanelId === 'conyuge') {
                        showTab('laboral'); // Mostrar "Laboral"
                    } else {
                        showTab(previousPanelId); // Comportamiento normal
                    }
                });
            });

            function showTab(target) {
                tabs.forEach(tab => {
                    tab.classList.toggle('text-green-600', tab.getAttribute('data-tab') === target);
                    tab.classList.toggle('border-green-500', tab.getAttribute('data-tab') === target);
                    tab.classList.toggle('text-gray-500', tab.getAttribute('data-tab') !== target);
                });

                panels.forEach(panel => {
                    panel.classList.toggle('hidden', panel.id !== target);
                });
            }
        });
    </script>
</x-app-layout>
