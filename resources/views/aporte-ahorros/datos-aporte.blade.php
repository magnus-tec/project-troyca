     <form class="flex items-center" id="formBuscarDniAporte">
         <input type="text" name="buscar" placeholder="Buscar socio" id="dniInput"
             class="border border-gray-300 rounded-lg py-2 px-4 mr-2">
         <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded-lg">
             Buscar
         </button>
     </form>
     <form action="" method="POST" class="space-y-6" id="formAporte">
         @csrf
         <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
             <!-- datos de solicitud -->
             <input type="text" name="cliente" id="cliente" value="{{ isset($id_socio) ? $id_socio : '' }}" hidden>
             <div>
                 <label class="block text-sm font-medium text-gray-700 mb-2">
                     Socio
                 </label>
                 <input type="text" name="datos_cliente" id="datos_cliente"
                     value="{{ isset($nombre_completo) ? $nombre_completo : '' }}"
                     class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-1 focus:ring-green-500"
                     readonly>
             </div>
             <div>
                 <label class="block text-sm font-medium text-gray-700 mb-2">
                     Monto Aporte
                 </label>
                 <input type="number" name="monto" id="monto"
                     class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-1 focus:ring-green-500">
             </div>
             <div>
                 <label class="block text-sm font-medium text-gray-700 mb-2">
                     Total de Ahorros
                 </label>
                 <input type="text" name="total_ahorros" value="{{ isset($total_ahorros) ? $total_ahorros : '' }}"
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
         document.getElementById('formBuscarDniAporte').addEventListener('submit', function(event) {
             event.preventDefault();

             let dni = document.getElementById('dniInput').value;

             if (!dni.trim()) {
                 swal.fire({
                     icon: 'error',
                     title: 'Error',
                     text: 'Por favor, ingresa un DNI válido.',
                 })
             }
             fetch(`/api/buscar-socio/${dni}`)
                 .then(response => response.json())
                 .then(data => {
                     if (data.success) {
                         document.getElementById('datos_cliente').value = data.socio.nombre_completo;
                         document.getElementById('cliente').value = data.socio.id_socio;
                         document.querySelector('input[name="total_ahorros"]').value = data.socio.total_ahorros;
                     } else {
                         document.getElementById('datos_cliente').value = data.message;
                         document.getElementById('cliente').value = '';
                         document.querySelector('input[name="total_ahorros"]').value = 0;
                     }
                 })
                 .catch(error => console.error('Error en la búsqueda:', error));
         });
         $('#formAporte').submit(function(event) {
             event.preventDefault();
             var clienteId = document.querySelector('input[name="cliente"]').value;
             var montoAporte = $(this).find('[name="monto"]').val();

             if (!montoAporte) {
                 Swal.fire({
                     icon: 'error',
                     title: 'Error',
                     text: 'Por favor, ingresa un monto de aporte.',
                 });
                 return;
             }
             if (!clienteId) {
                 Swal.fire({
                     icon: 'error',
                     title: 'Error',
                     text: 'Por favor, escoja un socio registrado.',
                 });
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
                     //  obtenerTotalAporte(clienteId);
                     $('#formAporte [name="monto"]').val("");
                     if (response.success) {
                         Swal.fire({
                             icon: 'success',
                             title: '¡Éxito!',
                             text: 'Aporte registrado exitosamente. ¿Deseas generar el voucher?',

                             showCancelButton: true,
                             cancelButtonText: 'No generar Voucher',
                             showConfirmButton: true,
                             confirmButtonText: 'Generar Voucher',
                             reverseButtons: true,
                             customClass: {
                                 confirmButton: 'bg-green-500 text-white px-4 py-2 m-2 rounded',
                                 cancelButton: 'bg-red-500 text-white px-4 py-2 m-2 rounded',
                             },
                             buttonsStyling: false,

                         }).then((result) => {
                             if (result.isConfirmed) {
                                 window.open('/aporte/generar-voucher-pdf/' + response
                                     .aporteDetalle, '_blank');
                             } else if (result.dismiss === Swal.DismissReason.cancel) {
                                 Swal.fire({
                                     icon: 'info',
                                     title: 'Voucher no generado',
                                     text: 'El voucher no se generará en esta ocasión.',
                                     timer: 2000,
                                     timerProgressBar: true,
                                     showConfirmButton: false,
                                 });
                             }
                         });

                         document.querySelector('input[name="total_ahorros"]').value =
                             response.nuevoTotal;
                     }
                 }
             });
         });
         //  $(document).ready(function() {
         //      var clienteId = $('#cliente').val();
         //      if (clienteId) {
         //          obtenerTotalAporte(clienteId);
         //      }
         //      $('#select_clientes').on('change', function() {
         //          var clienteId = $(this).val();
         //          obtenerTotalAporte(clienteId);
         //      });
         //  });
     </script>
