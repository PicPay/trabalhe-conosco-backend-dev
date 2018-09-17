(function ($) {
    "use strict"; // Start of use strict

    // Call the dataTables jQuery plugin
    $(document).ready(function () {
        var table = $('#dataTable').DataTable({
            "processing": true,
            "serverSide": true,
            "lengthMenu": [ 15, 30, 50, 75, 100 ],

            "ajax": {
                "url": $('#dataTable').data('url'),
                "type": "POST",
            },

            "columns": [
                { "data": "id" },
                { "data": "name" },
                { "data": "username" }
            ],

            "language": {
                "url": "./public/vendor/datatables/language/Portuguese-Brasil.json"
            }
        });
    });
})(jQuery); // End of use strict