// DataTables Demo
(function($) {
    "use strict";

    // Call the dataTables jQuery plugin
    $(document).ready(function() {
        $('#dataTable').DataTable({
            "language": {
                "url": "//cdn.datatables.net/plug-ins/1.10.20/i18n/Indonesian.json"
            },
            "pageLength": 10,
            "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "Semua"]],
            "order": [[0, "asc"]],
            "responsive": true,
            "dom": '<"top"lf>rt<"bottom"ip><"clear">',
            "initComplete": function() {
                // Add custom styling
                $('.dataTables_wrapper').addClass('netflix-style');
            }
        });
    });

})(jQuery); 