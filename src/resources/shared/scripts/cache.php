<?php

    \DynamicalWeb\DynamicalWeb::loadLibrary('sws', 'sws', 'sws.php');
    \DynamicalWeb\DynamicalWeb::loadLibrary('OpenBlu', 'OpenBlu', 'OpenBlu.php');

    $sws = new \sws\sws();

    if($sws->WebManager()->isCookieValid('web_session') == true)
    {

        $Cookie = $sws->WebManager()->getCookie('web_session');

        if(time() > $Cookie->Data['cache_refresh'])
        {
            $OpenBlu = new \OpenBlu\OpenBlu();

            $Cookie->Data['cache']['total_servers'] = $OpenBlu->getVPNManager()->totalServers();
            $Cookie->Data['cache']['total_sessions'] = $OpenBlu->getVPNManager()->totalSessions();
            $Cookie->Data['cache']['current_sessions'] = $OpenBlu->getVPNManager()->currentSessions();

            $Cookie->Data['cache_refresh'] = time() + 30;

            $sws->CookieManager()->updateCookie($Cookie);
        }

        define('CACHE_TOTAL_SERVERS', $Cookie->Data['cache']['total_servers'], false);
        define('CACHE_TOTAL_SESSIONS', $Cookie->Data['cache']['total_sessions'], false);
        define('CACHE_CURRENT_SESSIONS', $Cookie->Data['cache']['current_sessions'], false);
    }