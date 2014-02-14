$(function() {
    $('#vp-navbar-fix-wrapper').height($("#vp-navbar-fix").height());
    $('#vp-navbar-fix').affix({
        offset: { top: $('#vp-navbar-fix').offset().top }
    });
});


//resizeChart
var aspect = window.innerWidth / (window.innerHeight * 2/3),
    chart = $(".resizeChart");
$(window).on("resize", function () {
    var targetWidth = chart.parent().width();
    chart.attr("width", targetWidth);
    chart.attr("height", Math.round(targetWidth / aspect));
}); 

//resizeTable
var aspect = window.innerWidth / window.innerHeight,
    table = $(".resizeTable");
$(window).on("resize", function () {
    var targetWidth = table.parent().width();
    table.attr("width", targetWidth);
    table.attr("height", targetWidth / aspect);
}); 