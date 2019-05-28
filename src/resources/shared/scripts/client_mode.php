<?php

    use DynamicalWeb\DynamicalWeb;
use DynamicalWeb\Runtime;
use OpenBlu\Abstracts\SearchMethods\ClientSearchMethod;
    use OpenBlu\Exceptions\ClientNotFoundException;
    use OpenBlu\Exceptions\ConfigurationNotFoundException;
    use OpenBlu\Exceptions\DatabaseException;
    use OpenBlu\Exceptions\InvalidClientPropertyException;
    use OpenBlu\Exceptions\InvalidSearchMethodException;
    use OpenBlu\Objects\Client;
    use OpenBlu\OpenBlu;
    use sws\sws;

    function jsonResponse(array $data, int $status_code = 200)
    {
        header('Content-Type: application/json');
        header('Status: ' . $status_code);
        print(json_encode($data));
        exit();
    }

    function checkParameter(string $name): string
    {
        if(isset($_GET[$name]) == false)
        {
            jsonResponse(
                array(
                    'operation_success' => false,
                    'error_code' => 'MISSING_PARAMETER',
                    'parameter_name' => $name
                ),
                400
            );
        }

        return $_GET[$name];
    }

    function getParameters(): array
    {
        $client = checkParameter('client');
        $clientVersion = checkParameter('client_version');
        $clientUid = checkParameter('client_uid');
        $osName = checkParameter('os_name');
        $osVersion = checkParameter('os_version');

        return array(
            'client' => $client,
            'client_version' => $clientVersion,
            'client_uid' => $clientUid,
            'os_name' => $osName,
            'os_version' => $osVersion
        );
    }

    /**
     * Checks parameters and initializes client mode
     *
     * @throws ConfigurationNotFoundException
     * @throws DatabaseException
     * @throws InvalidSearchMethodException
     * @throws ClientNotFoundException
     */
    function start_client_mode()
    {
        $parameters = getParameters();

        switch($parameters['client'])
        {
            case 'win32_desktop':
                break;

            default:
                jsonResponse(
                    array(
                        'operation_success' => false,
                        'error_code' => 'UNSUPPORTED_CLIENT'
                    ),
                    400
                );
                break;
        }

        Runtime::import('OpenBlu');
        Runtime::import('SecuredWebSessions');

        $OpenBlu = new OpenBlu();
        $Client = new Client();

        $ip = null;

        if(!empty($_SERVER['HTTP_CLIENT_IP']))
        {
            //ip from share internet
            $ip = $_SERVER['HTTP_CLIENT_IP'];
        }
        elseif(!empty($_SERVER['HTTP_X_FORWARDED_FOR']))
        {
            //ip pass from proxy
            $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
        }
        else
        {
            $ip = $_SERVER['REMOTE_ADDR'];
        }

        if($OpenBlu->getClientManager()->clientUidExists($parameters['client_uid']) == false)
        {
            $Client->ClientName = $parameters['client'];
            $Client->ClientVersion = $parameters['client_version'];
            $Client->ClientUid = $parameters['client_uid'];
            $Client->osName = $parameters['os_name'];
            $Client->osVersion = $parameters['os_version'];
            $Client->ipAddress = $ip;

            try
            {
                $Client = $OpenBlu->getClientManager()->registerClient($Client);
            }
            catch(InvalidClientPropertyException $invalidClientPropertyException)
            {
                jsonResponse(
                    array(
                        'operation_success' => false,
                        'error_code' => 'INVALID_CLIENT_PARAMETERS'
                    ),
                    400
                );
            }
            catch(Exception $exception)
            {
                jsonResponse(
                    array(
                        'operation_success' => false,
                        'error_code' => 'INTERNAL_SERVER_ERROR',
                        'exception_code' => $exception->getCode()
                    ),
                    500
                );
            }
        }
        else
        {
            $Client = $OpenBlu->getClientManager()->getClient(ClientSearchMethod::byClientUid, $parameters['client_uid']);

            $Client->ipAddress = $ip;
            $Client->LastConnectedTimestamp = time();
            $Client->ClientName = $parameters['client'];
            $Client->ClientVersion = $parameters['client_version'];
            $Client->osName = $parameters['os_name'];
            $Client->osVersion = $parameters['os_version'];

            $OpenBlu->getClientManager()->updateClient($Client);
        }

        $sws = new sws();
        $Cookie = null;

        if($sws->WebManager()->isCookieValid('web_session') == false)
        {
            $Cookie = $sws->CookieManager()->newCookie('web_session', 86400, false);

            $Cookie->Data = array(
                'session_active' => false,
                'account_pubid' => null,
                'account_id' => null,
                'account_email' => null,
                'account_username' => null,
                'downloads' => 0,
                'cache' => array(),
                'cache_refresh' => 0,

                // Client Mode Properties
                'client_mode_enabled' => false,
                'client_uid' => null,
                'client_name' => null,
                'client_version' => null,
                'client_authorized' => false,
                'client_account_id' => 0,
                'client_auth_expires' => 0
            );

            $sws->CookieManager()->updateCookie($Cookie);
            $sws->WebManager()->setCookie($Cookie);

            if($Cookie->Name == null)
            {
                print('There was an issue with the security check, Please refresh the page');
                exit();
            }

        }
        else
        {
            $Cookie = $sws->WebManager()->getCookie('web_session');
        }

        $Cookie->Data['client_mode_enabled'] = true;
        $Cookie->Data['client_uid'] = $Client->ClientUid;
        $Cookie->Data['client_name'] = $Client->ClientName;
        $Cookie->Data['client_version'] = $Client->ClientVersion;

        if($Client->isAuthorized() == true)
        {
            $Cookie->Data['client_authorized'] = true;
            $Cookie->Data['client_account_id'] = $Client->AccountID;
            $Cookie->Data['client_auth_expires'] = $Client->AuthExpires;
        }
        else
        {
            $Cookie->Data['client_authorized'] = false;
            $Cookie->Data['client_auth_expires'] = 0;
        }

        $sws->CookieManager()->updateCookie($Cookie);
        header('Location: /');
        exit();
    }

    if(isset($_GET['mode']))
    {
        if($_GET['mode'] == 'client')
        {
            try
            {
                start_client_mode();
            }
            catch(Exception $exception)
            {
                jsonResponse(
                    array(
                        'operation_success' => false,
                        'message' => 'Error while trying to start client mode',
                        'error_code' => 'INTERNAL_SERVER_ERROR',
                        'exception_code' => $exception->getCode()
                    ),
                    500
                );
            }
        }
    }