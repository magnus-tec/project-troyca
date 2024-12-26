<div class="container mx-auto px-4 py-6">
    <div class="mb-6">
        <h2 class="text-2xl font-semibold text-gray-800">Beneficiarios</h2>
        <p class="text-gray-600">Ingrese la información de los beneficiarios del socio</p>
    </div>

    <div class="bg-white rounded-lg shadow-md p-6">
        <form action="{{ route('registro.beneficiarios.store') }}" method="POST">
            @csrf
            <div id="beneficiarios-container">
                <div class="beneficiario-form mb-6 pb-6 border-b border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-700 mb-4">Beneficiario 1</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Apellidos y Nombres -->
                        <div class="md:col-span-2">
                            <label for="apellidos_nombres_0" class="block text-sm font-medium text-gray-700 mb-2">
                                Apellidos y Nombres
                            </label>
                            <input type="text" id="apellidos_nombres_0" name="beneficiarios[0][apellidos_nombres]" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-1 focus:ring-green-500">
                        </div>

                        <!-- DNI -->
                        <div>
                            <label for="dni_0" class="block text-sm font-medium text-gray-700 mb-2">
                                DNI N°
                            </label>
                            <input type="text" id="dni_0" name="beneficiarios[0][dni]" maxlength="8" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-1 focus:ring-green-500">
                        </div>

                        <!-- Fecha de Nacimiento -->
                        <div>
                            <label for="fecha_nacimiento_0" class="block text-sm font-medium text-gray-700 mb-2">
                                Fecha de Nacimiento
                            </label>
                            <input type="date" id="fecha_nacimiento_0" name="beneficiarios[0][fecha_nacimiento]" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-1 focus:ring-green-500">
                        </div>

                        <!-- Parentesco -->
                        <div>
                            <label for="parentesco_0" class="block text-sm font-medium text-gray-700 mb-2">
                                Parentesco
                            </label>
                            <input type="text" id="parentesco_0" name="beneficiarios[0][parentesco]" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-1 focus:ring-green-500">
                        </div>

                        <!-- Sexo -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Sexo</label>
                            <div class="flex gap-4">
                                <label class="inline-flex items-center">
                                    <input type="radio" name="beneficiarios[0][sexo]" value="masculino" class="form-radio text-green-500">
                                    <span class="ml-2">Masculino</span>
                                </label>
                                <label class="inline-flex items-center">
                                    <input type="radio" name="beneficiarios[0][sexo]" value="femenino" class="form-radio text-green-500">
                                    <span class="ml-2">Femenino</span>
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="mt-4">
                <button type="button" id="add-beneficiario" class="px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600">
                    Agregar otro beneficiario
                </button>
            </div>

            <div class="mt-6 flex justify-end gap-4">
                <button type="button" onclick="history.back()" class="px-4 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-50">
                    Atrás
                </button>
                <button type="submit" class="px-4 py-2 bg-green-500 text-white rounded-md hover:bg-green-600">
                    Guardar y Finalizar
                </button>
            </div>
        </form>
    </div>
</div>

<script>
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

