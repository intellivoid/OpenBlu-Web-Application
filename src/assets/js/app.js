/**
 * OpenBlu Web Application
 *
 * Created and Written by Intellivoid
 */

$("#toggle-sidebar").click(function(){
    $("body").toggleClass("sidebar-icon-only");
    $("#sidebar").toggleClass("active");
    $.ajax({
        url: '/?update=ui&action=toggle-sidebar'
    });
});

$("#toggle-mini-sidebar").click(function(){
    $("body").toggleClass("sidebar-icon-only");
    $("#sidebar").toggleClass("active");
    $.ajax({
        url: '/?update=ui&action=toggle-sidebar'
    });
});