<?php

    use DynamicalWeb\DynamicalWeb;
    use DynamicalWeb\Runtime;
    use OpenBlu\OpenBlu;
    use sws\Objects\Cookie;

    Runtime::import('OpenBlu');
    $sws = DynamicalWeb::getMemoryObject('sws');

    if($sws->WebManager()->isCookieValid('web_session') == true)
    {

        /** @var Cookie $Cookie */
        $Cookie = DynamicalWeb::getMemoryObject('(cookie)web_session');

        if(time() > $Cookie->Data['cache_refresh'])
        {
            // No need to set these values to MMS since they will be used once
            $OpenBlu = new OpenBlu();

            $Cookie->Data['cache']['total_servers'] = $OpenBlu->getVPNManager()->totalServers();
            $Cookie->Data['cache']['total_sessions'] = $OpenBlu->getVPNManager()->totalSessions();
            $Cookie->Data['cache']['current_sessions'] = $OpenBlu->getVPNManager()->currentSessions();

            if(isset($Cookie->Data['cache']['ui']['sidebar_expanded']) == false)
            {
                $Cookie->Data['cache']['ui']['sidebar_expanded'] = true;
            }

            $Cookie->Data['cache_refresh'] = time() + 30;

            $sws->CookieManager()->updateCookie($Cookie);
            DynamicalWeb::setMemoryObject('(cookie)web_session', $Cookie);
        }

        define('CACHE_TOTAL_SERVERS', $Cookie->Data['cache']['total_servers'], false);
        define('CACHE_TOTAL_SESSIONS', $Cookie->Data['cache']['total_sessions'], false);
        define('CACHE_CURRENT_SESSIONS', $Cookie->Data['cache']['current_sessions'], false);
        define('CACHE_UI_SIDEBAR_EXPANDED', $Cookie->Data['cache']['ui']['sidebar_expanded'], false);

        if($Cookie->Data['cache']['ui']['sidebar_expanded'] == false)
        {
            define('SIDEBAR_STATE', ' class="sidebar-icon-only"', false);
            define('SIDEBAR_STATE_MINI', '', false);
        }
        else
        {
            define('SIDEBAR_STATE', '', false);
            define('SIDEBAR_STATE_MINI', ' active', false);
        }
    }