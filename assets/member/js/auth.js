//login
$(function() {
      $("#show-token").hide();
      $("#form_login").submit(function(e) {
        e.preventDefault();
        $("#btn_login").html('<div class="spinner-border spinner-border-md" role="status"> <span class="visually-hidden">Loading...</span> </div>');
        $("#btn_login").prop("disabled", true);
        $.ajax({
          url:'{{ route('merchant.login.submit') }}',
          method: 'post',
          data: $(this).serialize(),
          dataType: 'json',
          success: function(response){
            if(response.status == 400){
              $.each(response.message, function (key, value) {
                showError(key, value);
              });
              $("#btn_login").html('Login');
              $("#btn_login").prop("disabled", false);
            } else if(response.status == 401){
              setTimeout(function(){
                window.location.href = response.redirect;
              }, 1000);
            } else if(response.status == 402){
              setTimeout(function(){
                $("#show-token").show();
              }, 1000);
            } else if(response.status == 200){
              $("#show_success_alert").html(showMessage('success', response.message));
              $("#form_login")[0].reset();
              removeErrors("#form_login");
              $("#btn_login").html('Login');
              $("#btn_login").prop("disabled", false);
              setTimeout(function(){
                window.location.href = response.redirect;
              }, 1000);

            }
          }
        });
      });
    });