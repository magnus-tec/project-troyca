<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{-- Registro de Socio --}}
        </h2>
    </x-slot>

    <div class="container mx-auto px-4">
        <div class="mb-6 text-center">
            <h2 class="text-2xl font-semibold text-gray-800">Editar Registro de Socio</h2>
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
            <div id="tab-content" class="p-6">
                <div id="datos-personales" class="tab-panel">
                    @include('socios.datos-personales')
                    <button type="button" class="next-btn mt-4 px-4 py-2 bg-green-600 text-white rounded"
                        data-next="direccionDomiciliaria">Siguiente</button>
                </div>
                <div id="direccionDomiciliaria" class="tab-panel hidden">
                    @include('socios.direccion')
                    <button type="button" class="back-btn mt-4 px-4 py-2 bg-blue-600 text-white rounded"
                        data-prev="datos-personales">Atras</button>
                    <button type="button" class="next-btn mt-4 px-4 py-2 bg-green-600 text-white rounded"
                        data-next="laboral">Siguiente</button>
                </div>
                <div id="laboral" class="tab-panel hidden">
                    @include('socios.laboral')
                    <button type="button" class="back-btn mt-4 px-4 py-2 bg-blue-600 text-white rounded"
                        data-prev="direccionDomiciliaria">Atras</button>
                    <button type="button" class="next-btn mt-4 px-4 py-2 bg-green-600 text-white rounded"
                        data-next="conyuge">Siguiente</button>
                </div>
                <div id="conyuge" class="tab-panel hidden">
                    @include('socios.conyuge')
                    <button type="button" class="back-btn mt-4 px-4 py-2 bg-blue-600 text-white rounded"
                        data-prev="laboral">Atras</button>
                    <button type="button" class="next-btn mt-4 px-4 py-2 bg-green-600 text-white rounded"
                        data-next="beneficiarios">Siguiente</button>
                </div>
                <div id="beneficiarios" class="tab-panel hidden">
                    @include('socios.beneficiarios')
                    <button type="button" class="back-btn mt-4 px-4 py-2 bg-blue-600 text-white rounded"
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
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const estadoCivil = document.getElementById('estado_civil_personal');
            const nextButtons = document.querySelectorAll('.next-btn');
            const backButtons = document.querySelectorAll('.back-btn');
            let skipConyuge = false;

            estadoCivil.addEventListener('change', function() {
                skipConyuge = this.value === 'soltero';
            });
            nextButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const currentPanel = this.closest('.tab-panel');
                    const nextPanelId = this.getAttribute('data-next');
                    if (skipConyuge && nextPanelId === 'conyuge') {
                        showTab('beneficiarios');
                    } else {
                        showTab(nextPanelId);
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
                    if (skipConyuge && previousPanelId === 'conyuge') {
                        showTab('laboral');
                    } else {
                        showTab(previousPanelId);
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
