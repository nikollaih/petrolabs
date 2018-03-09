var tabla;
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

function setItemSelect(element,item){
  setTimeout(function(){ 
    $('#'+element).prepend('<option selected value="0">'+item+'</option>'); 
  }, 100);
}

function cargarFiltro(element, tipo){
  var idElement = $(element).val();
  $.ajax({
    method: 'post',
    url: base_url+"venta/filtro/"+tipo+'/'+idElement,
    data:{},
    success: function (response) {
        var datos = eval(JSON.parse(response));
        tabla.clear().draw();
        if (datos['objeto'] != 0) {
          for (var i = 0; i < datos['objeto'].length; i++) {
            venta = datos['objeto'][i];
            imagen = '<img class="foto-producto" src="'+base_url+'uploads/productos/'+venta['foto']+'">';
            tabla
            .row
            .add([imagen, venta['nombre_producto'], venta['cantidad'], numberFormat(venta['total']), numberFormat(venta['comision_total'])])
            .draw()
            .node();
          }

        }
    },
    error: function (e) {
        console.log(e);
    }
  });  
}

function validarSelect(select, valor, element) {
  if (select == 'departamento-usuario-form') {
    $('#islero-usuario-form').html('<option selected value="">Islero</option>');
    $('#estacion-usuario-form').html('<option selected value="">Estación</option>');
    $('#ciudad-usuario-form').html('<option selected value="">Ciudad</option>');
    cargarComisiones(element, 'Departamento');
  }else if(select == 'ciudad-usuario-form' && valor == undefined){
    $('#islero-usuario-form').html('<option selected value="">Islero</option>');
    $('#estacion-usuario-form').html('<option selected value="">Estación</option>');
    cargarComisiones(element, 'Ciudad');
  }else if(select == 'estacion-usuario-form' && valor == undefined){
    $('#islero-usuario-form').html('<option selected value="">Islero</option>');
    cargarComisiones(element, 'Estacion');
  }
}