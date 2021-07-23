// Call the dataTables jQuery plugin
$(document).ready(function() {
    $("#dataTable").DataTable({
        aoColumnDefs: [{
            bSortable: false,
            aTargets: ["sortoff"]
        }]
    });
});