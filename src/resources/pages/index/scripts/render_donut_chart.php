<script>
    var chart = Morris.Donut({
        element: 'basic-analytics',
        colors: ['#76C1FA', '#F36368', '#63CF72', '#FABA66'],
        data: [
            {
                label: "<?PHP \DynamicalWeb\HTML::print(TEXT_ANALYTICS_SERVERS); ?>",
                value: <?PHP \DynamicalWeb\HTML::print(CACHE_TOTAL_SERVERS); ?>
            },
            {
                label: "<?PHP \DynamicalWeb\HTML::print(TEXT_ANALYTICS_SESSIONS); ?>",
                value: <?PHP \DynamicalWeb\HTML::print(CACHE_CURRENT_SESSIONS); ?>
            },
            {
                label: "<?PHP \DynamicalWeb\HTML::print(TEXT_ANALYTICS_TOTAL_SESSIONS); ?>",
                value: <?PHP \DynamicalWeb\HTML::print(CACHE_TOTAL_SESSIONS); ?>
            }
        ],
        resize: true,
        redraw: true
    });
    chart.options.data.forEach(function(label, i) {
        var legendItem = $('<span></span>').text( label['label'] + " ( " +label['value'] + " )" ).prepend('<br><span>&nbsp;</span>');
        legendItem.find('span')
            .css('backgroundColor', chart.options.colors[i])
            .css('width', '20px')
            .css('display', 'inline-block')
            .css('margin', '5px');
        $('#legend').append(legendItem)
    });
</script>