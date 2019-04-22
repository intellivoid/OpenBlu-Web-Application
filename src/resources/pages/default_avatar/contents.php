<?php

    use DynamicalWeb\HTML;

    /** @noinspection PhpUnhandledExceptionInspection */
    HTML::importScript('check_auth');

    if(defined('WEB_SESSION_ACTIVE') == true)
    {
        if(WEB_SESSION_ACTIVE == true)
        {
            display_picture();
        }
    }

    exit();

    function display_picture()
    {
        $resource = file_get_contents('https://ui-avatars.com/api/?background=2e2f32&color=fff&name=' . urlencode(WEB_ACCOUNT_USERNAME));

        header('Content-Type: image/png');
        header('cache-control: max-age=172800');
        header('Content-Length: ' . strlen($resource));
        print($resource);
    }