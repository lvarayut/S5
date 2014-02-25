function selectFieldChanged(id) {
    $.ajax({
        type: "POST",
        url: Routing.generate('enstb_visplat_ajax_update_patient'),
        data: JSON.stringify({id: id}),
        dataType: "json",
        success: function (data) {
            // Remove old graphs
            document.getElementById('piechart').innerHTML = '';
            document.getElementById('piechartTable').innerHTML = '';
            document.getElementById('ganttchart').innerHTML = '';
            // Create new graphs
            createPieChart(data[0]);
            createGanttChart(data[1]);
            // Create responsive
            createResponsive();
        },
        error: function (XMLHttpRequest, textStatus, errorThrown) {
            alert('Error : ' + errorThrown);
        }
    });
}

$(document).ready(function () {
    $('#form_patient').change(function () {
        var id = $(this).val();
        // Get the current route
        var pathname = window.location.pathname;
        selectFieldChanged(id)
    });
});
