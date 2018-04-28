var tabla;

$(document).on('click', '.e-producto', function(){
  eliminarProducto($(this).attr('data-id'), $(this));
})

function enviarFormulario(element, id){
  estado =element.value;
  $.ajax({
    method: 'post',
    url: base_url+"producto/modificarEstado/"+id,
    data:{
      estado: estado
    },
    success: function (response) {
        var datos = eval(JSON.parse(response));
        if (datos['estado']) {
          mostrarAlerta('success', 'Exito', datos['mensaje']);
        }else{
          mostrarAlerta('danger', 'Fallo', datos['mensaje']);

        }
    },
    error: function (e) {
        console.log(e);
    }
  });
}

$(document).ready(function(){
  tabla = $("#productos").DataTable({
    language: {
      "decimal": ".", 
      "emptyTable": "No hay información",
      "info": "Mostrando _START_ a _END_ de _TOTAL_ Entradas",
      "infoEmpty": "Mostrando 0 to 0 of 0 Entradas",
      "infoFiltered": "(Filtrado de _MAX_ entradas en total)",
      "infoPostFix": "",
      "thousands": ",",
      "lengthMenu": "Mostrar _MENU_ Entradas",
      "loadingRecords": "Cargando...",
      "processing": "Procesando...",
      "search": "Buscar:",
      "zeroRecords": "No hay coincidencias",
      "paginate": {
          "first": "Primero",
          "last": "Ultimo",
          "next": "Siguiente",
          "previous": "Anterior"
      }
    }
  });
});

/**
 * Cambia el estado de un producto según su identificador
 * @author Nikollai Hernandez G <nikollaihernandez@gmail.com>
 * @param  {[int]} producto Identificador del producto que se desea modificar
 * @return {[type]}          [description]
 */
function eliminarProducto(producto, btn){
  var row_DOM = $(btn).parents('td').parents('tr');
  swal({
      title: '¿Esta seguro?',
      text: 'Desea eliminar el producto',
      type: "warning",
      showCancelButton: !0,
      confirmButtonColor: "#DD6B55",
      confirmButtonText: "Si, Continuar!",
      cancelButtonText: "No, Cancelar!",
      closeOnConfirm: 1
  }).then(function (success) {
      if(success) {
        $.ajax({
      method: 'post',
          url: base_url+"producto/modificarEstado/" + producto,
          data:{
            estado: 0,
          },
          async: false,
          success: function (response) {
              estaciones = eval(JSON.parse(response));
              if (estaciones['estado'] == true) {
                tabla
                .row(row_DOM)
                .remove()
                .draw();

                mostrarAlerta('success', 'Exito!', 'Producto eliminado correctamente');
              }
              else{
                mostrarAlerta('danger', 'Error!', 'Ha ocurrido un error al intentar eliminar el producto');
              }
          },
          error: function (e) {
              console.log(e);
          }
      });
      }
  })
}