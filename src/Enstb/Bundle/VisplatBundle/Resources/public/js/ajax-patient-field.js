///////////////////////////////////////////////////
// Update the graphs with new data
// depended on patient, startDate, endDate
///////////////////////////////////////////////////

function updateGraph(patientId, startDate, endDate) {
    $.ajax({
        type: "POST",
        url: Routing.generate('enstb_visplat_ajax_update_patient'),
        data: JSON.stringify({id: patientId, startDate: startDate, endDate: endDate}),
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
///////////////////////////////////////////////////
// Update date field when the patientId is changed
///////////////////////////////////////////////////
function updateDateField(patientId) {
    $.ajax({
        type: "POST",
        url: Routing.generate('enstb_visplat_ajax_update_date'),
        data: JSON.stringify({id: patientId}),
        dataType: "json",
        async: false,
        success: function (data) {
            // Declared the data as global variable
            // Remove all the options inside the date selector
            $('#form_startDate').empty();
            $('#form_endDate').empty();
            // Reappend them
            for (i = 0; i < data.length; i++) {
                $('#form_startDate').append(
                    $('<option></option>').attr('value', data[i]).text(data[i])
                );
                $('#form_endDate').append(
                    $('<option></option>').attr('value', data[i]).text(data[i])
                )
            }
        },
        error: function (XMLHttpRequest, textStatus, errorThrown) {
            alert('Error : ' + errorThrown);
        }
    });
}
///////////////////////////////////////////////////
// Update the end date field depended on
// start date field, should be more than
// the start date field.
///////////////////////////////////////////////////
function updateEndDateField(patientId) {
    $.ajax({
        type: "POST",
        url: Routing.generate('enstb_visplat_ajax_update_date'),
        data: JSON.stringify({id: patientId}),
        dataType: "json",
        async: false,
        success: function (data) {
            $('#form_endDate').empty();
            for (i = 0; i < data.length; i++) {
                if (Date.parse(data[i]) >= Date.parse($('#form_startDate').val())) {
                    $('#form_endDate').append(
                        $('<option></option>').attr('value', data[i]).text(data[i])
                    );
                }
            }
        },
        error: function (XMLHttpRequest, textStatus, errorThrown) {
            alert('Error : ' + errorThrown);
        }
    });
}

$(document).ready(function () {
    // Global variable
    $('#form_patient').change(function () {
//        // Disabled the end date selector when the user is changed.
//        $('#form_endDate').attr('disabled', 'disabled');
        var patientId = $(this).val();
        // Update date field
        updateDateField(patientId);
        // Force the selector to select the first date
//        $('#form_date').val($('#form_date option:first').val());
        var startDate = $('#form_startDate').val();
        var endDate = $('#form_endDate').val();
        updateGraph(patientId, startDate, endDate)
    });
    $('#form_startDate').change(function () {
        // Enable endDate selector
//        if ($('#form_endDate').attr('disabled') != undefined) {
//            $('#form_endDate').removeAttr('disabled');
//        }
        var patientId = $('#form_patient').val();
        var startDate = $(this).val();
        updateEndDateField(patientId);
        var endDate = $('#form_endDate').val();
        updateGraph(patientId, startDate, endDate);
    });
    $('#form_endDate').change(function () {
        var patientId = $('#form_patient').val();
        var startDate = $('#form_startDate').val();
        var endDate = $(this).val();
        updateGraph(patientId, startDate, endDate);

    });
});
