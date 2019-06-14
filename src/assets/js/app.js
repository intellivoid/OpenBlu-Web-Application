/**
 * OpenBlu Web Application
 *
 * Created and Written by Intellivoid
 */
$("#toggle-sidebar").click(function(){
    $("body").toggleClass("sidebar-icon-only");
    $("#sidebar").toggleClass("active");
    toggle_sidebar_state();
});
$("#toggle-mini-sidebar").click(function(){
    $("body").toggleClass("sidebar-icon-only");
    $("#sidebar").toggleClass("active");
    toggle_sidebar_state();
});
function toggle_sidebar_state()
{
    $.ajax({url: '/?update=ui&action=toggle-sidebar'});
}
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

console.log("%cOpenBlu", "color: blue; font-size: x-large");
console.log("%cCreated and Developed by Intellivoid (https://intellivoid.info)", "color: blue;");
console.log("%cWeb Application written by Netkas (https://twitter.com/netkas)", "color: blue;");
console.log("%cHosted by Bytechain Industries (https://twitter.com/bytechain)\n", "color: blue;");