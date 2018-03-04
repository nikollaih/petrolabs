$(document).on('change', '#departamento-usuario-form', function(){
	llenarSelectCiudad($(this).val(), '#ciudad-usuario-form', $(this).attr('data-ciudad-usuario'));
})

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
 * @param  {Number} activo         Recibe el identificador que será seleccionado como activo en el select
 * @return {[type]}              [description]
 */
function llenarSelectCiudad(departamento, elemento, activo = 0){
	var ciudades = obtenerCiudadesDepartamento(departamento);
	var ciudades_DOM = '<option value="">Ciudad</option>';
	if (ciudades.length > 0) {
		for (var i = 0; i < ciudades.length; i++) {
			var ciudad = ciudades[i];

			if (activo == ciudad['id_ciudad']) {
				var estado = 'selected';
			}
			else{
				var estado = '';
			}

			ciudades_DOM += '<option '+estado+' value="'+ciudad['id_ciudad']+'">'+ciudad['nombre_ciudad']+'</option>';
		}
	}

	$(elemento).html(ciudades_DOM);
}