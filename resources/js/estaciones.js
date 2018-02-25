$(document).on('change', '#ciudad-usuario-form', function(){
	llenarSelectEstacion($(this).val(), '#estacion-usuario-form', $(this).attr('data-estacion-usuario'));
})

/**
 * [obtenerCiudadesDepartamento description]
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
 * [llenarSelectCiudad description]
 * @author Nikollai Hernandez G <nikollaihernandez@gmail.com>
 * @param  {[int]} departamento    Recibe el id del departamento para consultar sus ciudades
 * @param  {[string]} elemento     Recibe el identificador o clase del elemento select en el cual se cargara el resultado
 * @param  {Number} activo         Recibe el identificador que será seleccionado como activo en el select
 * @return {[type]}              [description]
 */
function llenarSelectEstacion(ciudad, elemento, activo = 0){
	var estaciones = obtenerEstacionesCiudad(ciudad);
	var estaciones_DOM = '';
	if (estaciones.length > 0) {
		for (var i = 0; i < estaciones.length; i++) {
			var estacion = estaciones[i];

			if (activo == estacion['id_estacion']) {
				var estado = 'selected';
			}
			else{
				var estado = '';
			}

			estaciones_DOM += '<option '+estado+' value="'+estacion['id_estacion']+'">'+estacion['nombre_estaciones']+'</option>';
		}
	}

	$(elemento).html(estaciones_DOM);
}