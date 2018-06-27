$(document).on('change', '.item-filtro-factura', function(){
	filtro($('#asesor-factura').val(), $('#fecha_inicial').val(), $('#fecha_fin').val());
});

$(document).on('click', '.incentivo-header', function(){
	filtroEtiquetas($(this).attr('data-tipo'));
});

var incentivo = 0;


function filtroEtiquetas(incentivo_tmp){
	if (incentivo != 0 && incentivo_tmp == incentivo) {
		$('.content-factura').show();
		incentivo = 0;
	}
	else{
		$('.content-factura').hide();
		$('.content-factura.incentivo-t-'+incentivo_tmp).show();
		incentivo = incentivo_tmp;
	}
}

/**
 * [filtro description]
 * @author Nikollai Hernandez G <nikollaihernandez@gmail.com>
 * @param  {[type]} id_asesor    [description]
 * @param  {[type]} fecha_inicio [description]
 * @param  {[type]} fecha_fin    [description]
 * @return {[type]}              [description]
 */
function filtro(id_asesor, fecha_inicio, fecha_fin){
	$.ajax({
    method: 'post',
    url: base_url+"pdf/filtroFacturas",
    data:{
    	asesor: id_asesor,
    	fecha_inicial: fecha_inicio,
    	fecha_final: fecha_fin,
    },
    success: function (response) {
        console.log(response);
        var r = eval('(' + response + ')');
        cargarFacturas(r['objeto']);
    },
    error: function (e) {
        console.log(e);
    }
  });  
}

/**
 * [cargarFacturas description]
 * @author Nikollai Hernandez G <nikollaihernandez@gmail.com>
 * @param  {[type]} facturas [description]
 * @return {[type]}          [description]
 */
function cargarFacturas(facturas){
	if (facturas.length > 0) {
		var facturas_DOM = '';
		for (var i = 0; i < facturas.length; i++) {
			var f = facturas[i];

			facturas_DOM += '<div class="col-md-3 col-sm-6 content-factura incentivo-t-'+f['incentivo']+'">' +
	                            '<article id="'+f['id_factura']+'" class="item-factura">' +
	                              '<label class="etiqueta incentivo-'+f['incentivo']+'"></label>'+
	                              '<div class="content-img">'+
	                               '<a target="blank" href="'+base_url+'pdf/factura/'+f['id_factura']+'/'+f['nombre']+' '+f['apellidos']+'">'+
	                                  '<img src="'+base_url+'resources/images/pdf.png">'+
	                                '</a>'+
	                              '</div>'+
	                              '<div class="content-bottom">'+
	                                '<p><i class="fa fa-user"></i> '+f['nombre']+' '+f['apellidos']+'</p>'+
	                                '<p><i class="fa fa-calendar"></i>'+f['fecha_visual']+'</p>'+
	                              '</div>'+
	                            '</article>'+
	                          '</div>';

		}

		$('#facturas').html(facturas_DOM);
	}
	else{
		$('#facturas').html('<p style="padding: 11px;">No se han encontrado facturas</p>');
	}
}