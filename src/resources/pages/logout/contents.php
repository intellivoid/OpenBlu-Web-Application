<?php

    use DynamicalWeb\DynamicalWeb;
    use DynamicalWeb\HTML;
    use sws\sws;

    /** @noinspection PhpUnhandledExceptionInspection */
    HTML::importScript('check_auth');

    if(WEB_SESSION_ACTIVE == false)
    {
        header('Location: /');
        exit();
    }

    /** @noinspection PhpUnhandledExceptionInspection */
    DynamicalWeb::loadLibrary('sws', 'sws', 'sws.php');

    $sws = new sws();
    $Cookie = $sws->WebManager()->getCookie('web_session');

    $Cookie->Data['cache_refresh'] = 0;
    $Cookie->Data['session_active'] = false;
    $Cookie->Data['account_pubid'] = null;
    $Cookie->Data['account_id'] = null;
    $Cookie->Data['account_email'] = null;
    $Cookie->Data['account_username'] = null;
    $Cookie->Data['downloads'] = 0;

    $sws->CookieManager()->updateCookie($Cookie);
    header('Location: /');
    exit();