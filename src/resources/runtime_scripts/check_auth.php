<?php

    use DynamicalWeb\DynamicalWeb;
    use DynamicalWeb\HTML;
    use DynamicalWeb\Runtime;
    use sws\sws;

    Runtime::import('SecuredWebSessions');

    /** @var sws $sws */
    $sws = DynamicalWeb::setMemoryObject('sws', new sws());

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
            'client_account_id' => 0,
            'client_auth_expires' => 0
        );

        $sws->CookieManager()->updateCookie($Cookie);
        $sws->WebManager()->setCookie($Cookie);

        if($Cookie->Name == null)
        {
            print('There was an issue with the security check, Please refresh the page');
            exit();
        }

        header('Refresh: 2; URL=/');
        HTML::importScript('loading_splash');
        exit();

    }

    $Cookie = $sws->WebManager()->getCookie('web_session');
    DynamicalWeb::setMemoryObject('(cookie)web_session', $Cookie);

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
    define('CLIENT_AUTH_EXPIRES', $Cookie->Data['client_auth_expires'], false);