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

function showErtttror(field, message) {
    if (!message) {
        $("#" + field).addClass("is-valid").removeClass("is-invalid").siblings(".invalid-feedback").text("");
    } else {
        $("#" + field).addClass("is-invalid").removeClass("is-valid").siblings(".invalid-feedback").text(message);
        $("#" + field).focus(function () {
            $(this).removeClass("is-invalid");
        });
        // Add a custom class to the error field for easy identification
        $("#" + field).addClass("has-error");
    }
}

function scrollToFttttirstError() {
    const firstErrorField = $("#loan_form .has-error:first");
    if (firstErrorField.length) {
        $('html, body').animate({
            scrollTop: firstErrorField.offset().top - 100 // You can adjust the offset as needed
        }, 500);
        firstErrorField.focus();
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

function showAlert(response) {
	iziToast.success({
                    message: response,
                    position: 'topRight' 
                });
}

function previewImage(field, preview){
	$("#" + field).change(function(e) {
      const file = e.target.files[0];
      let url = window.URL.createObjectURL(file);
      $("#" + preview).attr('src', url);
      
  });
}

 function scrollToErrmor(field) {
    var firstError = $("#" + field);
    var formGroup = firstError.closest('.form-group');
    var formGroupOffset = formGroup.offset().top;
    var firstErrorOffset = firstError.offset().top;
    var scrollOffset = firstErrorOffset - formGroupOffset - formGroup.scrollTop() - 20; // Adjust this value if needed

    formGroup.animate({
      scrollTop: scrollOffset
    }, 500);
  }

function scrollToError(field) {
    var firstError = $("#" + field);
    var topOffset = 500; // Adjust this value to fine-tune the scroll position

    $('html, body').animate(
      {
        scrollTop: firstError.offset().top - firstError.closest("#" + field).offset().top - topOffset
      },
       500
    );
  }