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

    $Javascript = "$(function() { 'use strict'; if ($('#api-usage-chart').length) { Morris.Line({";
    $Javascript .= "element: 'api-usage-chart',";
    $Javascript .= "parseTime: false,";
    $Javascript .= "resize: true,";
    $Javascript .= "redraw: true,";
    $Javascript .= "lineColors: ['#0088cc', '#d53f3a', '#47a447', '#5bc0de'],";

    if($AccessKeyObject->Analytics->LastMonthAvailable == true)
    {
        $data = [];

        foreach($AccessKeyObject->Analytics->CurrentMonthUsage as $key => $value)
        {
            $data[$key]['day'] = $key +1;
            $data[$key]['day'] = (string)$data[$key]['day'];
            $data[$key]['current_month'] = $value;
        }

        foreach($AccessKeyObject->Analytics->CurrentMonthUsage as $key => $value)
        {
            $data[$key]['day'] = $key +1;
            $data[$key]['day'] = (string)$data[$key]['day'];
            $data[$key]['last_month'] = $value;
        }

        $Javascript .= "data: " . json_encode($data) . ",";
        $Javascript .= "xkey: \"day\",";
        $Javascript .= "ykeys: ['current_month', 'last_month'],";
        $Javascript .= "labels: ['" . TEXT_API_USAGE_GRAPH_CURRENT_MONTH . "', '" . TEXT_API_USAGE_GRAPH_LAST_MONTH .  "']";
    }
    else
    {
        $data = [];

        foreach($AccessKeyObject->Analytics->CurrentMonthUsage as $key => $value)
        {
            $data[$key]['day'] = $key +1;
            $data[$key]['day'] = (string)$data[$key]['day'];
            $data[$key]['current_month'] = $value;
        }

        $Javascript .= "data: " . json_encode($data) . ",";
        $Javascript .= "xkey: \"day\",";
        $Javascript .= "ykeys: ['current_month'],";
        $Javascript .= "labels: ['Current Month']";
    }


    $Javascript .= "});}})";

    print("<script>$Javascript</script>");