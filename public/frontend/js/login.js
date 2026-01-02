$(document).on('click', '.modal-login', function() {
    $('#login_modal').modal('show');
    $('.product-modal').modal('hide');
});

$('#modal_login_phone').keyup(function(event) {
    if($(this).val() != ''){
        $('#modal_login_phone_error').html('');
    }
});

$('#modal_login_password').keyup(function(event) {
    if($(this).val() != ''){
        $('#modal_login_password_error').html('');
    }
});


$(document).on('submit','#modal_login_form',function(e){
    event.preventDefault();

    $.ajax({
        url: $(this).prop('action'),
        method: "POST",
        data: new FormData(this),
        contentType: false,
        cache: false,
        processData: false,
        dataType: "json",
        success: function (data) {

            if (data.errors) {
                $('#modal_login_phone_error').html(data.errors.phone);
                $('#modal_login_password_error').html(data.errors.password);
            }
            if (data.success) {
                console.log(data.success);
                location.reload();
            }

        }
    })


});