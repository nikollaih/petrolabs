$(document).on('click', '#loginSubmit', function(){
	login();
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
	        },
	        error: function (e) {
	            console.log(e);
	        }
	    });
	}else{
		alert("No");
	}
}