function validateEmail(email) {
    var re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    return re.test(email);
}
$(document).ready(function(){
	var em = true;
	$('#uemail').keyup(function(){
		var email = $('#uemail').val();
		if(validateEmail(email)){
			$.get(
				'../mvd/checkEmailExists.php',
				{email:email},
				function(response){
					if(response.status == 	"FALSE"){
						$('#sbutton').attr( "disabled", "disabled" );
						$('#emailFormGroup').removeClass('has-success');
						$('#avialable').addClass("glyphicon glyphicon-remove-circle text-danger form-control-feedback");
						$('#EmailErMessage').html('<span class="label label-warning">This Email is already registered </span>');
					}
					else{

						$('#sbutton').removeAttr( "disabled");
						$('#emailFormGroup').addClass('has-success');
						$('#avialable').removeClass();
						$('#EmailErMessage').html('');
						$('#EmailErMessage').html('<span class="label label-success">This Looks Good ! </span>');
						$('#avialable').addClass("glyphicon glyphicon-ok text-success form-control-feedback");
					}
				},
				'json'
				);
		}
		else{
			$('#sbutton').attr( "disabled", "disabled" );
			$('#emailFormGroup').removeClass('has-success');
			$('#avialable').addClass("glyphicon glyphicon-remove-circle text-danger form-control-feedback");
			$('#EmailErMessage').html('<span class="label label-danger">This Email is in bad format</span>');
		}
	});

	// Password Validation
	var ps = false;
	$('#upass').keyup(function(){
		if($('#upass').val().length < 8)
			$('#helpBlock-Password').html('<span class="label label-warning"> atleast 8 in length,adviced to contain digits and special Charecters</span>');
		else{
			$('#helpBlock-Password').html('<span class="label label-success">Looks Fine,Make sure it\'s hard to guess</span>');
			ps = true;
		}
	});
	$('#uconfpass').keyup(function(){
		if($('#uconfpass').val()  !== $('#upass').val())
			$('#helpBlock-confPassword').html('<span class="label label-warning">Not matching with the password you Entered</span>');
		else if(ps === true){
			$('#helpBlock-confPassword').html('<span class="label label-success">Make sure you remember it !</span>');
			if(em === true)
				$('#sbutton').removeAttr('disabled');
		}
	});
});
