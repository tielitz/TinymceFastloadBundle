$('#tiny_inner_image').bind('change', function (event) {
    // event.stopPropagation();
    // event.preventDefault();

    formElement = document.getElementById("tinymce_file_uploader");
    data = new FormData(formElement);
    ed = tinymce.get('news_type_text');

    var tmpMsg = flashes.info('', 'Bild wird hochgeladen');
    ed.getBody().setAttribute('contenteditable', 'false');
    var tinyContainer = $('.mce-tinymce.mce-container.mce-panel');
    tinyContainer.css({opacity: 0.5});

    $.ajax({
        url: $('#tinymce_file_uploader').attr('action'),
        type: 'POST',
        data: data,
        contentType: false,
        processData: false,
        success: function (response) {
            if (typeof(tinymce) != 'undefined') {
                ed.selection.setContent(response);

                // Remove uploaded image, so it is possibly to reupload the same
                $('#tiny_inner_image').closest('form').get(0).reset();
                flashes.success('', 'Bild wurde hochgeladen');
            }
        },
        error: function () {
            // alert('Bild konnte nicht erfolgreich hochgeladen werden.');
            flashes.danger('', 'Bild konnte nicht hochgeladen werden');
        },
        complete: function () {
            ed.getBody().setAttribute('contenteditable', 'true');
            tmpMsg.alert('close');
            tinyContainer.css({opacity: 1});
        }
    });
});
