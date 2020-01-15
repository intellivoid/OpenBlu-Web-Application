<?php

    use COASniffle\COASniffle;
    use COASniffle\Exceptions\BadResponseException;
    use COASniffle\Exceptions\CoaAuthenticationException;
    use COASniffle\Exceptions\RequestFailedException;
    use COASniffle\Exceptions\UnsupportedAuthMethodException;
    use DynamicalWeb\Actions;
    use DynamicalWeb\DynamicalWeb;
    use sws\sws;

    if(WEB_SESSION_ACTIVE == false)
    {
        if(isset($_GET['access_token']))
        {
            process_coa_authentication();
        }
    }

    function process_coa_authentication()
    {
        /** @var COASniffle $COASniffle */
        $COASniffle = DynamicalWeb::getMemoryObject('coasniffle');

        try
        {
            $UserInformation = $COASniffle->getCOA()->getUser($_GET['access_token']);
        }
        catch (BadResponseException $e)
        {
            Actions::redirect(DynamicalWeb::getRoute(
                'index', array('callback' => '101')
            ));
        }
        catch (CoaAuthenticationException $e)
        {
            Actions::redirect(DynamicalWeb::getRoute(
                'index', array('callback' => '102', 'coa_error' => (string)$e->getCode())
            ));
        }
        catch (RequestFailedException $e)
        {
            Actions::redirect(DynamicalWeb::getRoute(
                'index', array('callback' => '103')
            ));
        }
        catch (UnsupportedAuthMethodException $e)
        {
            Actions::redirect(DynamicalWeb::getRoute(
                'index', array('callback' => '104')
            ));
        }
        catch(Exception $e)
        {
            Actions::redirect(DynamicalWeb::getRoute(
                'index', array('callback' => '100')
            ));
        }

        /** @var sws $sws */
        $sws = DynamicalWeb::getMemoryObject('sws');

        $Cookie = $sws->WebManager()->getCookie('web_session');
        $Cookie->Data['session_active'] = true;
        $Cookie->Data['account_pubid'] = $UserInformation->PublicID;
        $Cookie->Data['account_id'] = $UserInformation->Tag;
        $Cookie->Data['account_username'] = $UserInformation->Username;
        $Cookie->Data['access_token'] = $_GET['access_token'];

        // Force refresh cache
        if(isset($Cookie->Data['cache_refresh']) == true)
        {
            $Cookie->Data['cache_refresh'] = 0;
        }

        $sws->CookieManager()->updateCookie($Cookie);
        $sws->WebManager()->setCookie($Cookie);

        Actions::redirect(DynamicalWeb::getRoute(
            'index', array('callback' => '105')
        ));
    }