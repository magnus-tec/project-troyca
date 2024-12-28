{{-- <div class="container mx-auto px-4 py-6">
    {{-- <div class="mb-6">
        <h2 class="text-2xl font-semibold text-gray-800">Beneficiarios</h2>
        <p class="text-gray-600">Ingrese la información de los beneficiarios del socio</p>
    </div> 

    <div class="bg-white rounded-lg shadow-md p-6">

        <div id="beneficiarios-container">
            <div class="beneficiario-form mb-4 pb-4 border-b border-gray-200">
                <h3 class="text-sm font-semibold text-gray-700 mb-3">Beneficiario 1</h3>
                <div class="grid grid-cols-1 md:grid-cols-3  lg:grid-cols-5 gap-4">
                    <div class="md:col-span-2">
                        <label for="apellidos_nombres_beneficiario_0" class="block font-medium text-gray-700 mb-1">
                            Apellidos y Nombres
                        </label>
                        <input type="text" id="apellidos_nombres_beneficiario_0"
                            name="beneficiarios[0][apellidos_nombres]"
                            class="w-full px-2 py-1 border border-gray-300 rounded-md focus:outline-none focus:ring-1 focus:ring-green-500 text-sm">
                    </div>

                    <div>
                        <label for="dni_0" class="block  font-medium text-gray-700 mb-1">
                            DNI N°
                        </label>
                        <input type="text" id="dni_beneficiario_0" name="beneficiarios[0][dni]" maxlength="8"
                            class="w-full px-2 py-1 border border-gray-300 rounded-md focus:outline-none focus:ring-1 focus:ring-green-500 text-sm">
                    </div>

                    <!-- Fecha de Nacimiento -->
                    <div>
                        <label for="fecha_nacimiento_0" class="block  font-medium text-gray-700 mb-1">
                            Fecha de Nacimiento
                        </label>
                        <input type="date" id="fecha_nacimiento_beneficiario_0"
                            name="beneficiarios[0][fecha_nacimiento]"
                            class="w-full px-2 py-1 border border-gray-300 rounded-md focus:outline-none focus:ring-1 focus:ring-green-500 text-sm">
                    </div>

                    <!-- Parentesco -->
                    <div>
                        <label for="parentesco_0" class="block font-medium text-gray-700 mb-1">
                            Parentesco
                        </label>
                        <input type="text" id="parentesco_beneficiario_0" name="beneficiarios[0][parentesco]"
                            class="w-full px-2 py-1 border border-gray-300 rounded-md focus:outline-none focus:ring-1 focus:ring-green-500 text-sm">
                    </div>

                    <!-- Sexo -->
                    <div>
                        <label class="block  font-medium text-gray-700 mb-1">Sexo</label>
                        <div class="flex gap-3">
                            <label class="inline-flex items-center text-sm">
                                <input type="radio" name="sexo_beneficiario_0" value="masculino"
                                    class="form-radio text-green-500">
                                <span class="ml-2">Masculino</span>
                            </label>
                            <label class="inline-flex items-center text-sm">
                                <input type="radio" name="sexo_beneficiario_0" value="femenino"
                                    class="form-radio text-green-500">
                                <span class="ml-2">Femenino</span>
                            </label>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <div class="mt-3">
            <button type="button" id="add-beneficiario"
                class="px-3 py-1.5 bg-blue-500 text-white rounded-md text-sm hover:bg-blue-600">
                Agregar otro beneficiario xdxd
            </button>
        </div>


    </div>
    <div class="mt-6 flex justify-end gap-4">

        <button type="submit" id="guardar-y-finalizar"
            class="px-4 py-2 bg-green-500 text-white rounded-md hover:bg-green-600">
            Guardar y Finalizar
        </button>
    </div>
</div> --}}
<div class="bg-white rounded-lg shadow-md p-6">
    <button class="px-3 py-1 bg-blue-500 text-white rounded-md text-sm hover:bg-blue-600" id="add-beneficiario-prueba">
        PRUEBA
    </button>
    <div id="beneficiarios-container">
        @if (isset($socio->beneficiarios)) <!-- Verifica si existen beneficiarios -->
            @foreach ($socio->beneficiarios as $index => $beneficiario)
                <div class="beneficiario-form mb-4 pb-4 border-b border-gray-200" id="beneficiario-{{ $index }}">
                    <h3 class="text-sm font-semibold text-gray-700 mb-3 beneficiario-contador">Beneficiario
                        {{ $index + 1 }}</h3>
                    <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-5 gap-4">
                        <div class="md:col-span-2">
                            <label for="apellidos_nombres_beneficiario_{{ $index }}"
                                class="block font-medium text-gray-700 mb-1">
                                Apellidos y Nombres
                            </label>
                            <input type="text" id="apellidos_nombres_beneficiario_{{ $index }}"
                                name="beneficiarios[{{ $index }}][apellidos_nombres]"
                                class="w-full px-2 py-1 border border-gray-300 rounded-md focus:outline-none focus:ring-1 focus:ring-green-500 text-sm"
                                value="{{ old('beneficiarios.' . $index . '.apellidos_nombres', $beneficiario->apellidos_nombres) }}">
                        </div>

                        <div>
                            <label for="dni_{{ $index }}" class="block font-medium text-gray-700 mb-1">
                                DNI N°
                            </label>
                            <input type="text" id="dni_beneficiario_{{ $index }}"
                                name="beneficiarios[{{ $index }}][dni]" maxlength="8"
                                class="w-full px-2 py-1 border border-gray-300 rounded-md focus:outline-none focus:ring-1 focus:ring-green-500 text-sm"
                                value="{{ old('beneficiarios.' . $index . '.dni', $beneficiario->dni) }}">
                        </div>

                        <div>
                            <label for="fecha_nacimiento_{{ $index }}"
                                class="block font-medium text-gray-700 mb-1">
                                Fecha de Nacimiento
                            </label>
                            <input type="date" id="fecha_nacimiento_beneficiario_{{ $index }}"
                                name="beneficiarios[{{ $index }}][fecha_nacimiento]"
                                class="w-full px-2 py-1 border border-gray-300 rounded-md focus:outline-none focus:ring-1 focus:ring-green-500 text-sm"
                                value="{{ old('beneficiarios.' . $index . '.fecha_nacimiento', $beneficiario->fecha_nacimiento) }}">
                        </div>

                        <div>
                            <label for="parentesco_{{ $index }}" class="block font-medium text-gray-700 mb-1">
                                Parentesco
                            </label>
                            <input type="text" id="parentesco_beneficiario_{{ $index }}"
                                name="beneficiarios[{{ $index }}][parentesco]"
                                class="w-full px-2 py-1 border border-gray-300 rounded-md focus:outline-none focus:ring-1 focus:ring-green-500 text-sm"
                                value="{{ old('beneficiarios.' . $index . '.parentesco', $beneficiario->parentesco) }}">
                        </div>

                        <div>
                            <label class="block font-medium text-gray-700 mb-1">Sexo</label>
                            <div class="flex gap-3">
                                <label class="inline-flex items-center text-sm">
                                    <input type="radio" name="sexo_beneficiario_{{ $index }}"
                                        value="masculino" class="form-radio text-green-500"
                                        {{ old('beneficiarios.' . $index . '.sexo', $beneficiario->sexo) == 'masculino' ? 'checked' : '' }}>
                                    <span class="ml-2">Masculino</span>
                                </label>
                                <label class="inline-flex items-center text-sm">
                                    <input type="radio" name="sexo_beneficiario_{{ $index }}" value="femenino"
                                        class="form-radio text-green-500"
                                        {{ old('beneficiarios.' . $index . '.sexo', $beneficiario->sexo) == 'femenino' ? 'checked' : '' }}>
                                    <span class="ml-2">Femenino</span>
                                </label>
                            </div>
                            <!-- Botón de eliminar beneficiario -->
                            <div class="mt-2">
                                <button type="button"
                                    class="px-3 py-1 bg-red-500 text-white rounded-md text-sm hover:bg-red-600"
                                    onclick="eliminarBeneficiario('{{ $beneficiario->id }}')">
                                    Eliminar Beneficiario
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        @else
            <p class="text-gray-500">No hay beneficiarios registrados.</p>
        @endif
    </div>

    <div class="mt-3">
        <button type="button" id="add-beneficiario"
            class="px-3 py-1.5 bg-blue-500 text-white rounded-md text-sm hover:bg-blue-600">
            Agregar otro beneficiario
        </button>
    </div>

    <div class="mt-6 flex justify-end gap-4">
        <button type="submit" id="guardar-y-finalizar"
            class="px-4 py-2 bg-green-500 text-white rounded-md hover:bg-green-600">
            Guardar y Finalizar
        </button>
    </div>
</div>


<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    let beneficiarioCount = 0;
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
        // const beneficiarios = {
        //     apellidos_nombres: $('#apellidos_nombres_beneficiario').val(),
        //     dni: $('#dni_beneficiario').val(),
        //     fecha_nacimiento: $('#fecha_nacimiento_beneficiario').val(),
        //     parentesco: $('#parentesco_beneficiario').val(),
        //     sexo: $('input[name="sexo_beneficiario"]:checked').val(),
        // };
        $.ajax({
            url: "{{ route('socios.store') }}",
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
                window.location.href = "{{ route('socios.index') }}";
            }
        });
    });
    let beneficiarios = [];

    function eliminarBeneficiario(index) {
        // Eliminar el contenedor del beneficiario
        var beneficiarioContainer = document.getElementById('beneficiario-' + index);
        beneficiarioContainer.remove();

        // Enviar la eliminación al backend
        fetch('/ruta/para/eliminar/beneficiario', {
                method: 'DELETE',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({
                    index: index
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    console.log("Beneficiario eliminado");
                } else {
                    console.error("Hubo un error al eliminar al beneficiario");
                }
            })
            .catch(error => {
                console.error('Error al eliminar el beneficiario:', error);
            });
    }


    function capturarBeneficiarios() {
        const beneficiariosForm = document.querySelectorAll('.beneficiario-form');
        beneficiarios.length = 0; // Limpiar el array antes de agregar nuevos datos

        beneficiariosForm.forEach((form, index) => {
            const apellidosNombres = form.querySelector(`#apellidos_nombres_beneficiario_${index}`)
                .value;
            const dni = form.querySelector(`#dni_beneficiario_${index}`).value;
            const fechaNacimiento = form.querySelector(`#fecha_nacimiento_beneficiario_${index}`)
                .value;
            const parentesco = form.querySelector(`#parentesco_beneficiario_${index}`).value;
            const sexo = form.querySelector(`input[name="sexo_beneficiario_${index}"]:checked`)
                ?.value;

            const beneficiario = {
                apellidos_nombres: apellidosNombres,
                dni: dni,
                fecha_nacimiento: fechaNacimiento,
                parentesco: parentesco,
                sexo: sexo
            };

            // Agregar al array de beneficiarios
            beneficiarios.push(beneficiario);
        });

        console.log(beneficiarios); // Imprimir el array en la consola (opcional)
    }
    document.addEventListener('DOMContentLoaded', function() {
        const container = document.getElementById('beneficiarios-container');
        const addButton = document.getElementById('add-beneficiario');
        const addButtonPrueba = document.getElementById('add-beneficiario-prueba');


        //         addButton.addEventListener('click', function() {
        //             console.log("data");
        //             ++beneficiarioCount;
        //             const newBeneficiario = `
        //     <div class="beneficiario-form mb-4 pb-4 border-b border-gray-200">
        //                 <h3 class="text-sm font-semibold text-gray-700 mb-3">Beneficiario ${beneficiarioCount}</h3>
        //         <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-4">
        //             <div class="md:col-span-2">
        //                 <label for="apellidos_nombres_beneficiario_${beneficiarioCount}" class="block  font-medium text-gray-700 mb-1">
        //                     Apellidos y Nombres
        //                 </label>
        //                 <input type="text" id="apellidos_nombres_beneficiario_${beneficiarioCount}" name="beneficiarios[${beneficiarioCount}][apellidos_nombres]" class="w-full px-2 py-1 border border-gray-300 rounded-md focus:outline-none focus:ring-1 focus:ring-green-500 text-sm">
        //             </div>
        //             <div>
        //                 <label for="dni_${beneficiarioCount}" class="block  font-medium text-gray-700 mb-1">
        //                     DNI N°
        //                 </label>
        //                 <input type="text" id="dni_beneficiario_${beneficiarioCount}" name="beneficiarios[${beneficiarioCount}][dni]" maxlength="8" class="w-full px-2 py-1 border border-gray-300 rounded-md focus:outline-none focus:ring-1 focus:ring-green-500 text-sm">
        //             </div>
        //             <div>
        //                 <label for="fecha_nacimiento_${beneficiarioCount}" class="block  font-medium text-gray-700 mb-1">
        //                     Fecha de Nacimiento
        //                 </label>
        //                 <input type="date" id="fecha_nacimiento_beneficiario_${beneficiarioCount}" name="beneficiarios[${beneficiarioCount}][fecha_nacimiento]" class="w-full px-2 py-1 border border-gray-300 rounded-md focus:outline-none focus:ring-1 focus:ring-green-500 text-sm">
        //             </div>
        //             <div>
        //                 <label for="parentesco_${beneficiarioCount}" class="block  font-medium text-gray-700 mb-1">
        //                     Parentesco
        //                 </label>
        //                 <input type="text" id="parentesco_beneficiario_${beneficiarioCount}" name="beneficiarios[${beneficiarioCount}][parentesco]" class="w-full px-2 py-1 border border-gray-300 rounded-md focus:outline-none focus:ring-1 focus:ring-green-500 text-sm">
        //             </div>
        //             <div>
        //                 <label class="block  font-medium text-gray-700 mb-1">Sexo</label>
        //                 <div class="flex gap-3">
        //                     <label class="inline-flex items-center text-sm">
        //                         <input type="radio" name="sexo_beneficiario_${beneficiarioCount}" value="masculino" class="form-radio text-green-500">
        //                         <span class="ml-2">Masculino</span>
        //                     </label>
        //                     <label class="inline-flex items-center text-sm">
        //                         <input type="radio" name="sexo_beneficiario_${beneficiarioCount}" value="femenino" class="form-radio text-green-500">
        //                         <span class="ml-2">Femenino</span>
        //                     </label>
        //                 </div>
        //             </div>
        //         </div>
        //     </div>
        // `;
        //             container.insertAdjacentHTML('beforeend', newBeneficiario);
        //         });

        addButtonPrueba.addEventListener('click', function() {
            console.log("data");
            const beneficiariosTitle = document.querySelectorAll('.beneficiario-contador');
            beneficiariosTitle.forEach((form, index) => {
                console.log(form);
                form.innerHTML = `Beneficiario ${index + 1}`
            })
        });

        // Función para agregar un nuevo beneficiario
        addButton.addEventListener('click', function() {
            const beneficiariosForm = document.querySelectorAll('.beneficiario-form');

            let beneficiarioCount = 0;

            // Recorrer los formularios existentes y agregar los datos al array
            beneficiariosForm.forEach((form, index) => {
                console.log(index + ' -- ' + beneficiarioCount);
                ++beneficiarioCount;

                const apellidosNombres = form.querySelector(
                    `#apellidos_nombres_beneficiario_${beneficiarioCount}`);
                const dni = form.querySelector(`#dni_beneficiario_${beneficiarioCount}`);
                const fechaNacimiento = form.querySelector(
                    `#fecha_nacimiento_beneficiario_${beneficiarioCount}`);
                const parentesco = form.querySelector(
                    `#parentesco_beneficiario_${beneficiarioCount}`);
                const sexo = form.querySelector(
                        `input[name="sexo_beneficiario_${beneficiarioCount}"]:checked`)
                    ?.value;

                // Crear el objeto del beneficiario
                const beneficiario = {
                    apellidos_nombres: apellidosNombres,
                    dni: dni,
                    fecha_nacimiento: fechaNacimiento,
                    parentesco: parentesco,
                    sexo: sexo
                };
                beneficiarios.push(beneficiario);

            });



            // Aumentamos el contador de beneficiarios
            const newBeneficiario = `
    <div class="beneficiario-form mb-4 pb-4 border-b border-gray-200" id="beneficiario-${beneficiarioCount}">
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
                <input type="text" id="dni_beneficiario_${beneficiarioCount}" name="beneficiarios[${beneficiarioCount}][dni]" maxlength="8" class="w-full px-2 py-1 border border-gray-300 rounded-md focus:outline-none focus:ring-1 focus:ring-green-500 text-sm">
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
            <button type="button" class="px-3 py-1 bg-red-500 text-white rounded-md text-sm hover:bg-red-600" onclick="eliminarBeneficiario(${beneficiarioCount})">
                Eliminar Beneficiario
            </button>
        </div>
    </div>
    `;
            container.insertAdjacentHTML('beforeend', newBeneficiario);
        });

        // Función para eliminar un beneficiario


        // Función para reajustar los índices de los beneficiarios
        function reajustarIndices() {
            const beneficiarios = document.querySelectorAll('.beneficiario-form');
            beneficiarioCount = 0; // Resetear el contador
            beneficiarios.forEach((beneficiario, index) => {
                ++beneficiarioCount;
                // Actualizar los índices de los ID y NAME de cada campo de beneficiario
                beneficiario.querySelectorAll('input').forEach(input => {
                    const name = input.name;
                    const newName = name.replace(/\[\d+\]/, `[${beneficiarioCount}]`);
                    input.name = newName;
                    const id = input.id;
                    const newId = id.replace(/\d+/, beneficiarioCount);
                    input.id = newId;
                });
                // Actualizar el título
                beneficiario.querySelector('h3').textContent = `Beneficiario ${beneficiarioCount}`;
            });
        }

        const guardarButton = document.getElementById('guardar-y-finalizar');
        guardarButton.addEventListener(
            'click',
            function() {
                capturarBeneficiarios();
                alert("Datos guardados correctamente.");
            });
    });
</script>
