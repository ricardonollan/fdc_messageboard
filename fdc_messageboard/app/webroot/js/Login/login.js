$(document).ready(function(){
   $('#UserLoginForm').on('submit', function(e){
    e.preventDefault();
    var data = $(this).serialize();
    let input = $('#UserLoginForm .required');
    var valid = true;
    $.each(input, function(index,value){
        if($(this).val() == ''){
            $(this).css('border', '1px solid red');
            $('.login_form .customized-alert').html('Please fill out all required field.').addClass('alert-danger');
            valid = false;
        } else {
            $(this).css('border', '1px solid #ced4da');
        }
    });
    if(valid){
        $.ajax({
            type: 'POST',
            // crossDomain: true,
            url: 'login_request',
            data:data,
            dataType: 'json',
            success: function(response) {
                console.log(response.success);
                // Handle successful authentication
                if(response.success){
                    window.location.href = base_url + '/users/profile'; // Replace with the desired redirect URL
                } else {
                    $('.login_form .customized-alert').html(response.message).addClass('alert-danger');
                }
            },
            error: function(xhr, status, error) {
                // Handle authentication error
                console.error('Authentication failed:', error);
                // Display error message or perform other actions as needed
            }
        })
    }
   });
   return false;
})