var uploadedFile;

function init_image_uploader() {
    return $('#product-picture').on('change', function() {
        return readURL(this);
    });
}

function readURL(input) {
    var reader;
    if (input.files && input.files[0]) {
        reader = new FileReader;
        reader.onload = function(e) {
            $('#imagePreview').css('background', 'url(' + e.target.result + ')');
            $('#imagePreview').show();
            $('#imagePreview').width(400);
            $('#imagePreview').height(400);
            $('#imagePreview').css('background-size', 'cover');
            $('#productImage').hide();
        };
        $('.deletePhoto').show();
        reader.readAsDataURL(input.files[0]);

        $('.field-product-picture').removeClass('has-error');
        $('.field-product-picture .help-block').text('');
        uploadedFile = input.files[0];
    }
}

function init_form()
{
    $form = $('#product_form');
    $form.on('beforeSubmit', function (event, jqXHR, settings) {

        if ($form.find('.has-error').length) {
            return false;
        }

        var formData = new FormData($(this)[0]);

        $.ajax({
            url: $form.attr('action'),
            type: $form.attr('data-method'),
            data: formData,
            async: false,
            dataType: "json",
            success: function (data, status, xhr) {
                $.each( data.errors, function( key, value ) {
                    $form.yiiActiveForm('updateAttribute', 'product-' + key, [value]);
                });

                //Workaround, yiiActiveForm updateAttribute not working with file input fields
                if (data.errors.picture !== undefined) {
                    $('.field-product-picture').addClass('has-error');
                    $('.field-product-picture .help-block').text(data.errors.picture);
                }

                if (data.item_location != '') {
                    swal("Good job!", "Product was created!", "success");
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
    init_image_uploader();
    init_form();
};