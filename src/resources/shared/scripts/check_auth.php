<?php

    use DynamicalWeb\DynamicalWeb;
    use DynamicalWeb\HTML;
    use sws\sws;

    try
    {
        DynamicalWeb::loadLibrary('sws', 'sws', 'sws.php');
    }
    catch (Exception $e)
    {
        header('Location: /500');
        exit();
    }

    $sws = new sws();

    if($sws->WebManager()->isCookieValid('web_session') == false)
    {
        $Cookie = $sws->CookieManager()->newCookie('web_session', 86400, false);

        $Cookie->Data = array(
            'session_active' => false,
            'account_pubid' => null,
            'account_id' => null,
            'account_email' => null,
            'account_username' => null,
            'downloads' => 0,
            'cache' => array(),
            'cache_refresh' => 0,

            // Client Mode Properties
            'client_mode_enabled' => false,
            'client_uid' => null,
            'client_name' => null,
            'client_version' => null,
            'client_authorized' => false,
            'client_account_id' => 0
        );

        $sws->CookieManager()->updateCookie($Cookie);
        $sws->WebManager()->setCookie($Cookie);

        if($Cookie->Name == null)
        {
            print('There was an issue with the security check, Please refresh the page');
            exit();
        }

        header('Refresh: 2; URL=/');
        print('Loading WebApp Resources ...');
        exit();

    }

    $Cookie = $sws->WebManager()->getCookie('web_session');
    define('WEB_SESSION_ACTIVE', $Cookie->Data['session_active'], false);
    define('WEB_ACCOUNT_PUBID', $Cookie->Data['account_pubid'], false);
    define('WEB_ACCOUNT_ID', $Cookie->Data['account_id'], false);
    define('WEB_ACCOUNT_EMAIL', $Cookie->Data['account_email'], false);
    define('WEB_ACCOUNT_USERNAME', $Cookie->Data['account_username'], false);
    define('WEB_DOWNLOADS', $Cookie->Data['downloads'], false);

    // Client properties and client session properties
    define('CLIENT_MODE_ENABLED', $Cookie->Data['client_mode_enabled'], false);
    define('CLIENT_UID', $Cookie->Data['client_authorized'], false);
    define('CLIENT_NAME', $Cookie->Data['client_name'], false);
    define('CLIENT_VERSION', $Cookie->Data['client_version'], false);
    define('CLIENT_AUTHORIZED', $Cookie->Data['client_authorized'], false);
    define('CLIENT_ACCOUNT_ID', $Cookie->Data['client_account_id'], false);

    HTML::importScript('client_mode');

    if(CLIENT_MODE_ENABLED == true)
    {
        if(WEB_SESSION_ACTIVE == false)
        {
            switch(APP_CURRENT_PAGE)
            {
                case 'login': break;

                case 'register': break;

                default:
                    header('Location: /login');
                    break;
            }
        }
    }