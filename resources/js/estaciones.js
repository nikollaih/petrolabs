$(document).on('change', '#ciudad-usuario-form', function(){
	llenarSelectEstacion($(this).val(), '#estacion-usuario-form', $(this).attr('data-estacion-usuario'));
})

$(document).on('click', '#slt-estacion-asesor', function(){
	asignarEstacionAsesor($('#estacion-asesor').val(), $(this).attr('data-asesor'));
})

$(document).on('click', '.eliminar-estacion-asesor', function(){
	var row_DOM = $(this).parents('td').parents('tr');
	var id_estacion = $(this).attr('data-estacion');
	var id_asesor = $(this).attr('data-asesor');
	
	swal({
        title: '¿Esta seguro?',
        text: 'Desea eliminar la estacion',
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
		        url: base_url+"estacion/desasignarEstacionAsesor",
		        data:{
		        	estacion: id_estacion,
		        	asesor: id_asesor
		        },
		        async: false,
		        success: function (response) {
		            estaciones = eval(JSON.parse(response));
		            if (estaciones['estado'] == true) {
			            tabla_estaciones_asesor
				        .row(row_DOM)
				        .remove()
				        .draw();

					    mostrarAlerta('success', 'Exito!', estaciones['mensaje']);
					}
					else{
						mostrarAlerta('danger', 'Error!', estaciones['mensaje']);
					}
		        },
		        error: function (e) {
		            console.log(e);
		        }
		    });
        }
    })
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

/**
 * [asignarEstacionAsesor description]
 * @author Nikollai Hernandez G <nikollaihernandez@gmail.com>
 * @param  {[type]} id_estacion [description]
 * @param  {[type]} id_asesor   [description]
 * @return {[type]}             [description]
 */
function asignarEstacionAsesor(id_estacion, id_asesor){
	$.ajax({
		method: 'post',
        url: base_url+"estacion/asignarEstacionAsesor",
        data:{
        	estacion: id_estacion,
        	asesor: id_asesor
        },
        async: false,
        success: function (response) {
            estaciones = eval(JSON.parse(response));

            if (estaciones['estado'] == true) {
	            var boton = '<a class="btn red btn-mini btn-cicle eliminar-estacion-asesor" data-estacion="'+id_estacion+'" data-asesor="'+id_asesor+'" type="button">' +
	                            '<i class="fa fa-trash"></i>' +
	                        '</a>';
	            tabla_estaciones_asesor
			    .row.add( [ $('#estacion-asesor option:selected').text(), boton ] )
			    .draw()
			    .node();

			    mostrarAlerta('success', 'Exito!', estaciones['mensaje']);
			}
			else{
				mostrarAlerta('danger', 'Error!', estaciones['mensaje']);
			}
        },
        error: function (e) {
            console.log(e);
        }
    });
}