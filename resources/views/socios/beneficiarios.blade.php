<div class="container mx-auto px-4 py-6">
    <div class="mb-6">
        <h2 class="text-2xl font-semibold text-gray-800">Beneficiarios</h2>
        <p class="text-gray-600">Ingrese la información de los beneficiarios del socio</p>
    </div>

    <div class="bg-white rounded-lg shadow-md p-6">
        {{-- <form action="" method=""> --}}
        <div id="beneficiarios-container">
            <div class="beneficiario-form mb-6 pb-6 border-b border-gray-200">
                <h3 class="text-lg font-semibold text-gray-700 mb-4">Beneficiario 1</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Apellidos y Nombres -->
                    <div class="md:col-span-2">
                        <label for="apellidos_nombres_beneficiario"
                            class="block text-sm font-medium text-gray-700 mb-2">
                            Apellidos y Nombres
                        </label>
                        <input type="text" id="apellidos_nombres_beneficiario"
                            name="beneficiarios[0][apellidos_nombres]"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-1 focus:ring-green-500">
                    </div>

                    <!-- DNI -->
                    <div>
                        <label for="dni_0" class="block text-sm font-medium text-gray-700 mb-2">
                            DNI N°
                        </label>
                        <input type="text" id="dni_beneficiario" name="beneficiarios[0][dni]" maxlength="8"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-1 focus:ring-green-500">
                    </div>

                    <!-- Fecha de Nacimiento -->
                    <div>
                        <label for="fecha_nacimiento_0" class="block text-sm font-medium text-gray-700 mb-2">
                            Fecha de Nacimiento
                        </label>
                        <input type="date" id="fecha_nacimiento_beneficiario"
                            name="beneficiarios[0][fecha_nacimiento]"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-1 focus:ring-green-500">
                    </div>

                    <!-- Parentesco -->
                    <div>
                        <label for="parentesco_0" class="block text-sm font-medium text-gray-700 mb-2">
                            Parentesco
                        </label>
                        <input type="text" id="parentesco_beneficiario" name="beneficiarios[0][parentesco]"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-1 focus:ring-green-500">
                    </div>

                    <!-- Sexo -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Sexo</label>
                        <div class="flex gap-4">
                            <label class="inline-flex items-center">
                                <input type="radio" name="sexo_beneficiario" value="masculino"
                                    class="form-radio text-green-500">
                                <span class="ml-2">Masculino</span>
                            </label>
                            <label class="inline-flex items-center">
                                <input type="radio" name="sexo_beneficiario" value="femenino"
                                    class="form-radio text-green-500">
                                <span class="ml-2">Femenino</span>
                            </label>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="mt-4">
            <button type="button" id="add-beneficiario"
                class="px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600">
                Agregar otro beneficiario
            </button>
        </div>

        <div class="mt-6 flex justify-end gap-4">
            {{-- <button type="button" onclick="history.back()"
                class="px-4 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-50">
                Atrás
            </button> --}}
            <button type="submit" id="guardar-y-finalizar"
                class="px-4 py-2 bg-green-500 text-white rounded-md hover:bg-green-600">
                Guardar y Finalizar
            </button>
        </div>
        {{-- </form> --}}
    </div>
</div>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $('#guardar-y-finalizar').click(function() {
        // Agrupar los datos en objetos
        const datosPersonales = {
            apellido_paterno: $('#apellido_paterno_personal').val(),
            apellido_materno: $('#apellido_materno_personal').val(),
            nombres: $('#nombres_personal').val(),
            dni: $('#dni_personal').val(),
            fecha_nacimiento: $('#fecha_nacimiento_personal').val(),
            estado_civil: $('#estado_civil_personal').val(),
            profesion_ocupacion: $('#profesion_ocupacion_personal').val(),
            nacionalidad: $('#nacionalidad_personal').val(),
            sexo: $('input[name="sexo_personal"]:checked').val(),
        };

        const direccionDomiciliaria = {
            departamento: $('#departamento').val(),
            provincia: $('#provincia').val(),
            distrito: $('#distrito').val(),
            tipo_vivienda: $('#tipo_vivienda').val(),
            direccion: $('#direccion').val(),
            referencia: $('#referencia').val(),
            telefono: $('#telefono').val(),
            correo: $('#correo').val(),
        };

        const datosLaborales = {
            situacion: $('input[name="situacion_laboral"]:checked').val(),
            institucion_empresa: $('#empresa_laboral').val(),
            direccion_laboral: $('#direccion_laboral').val(),
            telefono_laboral: $('#telefono_laboral').val(),
            cargo: $('#cargo_laboral').val(),
        };

        const conyuge = {
            apellidos_nombres: $('#apellidos_nombres_conyuge').val(),
            dni: $('#dni_conyuge').val(),
            fecha_nacimiento: $('#fecha_nacimiento_conyuge').val(),
            celular: $('#celular_conyuge').val(),
            ocupacion: $('#ocupacion_conyuge').val(),
            direccion: $('#direccion_conyuge').val(),

        };

        console.log(conyuge)

        const beneficiarios = {
            apellidos_nombres: $('#apellidos_nombres_beneficiario').val(),
            dni: $('#dni_beneficiario').val(),
            fecha_nacimiento: $('#fecha_nacimiento_beneficiario').val(),
            parentesco: $('#parentesco_beneficiario').val(),
            sexo: $('input[name="sexo_beneficiario"]:checked').val(),
        };
        $.ajax({
            url: "{{ route('guardar-socio') }}",
            method: 'POST',
            data: {
                _token: '{{ csrf_token() }}',
                datosPersonales: datosPersonales,
                direccionDomiciliaria: direccionDomiciliaria,
                datosLaborales: datosLaborales,
                conyuges: conyuge,
                beneficiarios: beneficiarios,
            },
            success: function(response) {
                alert('¡Socio registrado con éxito!');
                window.location.href = '/registrar-socios';
            }
        });
    });
    document.addEventListener('DOMContentLoaded', function() {
        const container = document.getElementById('beneficiarios-container');
        const addButton = document.getElementById('add-beneficiario');
        let beneficiarioCount = 1;
        addButton.addEventListener('click', function() {
            beneficiarioCount++;
            const newBeneficiario = `
                <div class="beneficiario-form mb-6 pb-6 border-b border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-700 mb-4">Beneficiario ${beneficiarioCount}</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="md:col-span-2">
                            <label for="apellidos_nombres_${beneficiarioCount - 1}" class="block text-sm font-medium text-gray-700 mb-2">
                                Apellidos y Nombres
                            </label>
                            <input type="text" id="apellidos_nombres_${beneficiarioCount - 1}" name="beneficiarios[${beneficiarioCount - 1}][apellidos_nombres]" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-1 focus:ring-green-500">
                        </div>
                        <div>
                            <label for="dni_${beneficiarioCount - 1}" class="block text-sm font-medium text-gray-700 mb-2">
                                DNI N°
                            </label>
                            <input type="text" id="dni_${beneficiarioCount - 1}" name="beneficiarios[${beneficiarioCount - 1}][dni]" maxlength="8" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-1 focus:ring-green-500">
                        </div>
                        <div>
                            <label for="fecha_nacimiento_${beneficiarioCount - 1}" class="block text-sm font-medium text-gray-700 mb-2">
                                Fecha de Nacimiento
                            </label>
                            <input type="date" id="fecha_nacimiento_${beneficiarioCount - 1}" name="beneficiarios[${beneficiarioCount - 1}][fecha_nacimiento]" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-1 focus:ring-green-500">
                        </div>
                        <div>
                            <label for="parentesco_${beneficiarioCount - 1}" class="block text-sm font-medium text-gray-700 mb-2">
                                Parentesco
                            </label>
                            <input type="text" id="parentesco_${beneficiarioCount - 1}" name="beneficiarios[${beneficiarioCount - 1}][parentesco]" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-1 focus:ring-green-500">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Sexo</label>
                            <div class="flex gap-4">
                                <label class="inline-flex items-center">
                                    <input type="radio" name="beneficiarios[${beneficiarioCount - 1}][sexo]" value="masculino" class="form-radio text-green-500">
                                    <span class="ml-2">Masculino</span>
                                </label>
                                <label class="inline-flex items-center">
                                    <input type="radio" name="beneficiarios[${beneficiarioCount - 1}][sexo]" value="femenino" class="form-radio text-green-500">
                                    <span class="ml-2">Femenino</span>
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
            `;
            container.insertAdjacentHTML('beforeend', newBeneficiario);
        });
    });
</script>
