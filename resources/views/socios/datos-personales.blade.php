<form action="" method="" class="">
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <!-- Apellidos -->
        <div>
            <input type="text" name="id" value="{{ isset($socio) ? $socio->id : '' }}" class="hidden">
            <label class="block text-sm font-medium text-gray-700 mb-2">
                Apellido Paterno
            </label>
            <input type="text" name="apellido_paterno" id="apellido_paterno_personal"
                value="{{ old('apellido_paterno', $socio->datosPersonales->apellido_paterno ?? '') }}"
                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-1 focus:ring-green-500">
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">
                Apellido Materno
            </label>
            <input type="text" name="apellido_materno" id="apellido_materno_personal"
                value="{{ old('apellido_materno', $socio->datosPersonales->apellido_materno ?? '') }}"
                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-1 focus:ring-green-500">
        </div>

        <!-- Nombres -->
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">
                Nombres
            </label>
            <input type="text" name="nombres" id="nombres_personal"
                value="{{ old('nombres', $socio->datosPersonales->nombres ?? '') }}"
                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-1 focus:ring-green-500">
        </div>

        <!-- DNI -->
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">
                DNI N°
            </label>
            <input type="text" name="dni" maxlength="8" id="dni_personal"
                value="{{ old('dni', $socio->datosPersonales->dni ?? '') }}"
                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-1 focus:ring-green-500">
        </div>

        <!-- Fecha de Nacimiento -->
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">
                Fecha de Nacimiento
            </label>
            <input type="date" name="fecha_nacimiento" id="fecha_nacimiento_personal"
                value="{{ old('fecha_nacimiento', isset($socio->datosPersonales->fecha_nacimiento) ? \Carbon\Carbon::parse($socio->datosPersonales->fecha_nacimiento)->format('Y-m-d') : '') }}"
                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-1 focus:ring-green-500">

        </div>

        <!-- Estado Civil -->
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">
                Estado Civil
            </label>
            <select name="estado_civil" id="estado_civil_personal"
                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-1 focus:ring-green-500">
                <option value="">Seleccione...</option>
                <option value="soltero" {{ $socio->datosPersonales->estado_civil == 'soltero' ? 'selected' : '' }}>
                    Soltero(a)</option>
                <option value="casado" {{ $socio->datosPersonales->estado_civil == 'casado' ? 'selected' : '' }}>
                    Casado(a)</option>
                <option value="divorciado"
                    {{ $socio->datosPersonales->estado_civil == 'divorciado' ? 'selected' : '' }}>Divorciado(a)</option>
                <option value="viudo" {{ $socio->datosPersonales->estado_civil == 'viudo' ? 'selected' : '' }}>Viudo(a)
                </option>
                <option value="conviviente"
                    {{ $socio->datosPersonales->estado_civil == 'conviviente' ? 'selected' : '' }}>Conviviente</option>
            </select>
        </div>

        <!-- Profesión -->
        <div>
            <label for="profesion_ocupacion" class="block text-sm font-medium text-gray-700 mb-2">
                Profesión u Ocupación
            </label>
            <input type="text" name="profesion_ocupacion" id="profesion_ocupacion_personal"
                value="{{ old('ocupacion', $socio->datosPersonales->profesion_ocupacion ?? '') }}"
                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-1 focus:ring-green-500">
        </div>

        <!-- Nacionalidad -->
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">
                Nacionalidad
            </label>
            <input type="text" name="nacionalidad" id="nacionalidad_personal"
                value="{{ old('nacionalidad', $socio->datosPersonales->nacionalidad ?? '') }}"
                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-1 focus:ring-green-500">
        </div>

        <!-- Sexo -->
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">
                Sexo
            </label>
            <div class="flex gap-4">
                <label class="inline-flex items-center">
                    <input type="radio" name="sexo_personal" value="masculino" class="form-radio text-green-500"
                        {{ isset($socio->datosPersonales) && $socio->datosPersonales->sexo == 'masculino' ? 'checked' : '' }}>
                    <span class="ml-2">Masculino</span>
                </label>
                <label class="inline-flex items-center">
                    <input type="radio" name="sexo_personal" value="femenino" class="form-radio text-green-500"
                        {{ isset($socio->datosPersonales) && $socio->datosPersonales->sexo == 'femenino' ? 'checked' : '' }}>
                    <span class="ml-2">Femenino</span>
                </label>
            </div>
        </div>
    </div>

    {{-- <div class="mt-6 flex justify-end gap-4">
        <button type="button" onclick="history.back()"
            class="px-4 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-50">
            Cancelar
        </button>
        <button type="submit" class="px-4 py-2 bg-green-500 text-white rounded-md hover:bg-green-600">
            Continuar
        </button>
    </div> --}}
</form>
