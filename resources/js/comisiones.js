$(document).on('change', '#departamento-usuario-form', function(){
	llenarSelectCiudad($(this).val(), '#ciudad');
});

/**
 * [obtenerCiudadesDepartamento description]
 * @author Nikollai Hernandez G <nikollaihernandez@gmail.com>
 * @param  {[type]} id_departamento [description]
 * @return {[type]}                 [description]
 */
function obtenerCiudadesDepartamento(id_departamento){
	var ciudades;
	$.ajax({
		method: 'post',
        url: base_url+"ubicacion/ciudadesPorDepartamento/" + id_departamento,
        data:{
        	
        },
        async: false,
        success: function (response) {
            ciudades = eval(JSON.parse(response))['objeto'];
        },
        error: function (e) {
            console.log(e);
        }
    });

    return ciudades;
}

/**
 * [llenarSelectCiudad description]
 * @author Nikollai Hernandez G <nikollaihernandez@gmail.com>
 * @param  {[int]} departamento    Recibe el id del departamento para consultar sus ciudades
 * @param  {[string]} elemento     Recibe el identificador o clase del elemento select en el cual se cargara el resultado
 * @return {[type]}              [description]
 */
function llenarSelectCiudad(departamento, elemento){
	var ciudades = obtenerCiudadesDepartamento(departamento);
	var ciudades_DOM = '<option value="0">Ciudad</option>';
	if (ciudades.length > 0) {
		for (var i = 0; i < ciudades.length; i++) {
			var ciudad = ciudades[i];

			ciudades_DOM += '<option value="'+ciudad['id_ciudad']+'">'+ciudad['nombre_ciudad']+'</option>';
		}
	}

	$(elemento).html(ciudades_DOM);
}

$(document).on('change', '#ciudad', function(){
	llenarSelectEstacion($(this).val(), '#estacion');
});

/**
 * [obtenerEstacionesCiudad description]
 * @author Nikollai Hernandez G <nikollaihernandez@gmail.com>
 * @param  {[type]} id_ciudad [description]
 * @return {[type]}                 [description]
 */
function obtenerEstacionesCiudad(id_ciudad){
	var estaciones;
	$.ajax({
		method: 'post',
        url: base_url+"estacion/estacionesPorCiudad/" + id_ciudad,
        data:{
        	
        },
        async: false,
        success: function (response) {
            estaciones = eval(JSON.parse(response))['objeto'];
        },
        error: function (e) {
            console.log(e);
        }
    });

    return estaciones;
}

/**
 * [llenarSelectEstacion description]
 * @author Nikollai Hernandez G <nikollaihernandez@gmail.com>
 * @param  {[int]} ciudad    Recibe el id del departamento para consultar sus ciudades
 * @param  {[string]} elemento     Recibe el identificador o clase del elemento select en el cual se cargara el resultado
 * @return {[type]}              [description]
 */
function llenarSelectEstacion(ciudad, elemento){
	var estaciones = obtenerEstacionesCiudad(ciudad);
	var estaciones_DOM = '<option value="0">Estación</option>';
	if (estaciones.length > 0) {
		for (var i = 0; i < estaciones.length; i++) {
			var estacion = estaciones[i];

			estaciones_DOM += '<option value="'+estacion['id_estacion']+'">'+estacion['nombre_estaciones']+'</option>';
		}
	}

	$(elemento).html(estaciones_DOM);
}

function aplicarFiltro(element, tipo){
  var idElement = $(element).val();
  if (idElement != 0) {
	  $.ajax({
	    method: 'post',
	    url: base_url+"comision/filtro/"+tipo+'/'+idElement,
	    data:{},
	    success: function (response) {
	    	console.log(response);
	        var datos = eval(JSON.parse(response));
	        tabla.clear().draw();
	        if (datos['objeto'] != 0) {
	          for (var i = 0; i < datos['objeto'].length; i++) {
	            comision = datos['objeto'][i];
	            var check = '<input type="checkbox"></input>';
	            var opciones = '<a style="margin-right:3px;" title="Ver" href="<?=base_url();?>producto/obtener/" class="btn orange btn-mini" type="button"><i class="fa fa-eye"></i> Detalles</a><a class="btn blue btn-mini" type="button"><i class="fa fa-money"></i> Liquidar</a>';
	            tabla
	            .row
	            .add([check, comision['nombre'], comision['incentivo'], '$'+numberFormat(comision['comision']), opciones])
	            .draw()
	            .node();
	          }

	        }
	    },
	    error: function (e) {
	        console.log(e);
	    }
	  }); 
	}else if(idElement == 0 && tipo == 'Departamento'){
		location.reload();
	} 
}
function validarSelectComisiones(select, valor) {
  if (select == 'departamento-usuario-form' && valor == 0) {
    $('#estacion').html('<option selected value="">Estación</option>');
    $('#ciudad').html('<option selected value="">Ciudad</option>');
    //LLamado a la funcion
  }else if(select == 'ciudad' && valor == 0){
    $('#estacion').html('<option selected value="">Estación</option>');
    //Llamado a la duncion
  }
}