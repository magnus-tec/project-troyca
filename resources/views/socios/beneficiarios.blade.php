<div class="bg-white rounded-lg shadow-md p-6">
    <div id="beneficiarios-container">
        @if (isset($socio->beneficiarios)) <!-- Verifica si existen beneficiarios -->
            @foreach ($socio->beneficiarios as $index => $beneficiario)
                <div class="beneficiario-form-registrado mb-4 pb-4 border-b border-gray-200"
                    id="{{ old('beneficiarios', $beneficiario->id) }}">
                    <h3 class="text-sm font-semibold text-gray-700 mb-3 beneficiario-contador">Beneficiario</h3>
                    <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-5 gap-4">
                        <div class="md:col-span-2">
                            <label for="apellidos_nombres_beneficiario_{{ $index }}"
                                class="block font-medium text-gray-700 mb-1">
                                Apellidos y Nombres
                            </label>
                            <input type="text" id="apellidos_nombres_beneficiario_{{ $beneficiario->id }}"
                                name="beneficiarios[{{ $index }}][apellidos_nombres]"
                                class="w-full px-2 py-1 border border-gray-300 rounded-md focus:outline-none focus:ring-1 focus:ring-green-500 text-sm"
                                value="{{ old('apellidos_nombres', $beneficiario->apellidos_nombres) }}">
                        </div>

                        <div>
                            <label for="dni_{{ $index }}" class="block font-medium text-gray-700 mb-1">
                                DNI N°
                            </label>
                            <input type="number" id="dni_beneficiario_$beneficiario->id"
                                name="beneficiarios[{{ $index }}][dni]" maxlength="8"
                                class="w-full px-2 py-1 border border-gray-300 rounded-md focus:outline-none focus:ring-1 focus:ring-green-500 text-sm"
                                value="{{ old('dni', $beneficiario->dni) }}">
                        </div>

                        <div>
                            <label for="fecha_nacimiento_{{ $index }}"
                                class="block font-medium text-gray-700 mb-1">
                                Fecha de Nacimiento
                            </label>
                            <input type="date" id="fecha_nacimiento_beneficiario_$beneficiario->id"
                                name="beneficiarios[{{ $index }}][fecha_nacimiento]"
                                class="w-full px-2 py-1 border border-gray-300 rounded-md focus:outline-none focus:ring-1 focus:ring-green-500 text-sm"
                                value="{{ old('fecha_nacimiento', isset($beneficiario->fecha_nacimiento) ? \Carbon\Carbon::parse($beneficiario->fecha_nacimiento)->format('Y-m-d') : '') }}">
                        </div>

                        <div>
                            <label for="parentesco_{{ $index }}" class="block font-medium text-gray-700 mb-1">
                                Parentesco
                            </label>
                            <input type="text" id="parentesco_beneficiario_{{ $beneficiario->id }}"
                                name="beneficiarios[{{ $index }}][parentesco]"
                                class="w-full px-2 py-1 border border-gray-300 rounded-md focus:outline-none focus:ring-1 focus:ring-green-500 text-sm"
                                value="{{ old('parentesco', $beneficiario->parentesco) }}">
                        </div>

                        <div>
                            <label class="block font-medium text-gray-700 mb-1">Sexo</label>
                            <div class="flex gap-3">
                                <label class="inline-flex items-center text-sm">
                                    <input type="radio" name="sexo_beneficiario_{{ $beneficiario->id }}"
                                        value="masculino" class="form-radio text-green-500"
                                        {{ $beneficiario->sexo == 'masculino' ? 'checked' : '' }}>
                                    <span class="ml-2">Masculino</span>
                                </label>
                                <label class="inline-flex items-center text-sm">
                                    <input type="radio" name="sexo_beneficiario_{{ $beneficiario->id }}"
                                        value="femenino" class="form-radio text-green-500"
                                        {{ $beneficiario->sexo == 'femenino' ? 'checked' : '' }}>
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


</div>
