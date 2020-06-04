<?php

    use DynamicalWeb\DynamicalWeb;
    use DynamicalWeb\Runtime;
    use OpenBlu\Abstracts\SearchMethods\VPN;
    use OpenBlu\Exceptions\VPNNotFoundException;
    use OpenBlu\OpenBlu;
    use sws\sws;

    if(isset($_GET['pub_id']) == false)
    {
        header('Location: servers');
        exit();
    }

    /** @noinspection PhpUnhandledExceptionInspection */
    Runtime::import('OpenBlu');
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

    try
    {
        $VPN = $OpenBlu->getVPNManager()->getVPN(VPN::byPublicID, $_GET['pub_id']);
    }
    catch(VPNNotFoundException $VPNNotFoundException)
    {
        header('Location: servers?callback=100');
        exit();
    }
    catch(Exception $exception)
    {
        header('Location: servers?callback=100');
        exit();
    }

    // Set a special one-time download token
    /** @noinspection PhpUnhandledExceptionInspection */
    Runtime::import('SecuredWebSessions');
    $sws = new sws();

    $Cookie = $sws->WebManager()->getCookie('web_session');
    $Cookie->Data['download_token'] = hash('haval128,3', $VPN->PublicID . time());
    $Cookie->Data['download_target'] = $VPN->PublicID;

    $sws->CookieManager()->updateCookie($Cookie);

    define('CACHE_VPN_PUBLIC_ID', $VPN->PublicID, false);
    define('SERVER_META_ID', $VPN->PublicID, false);
    define('CACHE_VPN_INTERNAL_ID', $VPN->ID, false);
    define('CACHE_VPN_IP', $VPN->IP, false);
    define('SERVER_META_IP', $VPN->IP, false);
    define('CACHE_VPN_SESSIONS', $VPN->Sessions, false);
    define('CACHE_VPN_TOTAL_SESSIONS', $VPN->TotalSessions, false);
    define('CACHE_VPN_PING', $VPN->Ping, false);
    define('CACHE_VPN_COUNTRY', $VPN->Country, false);
    define('SERVER_META_COUNTRY', $VPN->Country, false);
    define('CACHE_VPN_COUNTRY_SHORT', $VPN->CountryShort, false);
    define('CACHE_VPN_LAST_UPDATED', $VPN->LastUpdated, false);
    define('CACHE_VPN_TOKEN', $Cookie->Data['download_token'], false);

    if(isset($_GET['action']) == 'gen_token')
    {
        if(WEB_SESSION_ACTIVE == false)
        {
            if($Cookie->Data['downloads'] > 3)
            {
                $results = array(
                    'success' => false,
                    'message' => 'authentication_required'
                );
                header('Content-Type: application/json');
                print(json_encode($results));
                exit();
            }
        }

        $results = array(
            'success' => true,
            'download_token' => $Cookie->Data['download_token'],
            'download_target' => $VPN->PublicID,
            'file_type' => 'ovpn'
        );
        header('Content-Type: application/json');
        print(json_encode($results));
        exit();
    }