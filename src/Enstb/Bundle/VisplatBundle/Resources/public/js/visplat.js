$(function() {
    $('#vp-navbar-fix-wrapper').height($("#vp-navbar-fix").height());
    $('#vp-navbar-fix').affix({
        offset: { top: $('#vp-navbar-fix').offset().top }
    });
});


//resizePieChart
var aspect = document.getElementById("piechart").offsetHeight/document.getElementById("piechart").offsetWidth;
    chart = $(".resizePieChart");
$(window).on("resize", function () {
    var targetWidth = chart.parent().width();
    chart.attr("width", targetWidth);
    chart.attr("height", Math.round(targetWidth * aspect));
}); 

//resizeTable
var aspect2 = document.getElementById("piechartTable").offsetHeight/document.getElementById("piechartTable").offsetWidth;
    table = $(".resizeTable");
$(window).on("resize", function () {
    var targetWidth = table.parent().width();
    table.attr("width", targetWidth);
    table.attr("height", targetWidth * aspect2);
});     

//resizeGanttChart
var aspect3 = document.getElementById("ganttchart").offsetHeight/document.getElementById("ganttchart").offsetWidth;
    gantt = $(".resizeGanttChart");
$(window).on("resize", function () {
    var targetWidth = table.parent().width();
    gantt.attr("width", targetWidth);
    gantt.attr("height", targetWidth * aspect3);
});     