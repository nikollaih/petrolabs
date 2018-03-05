var config = {token : 'P3TR0L4B5-T'}
$(document).on('click', '#loginSubmit', function(){
	login();
});

$(document).on('click', '#forgotSubmit', function(){
	forgot();
});

function login(){
	var email = $('#email').val();
	var password = $('#password').val();
	if (email.trim().length > 0 && password.trim().length > 0) {
		$.ajax({
			method: 'post',
	        url: base_url+"auth/login",
	        data:{
	        	correo: email,
	        	clave: password
	        },
	        success: function (response) {
	            var datos = eval(JSON.parse(response));
	            if (datos['estado']) {
	            	window.location.replace(base_url+"producto");
	            }else{
	            	alert('No se pudo ingresar');
	            }
	        },
	        error: function (e) {
	            console.log(e);
	        }
	    });
	}
}

function forgot(){
	var email = $('#email').val();
	if (email.trim().length > 0) {
		$.ajax({
			method: 'post',
	        url: base_url+"auth/recuperarContrasenia",
	        data:{
	        	correo: email,
	        	token_app: config['token']
	        },
	        success: function (response) {
	        	console.log(response);
	            var datos = eval(JSON.parse(response));
	            if (datos['estado']) {
	            	$('.alert-success').html('<strong>Exito!</strong> ' + datos['mensaje']);
	            	$('.alert-success').show();
	            	setTimeout(function(){
	            		$('.alert-success').hide();
	            	}, 5000);
	            	alert('Se ha enviado un email, revisa tu bandeja de entrada');
	            }else{
	            	$('.alert-danger').html('<strong>Error!</strong> ' + datos['mensaje']);
	            	$('.alert-danger').show();
	            	setTimeout(function(){
	            		$('.alert-danger').hide();
	            	}, 5000);
	            }
	        },
	        error: function (e) {
	            console.log(e);
	        }
	    });
	}
	else{
		$('.alert-danger').html('<strong>Error!</strong> Por favor escriba un correo electronico válido');
    	$('.alert-danger').show();
    	setTimeout(function(){
    		$('.alert-danger').hide();
    	}, 5000);
	}
}