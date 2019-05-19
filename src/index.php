<?php
    /**
     * DynamicalWeb Bootstrap v1.0.0.0
     */

    // Load the application resources
    require __DIR__ . DIRECTORY_SEPARATOR . 'resources' . DIRECTORY_SEPARATOR . 'DynamicalWeb' . DIRECTORY_SEPARATOR . 'DynamicalWeb.php';
    \DynamicalWeb\DynamicalWeb::loadApplication(__DIR__ . DIRECTORY_SEPARATOR . 'resources');
    \DynamicalWeb\DynamicalWeb::loadLibrary('Logixal', 'Logixal', 'Logixal.php');

    if(isset($_GET['set_language']))
    {
        \DynamicalWeb\Language::changeLanguage($_GET['set_language']);
        header('Location: '. APP_HOME_PAGE);
        exit();
    }

    $ip = 'Unknown';
    if(!empty($_SERVER['HTTP_CLIENT_IP']))
    {
        //ip from share internet
        $ip = $_SERVER['HTTP_CLIENT_IP'];
    }
    elseif(!empty($_SERVER['HTTP_X_FORWARDED_FOR']))
    {
        //ip pass from proxy
        $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
    }
    else
    {
        $ip = $_SERVER['REMOTE_ADDR'];
    }

    if(isset($_GET['c_view_point']) == false)
    {
        \Logixal\Logging::information('OpenBlu Web Application', sprintf('%s: /%s', $ip, APP_HOME_PAGE));
        \DynamicalWeb\Page::load(APP_HOME_PAGE);
    }
    else
    {
        if(strstr($_GET['c_view_point'], '/'))
        {
            \Logixal\Logging::information('OpenBlu Web Application', sprintf('%s: /%s', $ip, '404'));
            \DynamicalWeb\Page::load('404');
        }
        else
        {
            \Logixal\Logging::information('OpenBlu Web Application', sprintf('%s: /%s', $ip, $_GET['c_view_point']));
            \DynamicalWeb\Page::load($_GET['c_view_point']);
        }
    }

