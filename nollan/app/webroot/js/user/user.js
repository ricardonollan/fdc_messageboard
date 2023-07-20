$(document).ready(function () {
    $("#datepicker").datepicker();
    $('#image-upload').change(function () {
        var file = this.files[0];
        var fileExtension = file.name.split('.').pop().toLowerCase();
        var allowedExtensions = ['jpg', 'gif', 'png'];

        if (allowedExtensions.indexOf(fileExtension) === -1) {
            $('#edit_profile_container .validation-errors').addClass('bg-danger');
            $('#edit_profile_container .validation-errors .customized-alert').html(`<b>Only JPG, GIF, and PNG files are allowed.</b>`);
            return;
        } else {
            $('#edit_profile_container .validation-errors').removeClass('bg-danger');
            $('#edit_profile_container .validation-errors .customized-alert').html(``);
        }

        var reader = new FileReader();
        reader.onload = function (e) {
            $('#edit_profile_container .profile_img').attr('src', e.target.result);
        };
        reader.readAsDataURL(file);
    });

    $(document).on('submit', '#edit_form', function (e) {
        e.preventDefault();
        var formData = new FormData($(this)[0]);

        var file = $('#image-upload')[0].files[0];
        if(file){
            var fileExtension = file.name.split('.').pop().toLowerCase();
            var allowedExtensions = ['jpg', 'gif', 'png'];
            if (allowedExtensions.indexOf(fileExtension) === -1) {
                return false;
            }
        }

        let input = $('#edit_form .edit_input');
        var valid = true;
        $.each(input, function (index, val) {
            if ($(this).val() == '') {
                $(this).css('border', '1px solid red');
                valid = false;
            } else {
                $(this).css('border', '1px solid #dee2e6');
            }
        });
        if (!valid) {
            $('#edit_profile_container .validation-errors').addClass('bg-danger');
            $('#edit_profile_container .validation-errors .customized-alert').html(`Fill out all required fields.`);
        } else {
            $('#edit_profile_container .validation-errors').removeClass('bg-danger');
            $('#edit_profile_container .validation-errors .customized-alert').html(``);
            $.ajax({
                url: 'updateProfile', // Replace with your server-side file upload endpoint
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                dataType: 'json',
                success: function (response) {
                    if (response.success) {
                        window.location.href = base_url + '/users/profile';
                    } else {
                        let str = '';
                        if (typeof response.message == 'array') {
                            $.each(response.message, function (index, message) {
                                str += `<p>` + message + `</p>`;
                            });
                        } else {
                            str += `<p>` + response.message + `</p>`;
                        }


                        $('#edit_profile_container .validation-errors').addClass('bg-danger');
                        $('#edit_profile_container .validation-errors .customized-alert').html(str);
                    }
                },
                error: function (xhr, status, error) {
                    // Handle any errors that occur during the AJAX request
                    console.error(error);
                }
            });
        }
    });
}) 