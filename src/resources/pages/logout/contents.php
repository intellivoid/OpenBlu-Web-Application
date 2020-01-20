<?php

    use DynamicalWeb\DynamicalWeb;
    use DynamicalWeb\Runtime;
    use OpenBlu\OpenBlu;
    use sws\sws;

    Runtime::import('OpenBlu');

    if(WEB_SESSION_ACTIVE == false)
    {
        header('Location: /');
        exit();
    }


    /** @var sws $sws */
    $sws = DynamicalWeb::getMemoryObject('sws');
    $Cookie = $sws->WebManager()->getCookie('web_session');

    $Cookie->Data['cache_refresh'] = 0;
    $Cookie->Data['session_active'] = false;
    $Cookie->Data['account_pubid'] = null;
    $Cookie->Data['account_id'] = null;
    $Cookie->Data['account_email'] = null;
    $Cookie->Data['account_username'] = null;
    $Cookie->Data['downloads'] = 0;

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

    $Cookie->Data['client_authorized'] = false;
    $Cookie->Data['client_auth_expires'] = 0;

    $sws->CookieManager()->updateCookie($Cookie);

    header('Location: /');
    exit();