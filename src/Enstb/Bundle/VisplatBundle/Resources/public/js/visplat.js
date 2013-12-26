$(function() {
    $('#vp-navbar-fix-wrapper').height($("#vp-navbar-fix").height());
    $('#vp-navbar-fix').affix({
        offset: { top: $('#vp-navbar-fix').offset().top }
    });
});