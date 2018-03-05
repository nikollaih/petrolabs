$(document).on('change', '#ciudad-usuario-form', function(){
	llenarSelectEstacion($(this).val(), '#estacion-usuario-form', $(this).attr('data-estacion-usuario'));
})

$(document).on('click', '#slt-estacion-asesor', function(){
	asignarEstacionAsesor($('#estacion-asesor').val(), $(this).attr('data-asesor'));
})

$(document).on('click', '.eliminar-estacion', function(){
	var row_DOM = $(this).parents('td').parents('tr');
	estadoEstacion($(this).attr('data-estacion'), 0, row_DOM);
})

$(document).on('change', '.departamento-asesores', function(){
	obtenerAsesoresDepartamento($(this).val(), '.' + $(this).attr('data-asesores'));
})

$(document).on('change', '.lista-estaciones', function(){
	setTimeout(function(){
		var departamento = $('#departamento-usuario-form').val();
		var ciudad = $('#ciudad-usuario-form').val();
		var estaciones = 0;

		if (departamento != '' && ciudad == '') {
			estaciones = obtenerEstacionesDepartamento(departamento);
		}

		if (departamento != '' && ciudad != '') {
			estaciones = obtenerEstacionesCiudad(ciudad);
		}

		cargarListaEstaciones(tabla_estaciones, estaciones);
	}, 300)
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
	if (id_ciudad != '') {
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
	else{
		return 0;
	}
}


/**
 * [obtenerEstacionesDepartamento description]
 * @author Nikollai Hernandez G <nikollaihernandez@gmail.com>
 * @param  {[type]} id_departamento [description]
 * @return {[type]}                 [description]
 */
function obtenerEstacionesDepartamento(id_departamento){
	if (id_departamento != '') {
		var estaciones;
		$.ajax({
			method: 'post',
	        url: base_url+"estacion/estacionesPorDepartamento/" + id_departamento,
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
	else{
		return 0;
	}
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
	var estaciones_DOM = '<option value=""></option>';
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

function obtenerAsesoresDepartamento(departamento, elemento, selected = 0){
	if (departamento.length > 0 || departamento != '') {
		$.ajax({
			method: 'post',
		    url: base_url+"usuario/usuariosPorDepartamento",
		    data:{
		    	id_departamento: departamento,
		    	id_rol: 2
		    },
		    async: false,
		    success: function (response) {
		        asesores = eval(JSON.parse(response));
		        if (asesores['objeto'] != 0) {
		            cargarAsesoresDepartamento(asesores['objeto'], elemento, selected);
				}
				else{
					cargarAsesoresDepartamento(0, elemento, 0);
					mostrarAlerta('danger', 'Error!', 'No se han encontrado asesores para el departamento');
				}
		    },
		    error: function (e) {
		        console.log(e);
		    }
		});
	}
}

/**
 * [cargarAsesoresDepartamento description]
 * @author Nikollai Hernandez G <nikollaihernandez@gmail.com>
 * @param  {[type]} asesores [description]
 * @param  {[type]} elemento     [description]
 * @return {[type]}              [description]
 */
function cargarAsesoresDepartamento(asesores, elemento, selected){
	var asesores_DOM = '<option value="">Asesor</option>';
	if (asesores != 0) {
		for (var i = 0; i < asesores.length; i++) {
			asesor = asesores[i];
			if (selected == asesor['id_usuario']) {
				var selected = 'selected';
			}
			else{
				var selected = '';
			}
			asesores_DOM += '<option '+selected+' value="'+asesor['id_usuario']+'">'+asesor['nombre']+' '+asesor['apellidos']+'</option>';
		}
	}

	$(elemento).html(asesores_DOM);
}

/**
 * [cargarListaEstaciones description]
 * @author Nikollai Hernandez G <nikollaihernandez@gmail.com>
 * @param  {[type]} table      [description]
 * @param  {[type]} estaciones [description]
 * @return {[type]}            [description]
 */
function cargarListaEstaciones(table, estaciones){
	table.clear().draw();

	if (estaciones != 0) {
		for (var i = 0; i < estaciones.length; i++) {
			var estacion = estaciones[i];

			if (estacion['usuario'] == '' || estacion['usuario'] == null) {
				var nombre_asesor = '- SIN DEFINIR -';
			}
			else{
				var nombre_asesor = estacion['nombre'] + ' ' + estacion['apellidos'];
			}

			var opciones = '<a title="Editar" href="'+base_url+'estacion/obtener/'+estacion['id_estacion']+'/'+estacion['nombre_estaciones']+'" class="btn orange btn-mini" type="button">'+
                              '<i class="fa fa-pencil"></i>'+
                            '</a>'+
                            '<a data-estacion="'+estacion['id_estacion']+'" class="btn red btn-mini btn-cicle eliminar-estacion" type="button">'+
                              '<i class="fa fa-trash"></i>'+
                            '</a>';

			table
			.row
			.add([estacion['nombre_estaciones'], nombre_asesor, estacion['nombre_departamento'], estacion['nombre_ciudad'], opciones])
			.draw()
			.node();
		}
	}
}

function estadoEstacion(id_estacion, idEstado, row_DOM = ''){
	var data = {estado : idEstado};

	swal({
        title: '¿Esta seguro?',
        text: 'Desea cambiar el estado de la estacion',
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
		        url: base_url+"estacion/eliminarEstacion",
		        data:{
		        	estacion: id_estacion,
		        	info: data
		        },
		        async: false,
		        success: function (response) {
		            estaciones = eval(JSON.parse(response));
		            if (estaciones['estado'] == true) {
			            tabla_estaciones
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
}