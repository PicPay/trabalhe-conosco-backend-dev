(function ($) {
    "use strict"; // Start of use strict

    // Call the summernote jQuery plugin
    $(document).ready(function () {
        $('#descricao').summernote({
            disableResizeEditor: true,
            height: 180,
            toolbar: [
                ['style', ['bold', 'italic', 'underline', 'clear']],
                ['para', ['ul', 'ol']],
                ['insert', ['link']],
                ['misc', ['undo', 'redo', 'fullscreen', 'help']]
            ]
        });
        
        $('.note-statusbar').hide();
    });

})(jQuery); // End of use strict