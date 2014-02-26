// Affix
$(function () {
    $('#vp-navbar-fix-wrapper').height($("#vp-navbar-fix").height());
    $('#vp-navbar-fix').affix({
        offset: { top: $('#vp-navbar-fix').offset().top }
    });
});


// Add .active into a navbar-menu
$(function () {
    var url = window.location;
    $('ul.nav a').filter(function () {
        return this.href == url;
    }).parent().addClass('active');
})

$(function () {
//    $('#legend').height($('#statustable').height());
});

// Add responsive graph
function createResponsive() {
    //resizePieChart
    if ($('#piechart').length) {
        var aspect = document.getElementById("piechart").offsetHeight / document.getElementById("piechart").offsetWidth;
        chart = $(".resizePieChart");
        $(window).on("resize", function () {
            var targetWidth = chart.parent().width();
            chart.attr("width", targetWidth);
            chart.attr("height", Math.round(targetWidth * aspect));
        });
    }

    //resizeTable
    if ($('#piechartTable').length) {
        var aspect2 = document.getElementById("piechartTable").offsetHeight / document.getElementById("piechartTable").offsetWidth;
        table = $(".resizeTable");
        $(window).on("resize", function () {
            var targetWidth = table.parent().width();
            table.attr("width", targetWidth);
            table.attr("height", targetWidth * aspect2);
        });
    }

    //resizeGanttChart
    if ($('#ganttchart').length) {
        var aspect3 = document.getElementById("ganttchart").offsetHeight / document.getElementById("ganttchart").offsetWidth;
        gantt = $(".resizeGanttChart");
        $(window).on("resize", function () {
            var targetWidth = gantt.parent().width();
            gantt.attr("width", targetWidth);
            gantt.attr("height", targetWidth * aspect3);
        });
    }

    if ($('#chordDiagram').length) {
        var aspect4 = document.getElementById("chordDiagram").offsetHeight / document.getElementById("chordDiagram").offsetWidth;
        chordDiagram = $(".resizeChordDiagram");
        $(window).on("resize", function () {
            var targetWidth = chordDiagram.parent().width();
            chordDiagram.attr("width", targetWidth);
            chordDiagram.attr("height", targetWidth * aspect4);
        });
    }

    if ($('#statustable').length) {
        var aspect5 = document.getElementById("statustable").offsetHeight / document.getElementById("statustable").offsetWidth;
        statusTable = $(".resizeStatusTable");
        $(window).on("resize", function () {
            var targetWidth = statusTable.parent().width();
            statusTable.attr("width", targetWidth);
            statusTable.attr("height", targetWidth * aspect5);
        });
    }
}
$(document).ready(function () {
    createResponsive();
});