$(document).ready(function() {
    // Check if element is scrolled into view
    function isScrolledIntoView(elem) {
        var docViewTop = $(window).scrollTop();
        var docViewBottom = docViewTop + $(window).height();

        var elemTop = $(elem).offset().top;
        var elemBottom = elemTop + $(elem).height();

        return ((elemBottom <= docViewBottom) && (elemTop >= docViewTop));
    }
    function executeAnimations()
    {
        $('.table .animated').each(function() {
            if (isScrolledIntoView(this) === true) {
                $(this).removeClass('invisible');
                $(this).addClass('slideInLeft');
            }
        });
    }
    executeAnimations();
    // If element is scrolled into view, fade it in
    $(window).scroll(function() {
        executeAnimations();
    });
});