<?php

    use DynamicalWeb\DynamicalWeb;
    use OpenBlu\Abstracts\SearchMethods\VPN;
    use OpenBlu\Exceptions\VPNNotFoundException;
    use OpenBlu\OpenBlu;

    if(isset($_GET['pub_id']) == false)
    {
        header('Location: servers');
        exit();
    }

    /** @noinspection PhpUnhandledExceptionInspection */
    DynamicalWeb::loadLibrary('OpenBlu', 'OpenBlu', 'OpenBlu.php');
    $OpenBlu = new OpenBlu();

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

    define('CACHE_VPN_PUBLIC_ID', $VPN->PublicID, false);
    define('CACHE_VPN_INTERNAL_ID', $VPN->ID, false);
    define('CACHE_VPN_IP', $VPN->IP, false);
    define('CACHE_VPN_SESSIONS', $VPN->Sessions, false);
    define('CACHE_VPN_TOTAL_SESSIONS', $VPN->TotalSessions, false);
    define('CACHE_VPN_PING', $VPN->Ping, false);
    define('CACHE_VPN_COUNTRY', $VPN->Country, false);
    define('CACHE_VPN_COUNTRY_SHORT', $VPN->CountryShort, false);
    define('CACHE_VPN_LAST_UPDATED', $VPN->LastUpdated, false);