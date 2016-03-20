var globalEd = undefined;

function tinymce_button_image_uploader(ed) {
    globalEd = ed;
    $('#tinymce_file_uploader input[type=file]').click();
}
