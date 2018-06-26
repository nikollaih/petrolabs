
var comisionesLiquidadas;
var filtroComision;
var filtroAplicado;

$(document).on('change', '#departamento-usuario-form', function(){
	llenarSelectCiudad($(this).val(), '#ciudad');
});
$(document).on('change', '#departamento-liquidada', function(){
	llenarSelectCiudad($(this).val(), '#ciudad-liquidada');
});
$(document).on('change', '#asesor', function(){
	llenarSelectDepartamento($(this).val(), '#departamento-usuario-form');
});
$(document).on('change', '#asesor-liquidado', function(){
	llenarSelectDepartamento($(this).val(), '#departamento-liquidada');
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
 * [obtenerDepartamentosAsesor description]
 * @author Nikollai Hernandez G <nikollaihernandez@gmail.com>
 * @param  {[type]} id_asesor [description]
 * @return {[type]}           [description]
 */
function obtenerDepartamentosAsesor(id_asesor){
	var dptos;
	$.ajax({
		method: 'post',
        url: base_url+"ubicacion/departamentosAsesor/" + id_asesor,
        data:{
        	
        },
        async: false,
        success: function (response) {
            dptos = eval(JSON.parse(response))['objeto'];
        },
        error: function (e) {
            console.log(e);
        }
    });

    return dptos;
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

/**
 * [llenarSelectDepartamento description]
 * @author Nikollai Hernandez G <nikollaihernandez@gmail.com>
 * @param  {[type]} asesor   [description]
 * @param  {[type]} elemento [description]
 * @return {[type]}          [description]
 */
function llenarSelectDepartamento(asesor, elemento){
	var dptos = obtenerDepartamentosAsesor(asesor);
	var dptos_DOM = '<option value="0">Departamento</option>';
	if (dptos.length > 0) {
		for (var i = 0; i < dptos.length; i++) {
			var dpto = dptos[i];

			dptos_DOM += '<option value="'+dpto['id_departamento']+'">'+dpto['nombre_departamento']+'</option>';
		}
	}

	$(elemento).html(dptos_DOM);
}

$(document).on('change', '#ciudad', function(){
	llenarSelectEstacion($(this).val(), '#estacion');
});
$(document).on('change', '#ciudad-liquidada', function(){
	llenarSelectEstacion($(this).val(), '#estacion-liquidada');
});

$(document).on('click', '#comision_liq_export', function(){
  exportarFiltroComisionesLiquidadas();
})
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

function liquidarComisiones(incentivo, tipo, valor, elemento){
	$.ajax({
		method: 'post',
        url: base_url+"venta/liquidar/" + incentivo+'/'+tipo+'/'+valor,
        data:{},
        async: false,
        success: function (response) {
        	respuesta = eval(JSON.parse(response));
        	if (respuesta['estado']) {
        		var ventas = respuesta['objeto'];
        		swal('Comisiones liquidadas', 'Se liquidaron '+ventas.length+' venta(s).', 'success');
        		filaEliminar = $(elemento).parent('td').parent('tr');
        		tabla.row(filaEliminar).remove().draw();
        	}else{
        		swal('Error!', 'No se obtuvo ventas que liquidar', 'error');
        	}
        },
        error: function (e) {
            console.log(e);
        }
    });
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

function aplicarFiltro(element, tipo, estado){
	var infoEstado = 0;
	if (!estado) {
		infoEstado = 1;
	}
	var tipoLiquidar = 'Ciudad';
	if (tipo=='Ciudad') {
		tipoLiquidar = 'Estacion';
	}else if (tipo=='Estacion') {
		tipoLiquidar='Islero';
	}
	else if (tipo=='Asesor') {
		tipoLiquidar='Departamento';
	}
	var fechaInicial = $('#fecha_inicial').val();
	if (fechaInicial == null || fechaInicial == '') {
		fechaInicial = new Date(1901,01,01);
	}
	var fechaFin = $('#fecha_fin').val();
	if (fechaFin == null || fechaFin == '') {
		fechaFin = new Date();
	}
  	var idElement = $('#'+element).val();

  	if (idElement != 0) {
	  	$.ajax({
		    method: 'post',
		    url: base_url+"comision/filtro/"+tipo+'/'+idElement+'/'+infoEstado,
		    data:{
		    	inicio: fechaInicial,
		    	fin: fechaFin
		    },
		    success: function (response) {
		    	console.log(response);
		        var datos = eval(JSON.parse(response));
		        comisionesLiquidadas = datos['objeto'];

		        filtroComision = tipo;
		        filtroAplicado = $('#'+element+' option:selected').text();

		        tabla.clear().draw();
		        if (datos['objeto'] != 0) {
		          for (var i = 0; i < datos['objeto'].length; i++) {
		            comision = datos['objeto'][i]; 
		            if (!estado) {
		            	var check = '<input type="checkbox"></input>';
		            }
		            else{
		            	var check = i + 1;
		            }
		            var porcentaje = (comision['comision']*2)/100;
		            /*<a style="margin-right:3px;" title="Ver" href="<?=base_url();?>producto/obtener/" class="btn orange btn-mini" type="button"><i class="fa fa-eye"></i> Detalles</a>*/
		            var opciones = '<a class="btn blue btn-mini" type="button" onclick="liquidarComisiones('+comision['id_incentivo']+', `'+tipoLiquidar+'`, '+comision['id']+',this);"><i class="fa fa-money"></i> Liquidar</a>';
		            tabla
		            .row
		            .add([check, comision['nombre'], comision['incentivo'], '$'+numberFormat(comision['comision']), '$'+numberFormat(porcentaje,2), opciones])
		            .draw()
		            .node();
		          }

		        }
		    },
		    error: function (e) {
		        console.log(e);
		    }
	  	}); 
	}else if(idElement == 0 && tipo == 'Asesor'){
		location.reload();
	}
}

function validarSelectComisiones(select, valor) {
  if (select == 'departamento-usuario-form' && valor == 0) {
    $('#estacion').html('<option selected value="0">Estación</option>');
    $('#ciudad').html('<option selected value="">Ciudad</option>');
    //LLamado a la funcion
    aplicarFiltro('asesor', 'Asesor', 0);
  }else if(select == 'ciudad' && valor == 0){
    $('#estacion').html('<option selected value="0">Estación</option>');
    //Llamado a la duncion
    aplicarFiltro('departamento-usuario-form', 'Departamento', 0);
  }else if(select == 'estacion' && valor == 0){
    //Llamado a la duncion
    aplicarFiltro('ciudad', 'Ciudad', 0);
  }else if(select == 'asesor' && valor == 0){
    //Llamado a la duncion
    location.reload();
  }
}

function validarSelectComisionesLiquidadas(select, valor) {
	if (select == 'asesor-liquidado' && valor == 0) {
		$('#departamento-liquidada').html('<option selected value="0">Departamento</option>');
		$('#estacion-liquidada').html('<option selected value="0">Estación</option>');
		$('#ciudad-liquidada').html('<option selected value="0">Ciudad</option>');
		//LLamado a la funcion
		location.reload();
	}else if (select == 'departamento-liquidada' && valor == 0) {
		$('#estacion-liquidada').html('<option selected value="0">Estación</option>');
		$('#ciudad-liquidada').html('<option selected value="0">Ciudad</option>');
		//LLamado a la funcion
		aplicarFiltro('asesor-liquidado', 'Asesor',1);
	}else if(select == 'ciudad-liquidada' && valor == 0){
		$('#estacion-liquidada').html('<option selected value="0">Estación</option>');
		//Llamado a la funcion
		aplicarFiltro('departamento-liquidada', 'Departamento',1);
	}else if(select == 'estacion-liquidada' && valor == 0){
		//Llamado a la funcion
		aplicarFiltro('ciudad-liquidada', 'Ciudad',1);
	}
}
$('#selectAll').click(function(e){
    var table= $(e.target).closest('table');
    $('tr td input:checkbox',table).prop('checked',this.checked);
});

function exportarFiltroComisionesLiquidadas(){
  $('#comisionesArray').val(JSON.stringify(comisionesLiquidadas));
  $('#tipoFiltro').val(filtroComision);
  $('#filtroNombre').val(filtroAplicado);

  $('#formExportarComisiones').submit();
}
