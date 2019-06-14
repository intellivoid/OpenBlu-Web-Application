<?php

    use DynamicalWeb\DynamicalWeb;
    use DynamicalWeb\Page;
use DynamicalWeb\Runtime;
use OpenBlu\Abstracts\SearchMethods\VPN;
    use OpenBlu\Exceptions\VPNNotFoundException;
    use OpenBlu\OpenBlu;
    use sws\sws;

    Runtime::import('OpenBlu');

    if(isset($_GET['action']))
    {
        if($_GET['action'] == 'download')
        {
            if(isset($_GET['token']))
            {
                /** @noinspection PhpUnhandledExceptionInspection */
                send_configuration_direct($_GET['token']);
            }
        }

    }

    /**
     * @param string $token
     * @throws Exception
     */
    function send_configuration_direct(string $token)
    {

        // Verify the token

        /** @var sws $sws */
        $sws = DynamicalWeb::getMemoryObject('sws');
        $Cookie = $sws->WebManager()->getCookie('web_session');

        if(WEB_SESSION_ACTIVE == false)
        {
            if($Cookie->Data['downloads'] > 3)
            {
                header('Location: /login_required');
                exit();
            }
        }

        if(hash('sha256', $Cookie->Data['download_token']) !== hash('sha256', $token))
        {
            header('Location: /');
            exit();
        }

        // Gets the selected VPN
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
            $VPN = $OpenBlu->getVPNManager()->getVPN(VPN::byPublicID, $Cookie->Data['download_target']);
        }
        catch(VPNNotFoundException $VPNNotFoundException)
        {
            header('Location: /');
            exit();
        }
        catch(Exception $exception)
        {
            Page::staticResponse(
                'OpenBlu Error',
                'Intellivoid Cloud Error',
                'The requested resource cannot be downloaded, error code ' . $exception->getCode()
            );
            exit();
        }

        $Cookie->Data['downloads'] += 1;
        $Token = $Cookie->Data['download_token'];
        $Cookie->Data['download_token'] = null;
        $Cookie->Data['download_target'] = null;
        $sws->CookieManager()->updateCookie($Cookie);
        
        header("Content-Type: application/x-openvpn-profile");
        header("Content-disposition: attachment; filename=\"openblu_$Token.ovpn\"");
        print($VPN->createConfiguration());
        exit();
    }