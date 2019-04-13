<?php

    use DynamicalWeb\DynamicalWeb;
    use IntellivoidAccounts\Abstracts\SearchMethods\AccountSearchMethod;
    use IntellivoidAccounts\IntellivoidAccounts;
    use OpenBlu\OpenBlu;
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

    try
    {
        DynamicalWeb::loadLibrary('OpenBlu', 'OpenBlu', 'OpenBlu.php');
    }
    catch (Exception $e)
    {
        header('Location: /500');
        exit();
    }

    $sws = new sws();

    if($sws->WebManager()->isCookieValid('web_session') == true)
    {

        $Cookie = $sws->WebManager()->getCookie('web_session');

        if(time() > $Cookie->Data['cache_refresh'])
        {
            $OpenBlu = new OpenBlu();

            $Cookie->Data['cache']['total_servers'] = $OpenBlu->getVPNManager()->totalServers();
            $Cookie->Data['cache']['total_sessions'] = $OpenBlu->getVPNManager()->totalSessions();
            $Cookie->Data['cache']['current_sessions'] = $OpenBlu->getVPNManager()->currentSessions();
            $Cookie->Data['cache']['balance_available'] = false;
            $Cookie->Data['cache']['balance_amount'] = 0;

            if(defined('WEB_SESSION_ACTIVE') == true)
            {
                if(WEB_SESSION_ACTIVE == true)
                {
                    /** @noinspection PhpUnhandledExceptionInspection */
                    DynamicalWeb::loadLibrary('IntellivoidAccounts', 'IntellivoidAccounts', 'IntellivoidAccounts.php');

                    $IntellivoidAccounts = new IntellivoidAccounts();

                    /** @noinspection PhpUnhandledExceptionInspection */
                    $AccountObject = $IntellivoidAccounts->getAccountManager()->getAccount(AccountSearchMethod::byId, WEB_ACCOUNT_ID);

                    $Cookie->Data['cache']['balance_available'] = true;
                    $Cookie->Data['cache']['balance_amount'] = $AccountObject->Configuration->Balance;
                }
            }

            $Cookie->Data['cache_refresh'] = time() + 30;

            $sws->CookieManager()->updateCookie($Cookie);
        }

        define('CACHE_TOTAL_SERVERS', $Cookie->Data['cache']['total_servers'], false);
        define('CACHE_TOTAL_SESSIONS', $Cookie->Data['cache']['total_sessions'], false);
        define('CACHE_CURRENT_SESSIONS', $Cookie->Data['cache']['current_sessions'], false);
    }