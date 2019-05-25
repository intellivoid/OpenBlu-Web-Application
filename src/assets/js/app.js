$("#toggle-sidebar").click(function(){
    $("body").toggleClass("sidebar-icon-only");
    $.ajax({
        url: '/?update=ui&action=toggle-sidebar'
    });
});
$("#toggle-sidebar-mini").click(function(){
    $("body").toggleClass("sidebar-icon-only");
    $.ajax({
        url: '/?update=ui&action=toggle-sidebar'
    });
});