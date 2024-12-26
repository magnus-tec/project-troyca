<form action="{{ route('registro.datos-personales.store') }}" method="POST" class="space-y-6">
    @csrf
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <!-- Apellidos -->
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">
                Apellido Paterno
            </label>
            <input type="text" name="apellido_paterno" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-1 focus:ring-green-500">
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">
                Apellido Materno
            </label>
            <input type="text" name="apellido_materno" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-1 focus:ring-green-500">
        </div>

        <!-- Nombres -->
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">
                Nombres
            </label>
            <input type="text" name="nombres" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-1 focus:ring-green-500">
        </div>

        <!-- DNI -->
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">
                DNI N°
            </label>
            <input type="text" name="dni" maxlength="8" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-1 focus:ring-green-500">
        </div>

        <!-- Fecha de Nacimiento -->
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">
                Fecha de Nacimiento
            </label>
            <input type="date" name="fecha_nacimiento" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-1 focus:ring-green-500">
        </div>

        <!-- Estado Civil -->
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">
                Estado Civil
            </label>
            <select name="estado_civil" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-1 focus:ring-green-500">
                <option value="">Seleccione...</option>
                <option value="soltero">Soltero(a)</option>
                <option value="casado">Casado(a)</option>
                <option value="divorciado">Divorciado(a)</option>
                <option value="viudo">Viudo(a)</option>
                <option value="conviviente">Conviviente</option>
            </select>
        </div>

        <!-- Profesión -->
        <div>
        <label for="profesion_ocupacion" class="block text-sm font-medium text-gray-700 mb-2">
                Profesión u Ocupación
            </label>
            <input type="text" id="profesion_ocupacion" name="profesion_ocupacion" value="{{ old('profesion_ocupacion') }}" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-1 focus:ring-green-500">
        </div>

        <!-- Nacionalidad -->
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">
                Nacionalidad
            </label>
            <input type="text" name="nacionalidad" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-1 focus:ring-green-500">
        </div>

        <!-- Sexo -->
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">
                Sexo
            </label>
            <div class="flex gap-4">
                <label class="inline-flex items-center">
                    <input type="radio" name="sexo" value="masculino" class="form-radio text-green-500">
                    <span class="ml-2">Masculino</span>
                </label>
                <label class="inline-flex items-center">
                    <input type="radio" name="sexo" value="femenino" class="form-radio text-green-500">
                    <span class="ml-2">Femenino</span>
                </label>
            </div>
        </div>
    </div>

    <div class="mt-6 flex justify-end gap-4">
        <button type="button" onclick="history.back()" class="px-4 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-50">
            Cancelar
        </button>
        <button type="submit" class="px-4 py-2 bg-green-500 text-white rounded-md hover:bg-green-600">
            Guardar y Continuar
        </button>
    </div>
</form>