function updateGraph(patientId, date) {
    $.ajax({
        type: "POST",
        url: Routing.generate('enstb_visplat_ajax_update_patient'),
        data: JSON.stringify({id: patientId, date: date}),
        dataType: "json",
        success: function (data) {
            // Verify an existence of #piechart
            if ($("#piechart").length && $('#piechartTable').length) {
                // Remove old graphs
                document.getElementById('piechart').innerHTML = '';
                document.getElementById('piechartTable').innerHTML = '';
                createPieChart(data['pieChart']);
            }
            if ($('#ganttchart').length) {
                document.getElementById('ganttchart').innerHTML = '';
                createGanttChart(data['ganttChart']);
            }
            // Create responsive
            createResponsive();
        },
        error: function (XMLHttpRequest, textStatus, errorThrown) {
            alert('Error : ' + errorThrown);
        }
    });
}

function updateDateField(patientId) {
    $.ajax({
        type: "POST",
        url: Routing.generate('enstb_visplat_ajax_update_date'),
        data: JSON.stringify({id: patientId}),
        dataType: "json",
        async: false,
        success: function (data) {
            // Remove all the options inside the date selector
            $('#form_date').empty();
            // Reappend them
            for (i = 0; i < data.length; i++) {
                $('#form_date').append(
                    $('<option></option>').attr('value', data[i]).text(data[i])
                );
            }
        },
        error: function (XMLHttpRequest, textStatus, errorThrown) {
            alert('Error : ' + errorThrown);
        }
    });
}


$(document).ready(function () {
    $('#form_patient').change(function () {
        var patientId = $(this).val();
        // Update date field
        updateDateField(patientId);
        // Force the selector to select the first date
//        $('#form_date').val($('#form_date option:first').val());
        var date = $('#form_date').val();
        updateGraph(patientId, date)
    });
    $('#form_date').change(function () {
        var patientId = $('#form_patient').val();
        var date = $(this).val();
        updateGraph(patientId, date);
    });
});
