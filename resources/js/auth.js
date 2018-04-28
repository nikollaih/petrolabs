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
	        	console.log(response);
	            var datos = eval(JSON.parse(response));
	            if (datos['estado']) {
	            	window.location.replace(base_url+"producto");
	            }else{
	            	$('.login-error').show();
	            	setTimeout(function(){
	            		$('.login-error').hide();
	            	}, 3000)
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


function validarFormularioPerfil(validar){
	if (!validar) {
		return true;
	}
	
	var passActual = '12gn34dh'+$('#c-actual').val()+'00li98';
	if ($('#c-actual').val() != '' && passActual == tokenAppAccess) {
		if ($('#c-nueva').val() != '' && $('#c-rnueva').val() != '' && $('#c-nueva').val() == $('#c-rnueva').val()) {
			return true;
		}else{
			mostrarAlerta('warning', 'Advertencia!','Las contraseña nueva no coincide o está vacía.');
			return false;
		}
	}else{
		if ($('#c-nueva').val() != '' || $('#c-rnueva').val() != '') {
			mostrarAlerta('warning', 'Advertencia!','Por favor escriba la contraseña actual');
			return false;
		}else{
			return true;
		}	
	}
}