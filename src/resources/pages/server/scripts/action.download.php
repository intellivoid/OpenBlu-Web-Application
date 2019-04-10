<?php

    use DynamicalWeb\DynamicalWeb;
    use DynamicalWeb\Page;
    use OpenBlu\Abstracts\SearchMethods\VPN;
    use OpenBlu\Exceptions\VPNNotFoundException;
    use OpenBlu\OpenBlu;
    use sws\sws;

    if(isset($_GET['action']))
    {
        if(isset($_GET['token']))
        {
            send_configuration_direct($_GET['token']);
        }
    }

    /**
     * @param string $token
     * @throws Exception
     */
    function send_configuration_direct(string $token)
    {
        DynamicalWeb::loadLibrary('OpenBlu', 'OpenBlu', 'OpenBlu.php');
        DynamicalWeb::loadLibrary('sws', 'sws', 'sws.php');

        // Verify the token
        $sws = new sws();
        $Cookie = $sws->WebManager()->getCookie('web_session');

        if(hash('sha256', $Cookie->Data['download_token']) !== hash('sha256', $token))
        {
            header('Location: /');
            exit();
        }

        // Gets the selected VPN
        $OpenBlu = new OpenBlu();

        try
        {
            $OpenBlu->getVPNManager()->getVPN(VPN::byPublicID, $Cookie->Data['download_target']);
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


    }