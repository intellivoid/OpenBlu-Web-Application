<?PHP

    use DynamicalWeb\DynamicalWeb;
    use ModularAPI\Abstracts\AccessKeySearchMethod;
    use ModularAPI\ModularAPI;

    if(class_exists('ModularAPI\ModularAPI') == false)
    {
        DynamicalWeb::loadLibrary('ModularAPI', 'ModularAPI', 'ModularAPI');
    }

    $ModularAPI = new ModularAPI();
    $AccessKeyObject = $ModularAPI->AccessKeys()->Manager->get(AccessKeySearchMethod::byID, CACHE_SUBSCRIPTION_ACCESS_KEY_ID);

    var_dump($AccessKeyObject);

?>
<script>
    $(function() {
        'use strict';
        if ($('#morris-line-example').length) {
            Morris.Line({
                element: 'morris-line-example',
                lineColors: ['#0088cc', '#d53f3a', '#47a447', '#5bc0de'],
                data: [
                    {
                        y: '2006',
                        a: 100,
                        b: 150
                    },
                    {
                        y: '2007',
                        a: 75,
                        b: 65
                    },
                    {
                        y: '2008',
                        a: 50,
                        b: 40
                    },
                    {
                        y: '2009',
                        a: 75,
                        b: 65
                    },
                    {
                        y: '2010',
                        a: 50,
                        b: 40
                    },
                    {
                        y: '2011',
                        a: 75,
                        b: 65
                    },
                    {
                        y: '2012',
                        a: 100,
                        b: 90
                    }
                ],
                xkey: 'y',
                ykeys: ['a', 'b'],
                labels: ['Series A', 'Series B']
            });
        }
    })
</script>