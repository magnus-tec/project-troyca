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
    <div class="mt-6 flex justify-end gap-4">
        <button type="submit" id="guardar-beneficiarios"
            class="px-4 py-2 bg-green-500 text-white rounded-md hover:bg-green-600">
            Guardar y Finalizar
        </button>
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
        function removerBeneficiario(button) {
            const beneficiario = button.closest('.beneficiario-form-agregando');
            beneficiario.remove();
        }
        document.addEventListener('DOMContentLoaded', function() {
            const estadoCivil = document.getElementById('estado_civil_personal');
            const nextButtons = document.querySelectorAll('.next-btn');
            const backButtons = document.querySelectorAll('.back-btn');
            const container = document.getElementById('beneficiarios-container');
            const addButton = document.getElementById('add-beneficiario');
            const btn_guardar = document.getElementById('guardar-beneficiarios');
            let beneficiarioCount = 1;
            let skipConyuge = false;
            estadoCivil.addEventListener('change', function() {
                skipConyuge = this.value === 'soltero'; // Si es "Soltero", omitir "Conyuge"
            });
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
            };
            // GUARDAR BENEFICIARIOS
            btn_guardar.addEventListener('click', (function() {
                const beneficiariosFormNuevos = document.querySelectorAll(
                    '.beneficiario-form-agregando');
                const beneficiariosAgregar = [];

                // Agrupar los datos en objetos
                const datosPersonales = {
                    apellido_paterno: document.getElementById('apellido_paterno_personal').value,
                    apellido_materno: document.getElementById('apellido_materno_personal').value,
                    nombres: document.getElementById('nombres_personal').value,
                    dni: document.getElementById('dni_personal').value,
                    fecha_nacimiento: document.getElementById('fecha_nacimiento_personal').value,
                    estado_civil: document.getElementById('estado_civil_personal').value,
                    profesion_ocupacion: document.getElementById('profesion_ocupacion_personal')
                        .value,
                    nacionalidad: document.getElementById('nacionalidad_personal').value,
                    sexo: document.querySelector('input[name="sexo_personal"]:checked') ? document
                        .querySelector('input[name="sexo_personal"]:checked').value : null,
                };

                const direccionDomiciliaria = {
                    departamento: document.getElementById('departamento').value,
                    provincia: document.getElementById('provincia').value,
                    distrito: document.getElementById('distrito').value,
                    tipo_vivienda: document.getElementById('tipo_vivienda').value,
                    direccion: document.getElementById('direccion').value,
                    referencia: document.getElementById('referencia').value,
                    telefono: document.getElementById('telefono').value,
                    correo: document.getElementById('correo').value,
                };

                const datosLaborales = {
                    situacion: document.querySelector('input[name="situacion_laboral"]:checked') ?
                        document.querySelector('input[name="situacion_laboral"]:checked').value :
                        null,
                    institucion_empresa: document.getElementById('empresa_laboral').value,
                    direccion_laboral: document.getElementById('direccion_laboral').value,
                    telefono_laboral: document.getElementById('telefono_laboral').value,
                    cargo: document.getElementById('cargo_laboral').value,
                };

                const conyuge = {
                    apellidos_nombres: document.getElementById('apellidos_nombres_conyuge').value,
                    dni: document.getElementById('dni_conyuge').value,
                    fecha_nacimiento: document.getElementById('fecha_nacimiento_conyuge').value,
                    celular: document.getElementById('celular_conyuge').value,
                    ocupacion: document.getElementById('ocupacion_conyuge').value,
                    direccion: document.getElementById('direccion_conyuge').value,

                };

                beneficiariosFormNuevos.forEach(function(beneficiarioDiv) {
                    const apellidosNombres = beneficiarioDiv.querySelector(
                        'input[name$="[apellidos_nombres]"]').value;
                    const dni = beneficiarioDiv.querySelector('input[name$="[dni]"]').value;
                    const fechaNacimiento = beneficiarioDiv.querySelector(
                        'input[name$="[fecha_nacimiento]"]').value;
                    const parentesco = beneficiarioDiv.querySelector(
                            'input[name$="[parentesco]"]')
                        .value;
                    const sexo = beneficiarioDiv.querySelector('input[type="radio"]:checked') ?
                        beneficiarioDiv.querySelector('input[type="radio"]:checked').value :
                        null;
                    null;

                    beneficiariosAgregar.push({
                        apellidos_nombres: apellidosNombres,
                        dni,
                        fecha_nacimiento: fechaNacimiento,
                        parentesco,
                        sexo,
                    });

                });

                const datos = {
                    _token: '{{ csrf_token() }}',
                    datosPersonales: datosPersonales,
                    direcciones: direccionDomiciliaria,
                    datosLaborales: datosLaborales,
                    conyuges: conyuge,
                    beneficiarios: beneficiariosAgregar,
                };

                fetch("{{ route('socios.store') }}", {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                        },
                        body: JSON.stringify(datos),
                    })
                    .then(response => {
                        console.log(response);
                        if (!response.ok) {
                            return response.json().then(err => {
                                let errorMessages = '';

                                // Recorrer todos los campos en 'errors'
                                for (let field in err.errors) {
                                    // Unir todos los errores en un string con saltos de línea
                                    errorMessages += `${err.errors[field].join(', ')}\n`;
                                }

                                // Mostrar el mensaje de error con SweetAlert2
                                if (errorMessages) {
                                    Swal.fire({
                                        title: 'Errores de Validación',
                                        text: errorMessages,
                                        icon: 'error',
                                        confirmButtonText: 'Aceptar'
                                    });
                                }

                                throw new Error('Error en la respuesta del servidor');
                            });

                        }
                        return response.json();
                    })
                    .then(data => {
                        alert('¡Socio registrado con éxito!');
                        window.location.href = "{{ route('socios.index') }}";
                    })
                    .catch(error => {
                        console.log("catch");
                        console.error(error);
                    });
            }));
            // Agregar beneficiario
            addButton.addEventListener('click', function() {
                beneficiarioCount++;
                const newBeneficiario = `
                <div class="beneficiario-form-agregando mb-4 pb-4 border-b border-gray-200">
                    <h3 class="text-sm font-semibold text-gray-700 mb-3 beneficiario-contador">Beneficiario ${beneficiarioCount}</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-4">
                        <div class="md:col-span-2">
                            <label for="apellidos_nombres_beneficiario_${beneficiarioCount}" class="block font-medium text-gray-700 mb-1">
                                Apellidos y Nombres
                            </label>
                            <input type="text" id="apellidos_nombres_beneficiario_${beneficiarioCount}" name="beneficiarios[${beneficiarioCount}][apellidos_nombres]" class="w-full px-2 py-1 border border-gray-300 rounded-md focus:outline-none focus:ring-1 focus:ring-green-500 text-sm">
                        </div>
                        <div>
                            <label for="dni_${beneficiarioCount}" class="block font-medium text-gray-700 mb-1">
                                DNI N°
                            </label>
                            <input type="number" id="dni_beneficiario_${beneficiarioCount}" name="beneficiarios[${beneficiarioCount}][dni]" maxlength="8" class="w-full px-2 py-1 border border-gray-300 rounded-md focus:outline-none focus:ring-1 focus:ring-green-500 text-sm">
                        </div>
                        <div>
                            <label for="fecha_nacimiento_${beneficiarioCount}" class="block font-medium text-gray-700 mb-1">
                                Fecha de Nacimiento
                            </label>
                            <input type="date" id="fecha_nacimiento_beneficiario_${beneficiarioCount}" name="beneficiarios[${beneficiarioCount}][fecha_nacimiento]" class="w-full px-2 py-1 border border-gray-300 rounded-md focus:outline-none focus:ring-1 focus:ring-green-500 text-sm">
                        </div>
                        <div>
                            <label for="parentesco_${beneficiarioCount}" class="block font-medium text-gray-700 mb-1">
                                Parentesco
                            </label>
                            <input type="text" id="parentesco_beneficiario_${beneficiarioCount}" name="beneficiarios[${beneficiarioCount}][parentesco]" class="w-full px-2 py-1 border border-gray-300 rounded-md focus:outline-none focus:ring-1 focus:ring-green-500 text-sm">
                        </div>
                        <div>
                            <label class="block font-medium text-gray-700 mb-1">Sexo</label>
                            <div class="flex gap-3">
                                <label class="inline-flex items-center text-sm">
                                    <input type="radio" name="sexo_beneficiario_${beneficiarioCount}" value="masculino" class="form-radio text-green-500">
                                    <span class="ml-2">Masculino</span>
                                </label>
                                <label class="inline-flex items-center text-sm">
                                    <input type="radio" name="sexo_beneficiario_${beneficiarioCount}" value="femenino" class="form-radio text-green-500">
                                    <span class="ml-2">Femenino</span>
                                </label>
                            </div>
                        </div>
                    </div>
                    <!-- Botón de eliminar -->
                    <div class="mt-2">
                        <button type="button" class="px-3 py-1 bg-red-500 text-white rounded-md text-sm hover:bg-red-600" onclick="removerBeneficiario(this)">
                            Eliminar Beneficiario
                        </button>
                    </div>
                </div>
                `;
                container.insertAdjacentHTML('beforeend', newBeneficiario);
            });
        });
    </script>
</x-app-layout>
