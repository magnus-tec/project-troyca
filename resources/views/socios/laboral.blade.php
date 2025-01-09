<div class="container mx-auto px-4 py-6">
    <div class="mb-6">
        <h2 class="text-2xl font-semibold text-gray-800">Información Laboral</h2>
        <p class="text-gray-600">Complete la información laboral del socio</p>
    </div>

    <div class="bg-white rounded-lg shadow-md p-6">
        <form action="" method="">
            @csrf
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Situación Laboral -->
                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Situación Laboral
                    </label>
                    <div class="flex gap-4">
                        <label class="inline-flex items-center">
                            <input type="radio" name="situacion_laboral" value="independiente"
                                class="form-radio text-green-500"
                                {{ isset($socio->informacionLaboral) && $socio->informacionLaboral->situacion == 'independiente' ? 'checked' : '' }}>
                            <span class="ml-2">Independiente</span>
                        </label>
                        <label class="inline-flex items-center">
                            <input type="radio" name="situacion_laboral" value="dependiente"
                                class="form-radio text-green-500"
                                {{ isset($socio->informacionLaboral) && $socio->informacionLaboral->situacion == 'dependiente' ? 'checked' : '' }}>
                            <span class="ml-2">Dependiente</span>
                        </label>
                    </div>
                </div>

                <!-- Institución o Empresa -->
                <div class="md:col-span-2">
                    <label for="empresa" class="block text-sm font-medium text-gray-700 mb-2">
                        Institución y/o Empresa
                    </label>
                    <input type="text" id="empresa_laboral" name="empresa"
                        value="{{ old('institucion_empresa', $socio->informacionLaboral->institucion_empresa ?? '') }}"
                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-1 focus:ring-green-500">
                </div>

                <!-- Dirección del Centro Laboral -->
                <div class="md:col-span-2">
                    <label for="direccion_laboral" class="block text-sm font-medium text-gray-700 mb-2">
                        Dirección del Centro Laboral
                    </label>
                    <input type="text" id="direccion_laboral" name="direccion_laboral"
                        value="{{ old('direccion_laboral', $socio->informacionLaboral->direccion_laboral ?? '') }}"
                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-1 focus:ring-green-500">
                </div>

                <!-- Teléfono -->
                <div>
                    <label for="telefono_laboral" class="block text-sm font-medium text-gray-700 mb-2">
                        Teléfono
                    </label>
                    <input type="number" id="telefono_laboral" name="telefono_laboral"
                        value="{{ old('telefono_laboral', $socio->informacionLaboral->telefono_laboral ?? '') }}"
                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-1 focus:ring-green-500">
                </div>

                <!-- Cargo -->
                <div>
                    <label for="cargo" class="block text-sm font-medium text-gray-700 mb-2">
                        Cargo
                    </label>
                    <input type="text" id="cargo_laboral" name="cargo"
                        value="{{ old('cargo', $socio->informacionLaboral->cargo ?? '') }}"
                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-1 focus:ring-green-500">
                </div>
            </div>

            {{-- <div class="mt-6 flex justify-end gap-4">
                <button type="button" onclick="history.back()"
                    class="px-4 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-50">
                    Atrás
                </button>
                <button type="submit" class="px-4 py-2 bg-green-500 text-white rounded-md hover:bg-green-600">
                    Continuar
                </button>
            </div> --}}
        </form>
    </div>
</div>
