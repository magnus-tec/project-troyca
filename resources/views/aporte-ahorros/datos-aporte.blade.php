<form action="" method="POST" class="space-y-6" id="formAporte">
    @csrf
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
        <!-- datos de solicitud -->
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">
                Clientes
            </label>
            <select name="clientes" id="select_clientes"
                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-1 focus:ring-green-500">
                @foreach ($socios as $socio)
                    <option value="{{ $socio->id }}">{{ $socio->nombre_completo }}</option>
                @endforeach
            </select>
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">
                Monto Aporte
            </label>
            <input type="text" name="monto" id="monto"
                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-1 focus:ring-green-500">
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">
                Total de Ahorros
            </label>
            <input type="text" name="total_ahorros"
                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-1 focus:ring-green-500"
                disabled>
        </div>
        <div class="mt-6 flex ">
            <button type="button" onclick="history.back()"
                class="px-4 mx-2  border border-gray-300 rounded-md text-gray-700 hover:bg-gray-50">
                Cancelar
            </button>
            <button type="submit" class="px-4  bg-green-500 text-white rounded-md hover:bg-green-600">
                Guardar
            </button>
        </div>

</form>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    function obtenerTotalAporte(clienteId) {
        $.ajax({
            url: "{{ route('obtener-total-aporte', ['id' => 'clienteId']) }}".replace('clienteId',
                clienteId), // Reemplaza 'clienteId' con el valor real
            method: 'GET',
            success: function(response) {
                $('#formAporte [name="total_ahorros"]').val(response.total);
            }
        });
    }
    $('#formAporte').submit(function(event) {
        event.preventDefault();
        var clienteId = $('#select_clientes').val();
        var montoAporte = $(this).find('[name="monto"]').val();

        if (!montoAporte) {
            alert('Por favor, ingresa un monto de aporte.');
            return;
        }
        $.ajax({
            url: "{{ route('aportes.store') }}",
            method: 'POST',
            data: {
                _token: '{{ csrf_token() }}',
                clientes: clienteId,
                monto: montoAporte
            },
            success: function(response) {
                obtenerTotalAporte(clienteId);
                $('#formAporte [name="monto"]').val("");
                if (response.success) {
                    alert('Aporte guardado correctamente');
                }
            }
        });
    });
    $(document).ready(function() {
        var clienteId = $('#select_clientes').val();
        if (clienteId) {
            obtenerTotalAporte(clienteId);
        }

        $('#select_clientes').on('change', function() {
            var clienteId = $(this).val();
            obtenerTotalAporte(clienteId);
        });
    });
</script>
