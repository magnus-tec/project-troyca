<form action="" method="">
    @csrf
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div class="md:col-span-2">
            <label for="apellidos_nombres" class="block text-sm font-medium text-gray-700 mb-2">
                Apellidos y Nombres
            </label>
            <input type="text" id="apellidos_nombres_conyuge" name="apellidos_nombres"
                value="{{ old('apellidos_nombres', $socio->conyuge->apellidos_nombres ?? '') }}"
                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-1 focus:ring-green-500">
        </div>

        <div>
            <label for="dni" class="block text-sm font-medium text-gray-700 mb-2">
                DNI N°
            </label>
            <input type="text" id="dni_conyuge" name="dni_conyuge"
                value="{{ old('dni', $socio->conyuge->dni ?? '') }}" maxlength="8" required
                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-1 focus:ring-green-500">
        </div>

        <div>
            <label for="fecha_nacimiento" class="block text-sm font-medium text-gray-700 mb-2">
                Fecha de Nacimiento
            </label>
            <input type="date" id="fecha_nacimiento_conyuge" name="fecha_nacimiento"
                value="{{ old('fecha_nacimiento', isset($socio->conyuge->fecha_nacimiento) ? \Carbon\Carbon::parse($socio->conyuge->fecha_nacimiento)->format('Y-m-d') : '') }}"
                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-1 focus:ring-green-500">
        </div>

        <div>
            <label for="celular" class="block text-sm font-medium text-gray-700 mb-2">
                Celular
            </label>
            <input type="tel" id="celular_conyuge" name="celular"
                value="{{ old('celular', $socio->conyuge->celular ?? '') }}"
                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-1 focus:ring-green-500">
        </div>

        <div>
            <label for="ocupacion" class="block text-sm font-medium text-gray-700 mb-2">
                Ocupación
            </label>
            <input type="text" id="ocupacion_conyuge" name="ocupacion"
                value="{{ old('ocupacion', $socio->conyuge->ocupacion ?? '') }}"
                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-1 focus:ring-green-500">
        </div>

        <div class="md:col-span-2">
            <label for="direccion" class="block text-sm font-medium text-gray-700 mb-2">
                Dirección
            </label>
            <input type="text" id="direccion_conyuge" name="direccion"
                value="{{ old('direccion', $socio->conyuge->direccion ?? '') }}"
                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-1 focus:ring-green-500">
        </div>
    </div>
</form>
