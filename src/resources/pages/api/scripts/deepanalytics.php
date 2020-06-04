<?php


    use DeepAnalytics\Exceptions\DataNotFoundException;
    use DeepAnalytics\Objects\Date;
    use DeepAnalytics\Utilities;
    use DynamicalWeb\DynamicalWeb;
    use IntellivoidAPI\Objects\AccessRecord;
    use OpenBlu\OpenBlu;

    if(isset($_GET['action']))
    {
        switch($_GET['action'])
        {
            case "deepanalytics.locale":
                da_get_locale();
                break;

            case "deepanalytics.get_range":
                da_get_range();
                break;

            case "deepanalytics.get_monthly_data":
                da_get_monthly_data();
                break;

            case "deepanalytics.get_hourly_data":
                da_get_hourly_data();
                break;
        }
    }

    /**
     * Returns the locale data defined in the language file
     *
     * @noinspection PhpUndefinedConstantInspection
     */
    function da_get_locale()
    {
        $Results = array(
            'status' => true,
            'payload' => array(
                'DEEPANALYTICS_NO_DATA_ERROR' => TEXT_DEEPANALYTICS_NO_DATA_ERROR,
                'DEEPANALYTICS_GENERIC_ERROR' => TEXT_DEEPANALYTICS_GENERIC_ERROR,
                'DEEPANALYTICS_MONTHLY_USAGE' => TEXT_DEEPANALYTICS_MONTHLY_USAGE,
                'DEEPANALYTICS_DAILY_USAGE' => TEXT_DEEPANALYTICS_DAILY_USAGE,
                'DEEPANALYTICS_DATA_SELECTOR' => TEXT_DEEPANALYTICS_DATA_SELECTOR,
                'DEEPANALYTICS_DATE_SELECTOR' => TEXT_DEEPANALYTICS_DATE_SELECTOR,
                'DEEPANALYTICS_DATA_ALL' => TEXT_DEEPANALYTICS_DATA_ALL
            )
        );

        header('Content-Type: application/json');
        print(json_encode($Results));
        exit(0);
    }

    /**
     * Returns the hourly data which is used to be rendered in the linechart
     *
     * @noinspection DuplicatedCode
     */
    function da_get_hourly_data()
    {
        if(isset($_POST['year']) == false)
        {
            $Results = array(
                'status' => false,
                'error_code' => 10,
                'message' => 'Missing parameter \'year\''
            );

            header('Content-Type: application/json');
            print(json_encode($Results));
            exit(0);
        }

        if(isset($_POST['month']) == false)
        {
            $Results = array(
                'status' => false,
                'error_code' => 11,
                'message' => 'Missing parameter \'month\''
            );

            header('Content-Type: application/json');
            print(json_encode($Results));
            exit(0);
        }

        if(isset($_POST['day']) == false)
        {
            $Results = array(
                'status' => false,
                'error_code' => 12,
                'message' => 'Missing parameter \'day\''
            );

            header('Content-Type: application/json');
            print(json_encode($Results));
            exit(0);
        }

        if(isset(DynamicalWeb::$globalObjects['openblu']) == false)
        {
            /** @var OpenBlu $OpenBlu */
            $OpenBlu = DynamicalWeb::setMemoryObject('openblu', new OpenBlu());
        }
        else
        {
            /** @var OpenBlu $OpenBlu */
            $OpenBlu = DynamicalWeb::getMemoryObject('openblu');
        }


        /** @var AccessRecord $AccessRecord */
        $AccessRecord = DynamicalWeb::getMemoryObject('access_record');
        $SelectedDate = new Date();
        $SelectedDate->Year = (int)$_POST['year'];
        $SelectedDate->Month = (int)$_POST['month'];
        $SelectedDate->Day = (int)$_POST['day'];

        $Results = array();

        try
        {
            $Object = $OpenBlu->getDeepAnalytics()->getHourlyData(
                "intellivoid_api", "requests", $AccessRecord->ID, false,
                (int)$_POST['year'], (int)$_POST['month'], (int)$_POST['day']);

            $Results[$Object->Name] = array(
                'total' => $Object->Total,
                'data' => array()
            );

            foreach($Object->getData(true) as $key => $value)
            {
                $Results[$Object->Name]['data'][Utilities::generateFullHourStamp(
                    $SelectedDate, $key
                )] = $value;
            }
        }
        catch(DataNotFoundException $exception)
        {
            $Results['requests'] = null;
        }

        try
        {
            $Object = $OpenBlu->getDeepAnalytics()->getHourlyData(
                "openblu_api", "list_servers", $AccessRecord->ID, false,
                (int)$_POST['year'], (int)$_POST['month'], (int)$_POST['day']);

            $Results[$Object->Name] = array(
                'total' => $Object->Total,
                'data' => array()
            );

            foreach($Object->getData(true) as $key => $value)
            {
                $Results[$Object->Name]['data'][Utilities::generateFullHourStamp(
                    $SelectedDate, $key
                )] = $value;
            }

        }
        catch(DataNotFoundException $exception)
        {
            $Results['list_servers'] = null;
        }

        try
        {
            $Object = $OpenBlu->getDeepAnalytics()->getHourlyData(
                "openblu_api", "get_server", $AccessRecord->ID, false,
                (int)$_POST['year'], (int)$_POST['month'], (int)$_POST['day']);

            $Results[$Object->Name] = array(
                'total' => $Object->Total,
                'data' => array()
            );

            foreach($Object->getData(true) as $key => $value)
            {
                $Results[$Object->Name]['data'][Utilities::generateFullHourStamp(
                    $SelectedDate, $key
                )] = $value;
            }
        }
        catch(DataNotFoundException $exception)
        {
            $Results['get_server'] = null;
        }

        $Results = array(
            'status' => true,
            'results' => $Results
        );

        header('Content-Type: application/json');
        print(json_encode($Results));
        exit(0);
    }

    /**
     * Returns the monthly data that's used to render the linechart
     */
    function da_get_monthly_data()
    {
        if(isset($_POST['year']) == false)
        {
            $Results = array(
                'status' => false,
                'error_code' => 10,
                'message' => 'Missing parameter \'year\''
            );

            header('Content-Type: application/json');
            print(json_encode($Results));
            exit(0);
        }

        if(isset($_POST['month']) == false)
        {
            $Results = array(
                'status' => false,
                'error_code' => 11,
                'message' => 'Missing parameter \'month\''
            );

            header('Content-Type: application/json');
            print(json_encode($Results));
            exit(0);
        }

        if(isset(DynamicalWeb::$globalObjects['openblu']) == false)
        {
            /** @var OpenBlu $OpenBlu */
            $OpenBlu = DynamicalWeb::setMemoryObject('openblu', new OpenBlu());
        }
        else
        {
            /** @var OpenBlu $OpenBlu */
            $OpenBlu = DynamicalWeb::getMemoryObject('openblu');
        }

        /** @var AccessRecord $AccessRecord */
        $AccessRecord = DynamicalWeb::getMemoryObject('access_record');

        $Results = array();

        try
        {
            $Object = $OpenBlu->getDeepAnalytics()->getMonthlyData(
                "intellivoid_api", "requests", $AccessRecord->ID, false,
                (int)$_POST['year'], (int)$_POST['month']);

            $Results[$Object->Name] = array(
                'total' => $Object->Total,
                'data' => array()
            );

            foreach($Object->getData(true) as $key => $value)
            {
                $Results[$Object->Name]['data'][Utilities::generateHourlyStamp(
                    (int)$_POST['year'], (int)$_POST['month'], $key
                )] = $value;
            }
        }
        catch(DataNotFoundException $exception)
        {
            $Results['requests'] = null;
        }

        try
        {
            $Object = $OpenBlu->getDeepAnalytics()->getMonthlyData(
                "openblu_api", "list_servers", $AccessRecord->ID, false,
                (int)$_POST['year'], (int)$_POST['month']);

            $Results[$Object->Name] = array(
                'total' => $Object->Total,
                'data' => array()
            );

            foreach($Object->getData(true) as $key => $value)
            {
                $Results[$Object->Name]['data'][Utilities::generateHourlyStamp(
                    (int)$_POST['year'], (int)$_POST['month'], $key
                )] = $value;
            }
        }
        catch(DataNotFoundException $exception)
        {
            $Results['list_servers'] = null;
        }

        try
        {
            $Object = $OpenBlu->getDeepAnalytics()->getMonthlyData(
                "openblu_api", "get_server", $AccessRecord->ID, false,
                (int)$_POST['year'], (int)$_POST['month']);

            $Results[$Object->Name] = array(
                'total' => $Object->Total,
                'data' => array()
            );

            foreach($Object->getData(true) as $key => $value)
            {
                $Results[$Object->Name]['data'][Utilities::generateHourlyStamp(
                    (int)$_POST['year'], (int)$_POST['month'], $key
                )] = $value;
            }
        }
        catch(DataNotFoundException $exception)
        {
            $Results['get_server'] = null;
        }

        $Results = array(
            'status' => true,
            'results' => $Results
        );

        header('Content-Type: application/json');
        print(json_encode($Results));
        exit(0);
    }

    /**
     * Returns the data range that's available
     */
    function da_get_range()
    {
        if(isset(DynamicalWeb::$globalObjects['openblu']) == false)
        {
            /** @var OpenBlu $OpenBlu */
            $OpenBlu = DynamicalWeb::setMemoryObject('openblu', new OpenBlu());
        }
        else
        {
            /** @var OpenBlu $OpenBlu */
            $OpenBlu = DynamicalWeb::getMemoryObject('openblu');
        }

        /** @var AccessRecord $AccessRecord */
        $AccessRecord = DynamicalWeb::getMemoryObject('access_record');

        $Results = array(
            "requests" => array(
                "monthly" => $OpenBlu->getDeepAnalytics()->getMonthlyDataRange(
                    "intellivoid_api", "requests", $AccessRecord->ID),
                "hourly" => $OpenBlu->getDeepAnalytics()->getHourlyDataRange(
                    "intellivoid_api", "requests", $AccessRecord->ID),
                "text" => TEXT_DATA_TYPE_REQUESTS
            ),
            "list_servers" => array(
                "monthly" => $OpenBlu->getDeepAnalytics()->getMonthlyDataRange(
                    "openblu_api", "list_servers", $AccessRecord->ID),
                "hourly" => $OpenBlu->getDeepAnalytics()->getHourlyDataRange(
                    "openblu_api", "list_servers", $AccessRecord->ID),
                "text" => TEXT_DATA_TYPE_SERVER_LISTING_REQUESTED
            ),
            "get_server" => array(
                "monthly" => $OpenBlu->getDeepAnalytics()->getMonthlyDataRange(
                    "openblu_api", "get_server", $AccessRecord->ID),
                "hourly" => $OpenBlu->getDeepAnalytics()->getHourlyDataRange(
                    "openblu_api", "get_server", $AccessRecord->ID),
                "text" => TEXT_DATA_TYPE_SERVER_REQUESTED
            )
        );

        header('Content-Type: application/json');
        print(json_encode($Results));
        exit(0);
    }