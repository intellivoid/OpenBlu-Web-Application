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
function show_notification(heading, text, icon)
{
    $.toast({
        heading: heading,
        text: text,
        showHideTransition: 'slide',
        icon: icon,
        loaderBg: '#fff',
        position: 'top-right'
    });
}