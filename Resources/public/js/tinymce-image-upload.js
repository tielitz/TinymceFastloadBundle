$('#tiny_inner_image').bind('change', function (event) {
    formElement = document.getElementById("tinymce_file_uploader");
    data = new FormData(formElement);

    $.ajax({
        url: $('#tinymce_file_uploader').attr('action'),
        type: 'POST',
        data: data,
        contentType: false,
        processData: false,
        success: function (response) {
            if (typeof(tinymce) != 'undefined') {
                globalEd.selection.setContent(response);

                // Remove uploaded image, so it is possibly to reupload the same
                $('#tiny_inner_image').closest('form').get(0).reset();
            }
        },
        error: function () {
            alert('Bild konnte nicht erfolgreich hochgeladen werden.');
        }
    });
});
