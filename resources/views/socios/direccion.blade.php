<form action="" method="">
    @csrf
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div>
            <label for="departamento" class="block text-sm font-medium text-gray-700 mb-2">
                Departamento
            </label>
            <input type="text" id="departamento" name="departamento"
                value="{{ old('departamento', $socio->direccion->departamento ?? '') }}"
                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-1 focus:ring-green-500">
        </div>

        <div>
            <label for="provincia" class="block text-sm font-medium text-gray-700 mb-2">
                Provincia
            </label>
            <input type="text" id="provincia" name="provincia"
                value="{{ old('provincia', $socio->direccion->provincia ?? '') }}"
                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-1 focus:ring-green-500">
        </div>

        <div>
            <label for="distrito" class="block text-sm font-medium text-gray-700 mb-2">
                Distrito
            </label>
            <input type="text" id="distrito" name="distrito"
                value="{{ old('distrito', $socio->direccion->distrito ?? '') }}"
                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-1 focus:ring-green-500">
        </div>

        <div>
            <label for="tipo_vivienda" class="block text-sm font-medium text-gray-700 mb-2">
                Tipo de Vivienda
            </label>
            <select id="tipo_vivienda" name="tipo_vivienda"
                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-1 focus:ring-green-500">
                <option value="">Seleccione...</option>
                <option value="propia"
                    {{ isset($socio->direccion) && $socio->direccion->tipo_vivienda == 'propia' ? 'selected' : '' }}>
                    Propia
                </option>
                <option value="alquilada"
                    {{ isset($socio->direccion) && $socio->direccion->tipo_vivienda == 'alquilada' ? 'selected' : '' }}>
                    Alquilada</option>
                <option value="familiar"
                    {{ isset($socio->direccion) && $socio->direccion->tipo_vivienda == 'familiar' ? 'selected' : '' }}>
                    Familiar
                </option>
                <option value="otro"
                    {{ isset($socio->direccion) && $socio->direccion->tipo_vivienda == 'otro' ? 'selected' : '' }}>Otro
                </option>
            </select>
        </div>

        <div class="md:col-span-2">
            <label for="direccion" class="block text-sm font-medium text-gray-700 mb-2">
                Dirección
            </label>
            <input type="text" id="direccion" name="direccion"
                value="{{ old('distrito', $socio->direccion->direccion ?? '') }}"
                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-1 focus:ring-green-500">
        </div>

        <div class="md:col-span-2">
            <label for="referencia" class="block text-sm font-medium text-gray-700 mb-2">
                Referencia
            </label>
            <input type="text" id="referencia" name="referencia"
                value="{{ old('referencia', $socio->direccion->referencia ?? '') }}"
                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-1 focus:ring-green-500">
        </div>

        <div>
            <label for="telefono" class="block text-sm font-medium text-gray-700 mb-2">
                Teléfono
            </label>
            <input type="text" id="telefono" name="telefono"
                value="{{ old('telefono', $socio->direccion->telefono ?? '') }}"
                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-1 focus:ring-green-500">
        </div>

        <div>
            <label for="correo" class="block text-sm font-medium text-gray-700 mb-2">
                Correo Electrónico
            </label>
            <input type="email" id="correo" name="correo"
                value="{{ old('correo', $socio->direccion->correo ?? '') }}"
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
