function showError(field, message){
	if (!message) {
		 $("#" + field).addClass("is-valid").removeClass("is-invalid").siblings(".invalid-feedback").text("");
	}else{
		$("#" + field).addClass("is-invalid").removeClass("is-valid").siblings(".invalid-feedback").text(message);
		$("#" + field).focus(function(){
	      $(this).removeClass("is-invalid");
	      //$(this).siblings(".invalid-feedback");
	    });

	}
}

function removeErrors(form){
	$(form).each(function () {
		$(form).find(":input").removeClass("is-valid is-invalid");
	});
}

function showMessage(type, message) {
	//return '<div class="alert alert-${type} alert-dismissible show fade"> <div class="alert-body"> <button class="close" data-dismiss="alert"> <span>&times;</span> </button> ${message} </div> </div>'

return '<div class="alert alert-${type}" role="alert"> <button type="button" class="btn-close" data-bs-dismiss="alert" aria-hidden="true">×</button><i class="fa fa-check-circle-o me-2" aria-hidden="true"></i> ${message}</div>'

}