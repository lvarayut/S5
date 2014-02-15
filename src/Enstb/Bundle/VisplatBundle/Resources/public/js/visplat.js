$(function() {
    $('#vp-navbar-fix-wrapper').height($("#vp-navbar-fix").height());
    $('#vp-navbar-fix').affix({
        offset: { top: $('#vp-navbar-fix').offset().top }
    });
});


//resizePieChart
var aspect = document.getElementById("piechart").height/document.getElementById("piechart").width,
    chart = $(".resizePieChart");
$(window).on("resize", function () {
    var targetWidth = chart.parent().width();
    chart.attr("width", targetWidth);
    chart.attr("height", Math.round(targetWidth / aspect));
}); 

//resizeTable
var aspect = document.getElementById("piechartTable").height/document.getElementById("piechartTable").width,
    table = $(".resizeTable");
$(window).on("resize", function () {
    var targetWidth = table.parent().width();
    table.attr("width", targetWidth);
    table.attr("height", targetWidth / aspect);
}); 

//resizeGanttChart
var aspect = (window.innerHeight*2/3)/document.getElementById("ganttchart").width,
    gantt = $(".resizeGanttChart");
$(window).on("resize", function () {
    var targetWidth = gantt.parent().width();
    gantt.attr("width", targetWidth);
    gantt.attr("height", Math.round(targetWidth / aspect));
}); 