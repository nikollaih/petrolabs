$(document).on('change', '#estacion-usuario-form', function(){
	llenarSelectIsleros($(this).val(), '#islero-usuario-form', $(this).attr('data-islero'));
})

/**
 * [obtenerCiudadesDepartamento description]
 * @author German Donoso <germanedt@gmail.com>
 * @param  {[type]} id_estacion [description]
 * @return {[type]}                 [description]
 */
function obtenerIslerosEstacion(id_estacion){
	var isleros;
	$.ajax({
		method: 'post',
        url: base_url+"usuario/islerosPorEstacion/" + id_estacion,
        data:{
        	
        },
        async: false,
        success: function (response) {
            isleros = eval(JSON.parse(response))['objeto'];
        },
        error: function (e) {
            console.log(e);
        }
    });

    return isleros;
}

/**
 * [llenarSelectCiudad description]
 * @author German Donoso <germanedt@gmail.com>
 * @param  {[int]} estacion 	   Recibe el id de la estación para consultar sus isleros
 * @param  {[string]} elemento     Recibe el identificador o clase del elemento select en el cual se cargara el resultado
 * @param  {Number} activo         Recibe el identificador que será seleccionado como activo en el select
 * @return {[type]}              [description]
 */
function llenarSelectIsleros(estacion, elemento, activo = 0){
	var isleros = obtenerIslerosEstacion(estacion);
	var isleros_DOM = '';
	if (isleros.length > 0) {
		for (var i = 0; i < isleros.length; i++) {
			var islero = isleros[i];

			if (activo == islero['id_islero']) {
				var estado = 'selected';
			}
			else{
				var estado = '';
			}

			isleros_DOM += '<option '+estado+' value="'+islero['id_islero']+'">'+islero['nombre']+'</option>';
		}
	}

	$(elemento).html(isleros_DOM);
}