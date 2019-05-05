<?php

    use DynamicalWeb\DynamicalWeb;
    use DynamicalWeb\HTML;
    use OpenBlu\Abstracts\SearchMethods\ClientSearchMethod;
    use OpenBlu\OpenBlu;
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

    if(CLIENT_MODE_ENABLED == true)
    {
        DynamicalWeb::loadLibrary('OpenBlu', 'OpenBlu', 'OpenBlu.php');
        $OpenBlu = new OpenBlu();

        try
        {
            $Client = $OpenBlu->getClientManager()->getClient(ClientSearchMethod::byClientUid, $Cookie->Data['client_uid']);
            $Client->AuthExpires = 0;
            $OpenBlu->getClientManager()->updateClient($Client);
        }
        catch(Exception $exception)
        {
            // TODO: Fix issue where clients are not available
        }

        $Cookie->Data['client_authorized'] = false;
        $Cookie->Data['client_auth_expires'] = 0;
    }

    $sws->CookieManager()->updateCookie($Cookie);

    header('Location: /');
    exit();