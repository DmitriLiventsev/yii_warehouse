function init_form()
{
    $form = $('#user_form');
    $form.on('beforeSubmit', function (event, jqXHR, settings) {

        if ($form.find('.has-error').length) {
            return false;
        }

        var formData = new FormData($(this)[0]);

        $.ajax({
            url: $form.attr('action'),
            type: 'POST',
            data: formData,
            async: false,
            dataType: "json",
            success: function (data, status, xhr) {
                $.each( data.errors, function( key, value ) {
                    $form.yiiActiveForm('updateAttribute', 'user-' + key, [value]);
                });

                if (data.item_location != '') {
                    swal("Good job!", "User was created!", "success");
                    swal({
                            title: "Good job!",
                            text: data.success_message,
                            type: "success"
                        },
                        function(){
                            window.location = data.item_location;
                        });
                }
            },
            error: function (data) {
                sweetAlert("Oops...", 'Something went wrong', "error");
            },
            complete: function (data) {
            },
            cache: false,
            contentType: false,
            processData: false
        });

        return false;
    });
}

window.onload = function() {
    init_form();
};