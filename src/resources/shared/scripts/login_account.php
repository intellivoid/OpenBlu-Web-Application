<?php

    use DynamicalWeb\DynamicalWeb;
    use IntellivoidAccounts\Abstracts\AccountStatus;
    use IntellivoidAccounts\Abstracts\LoginStatus;
    use IntellivoidAccounts\Abstracts\SearchMethods\AccountSearchMethod;
    use IntellivoidAccounts\Exceptions\AccountNotFoundException;
    use IntellivoidAccounts\Exceptions\AccountSuspendedException;
    use IntellivoidAccounts\Exceptions\ConfigurationNotFoundException;
    use IntellivoidAccounts\Exceptions\DatabaseException;
    use IntellivoidAccounts\Exceptions\IncorrectLoginDetailsException;
    use IntellivoidAccounts\Exceptions\InvalidIpException;
    use IntellivoidAccounts\Exceptions\InvalidLoginStatusException;
    use IntellivoidAccounts\Exceptions\InvalidSearchMethodException;
    use IntellivoidAccounts\IntellivoidAccounts;
    use IntellivoidAccounts\Utilities\Validate;
    use OpenBlu\Abstracts\SearchMethods\ClientSearchMethod;
    use OpenBlu\Exceptions\ClientNotFoundException;
    use OpenBlu\OpenBlu;
    use sws\sws;

    if(CLIENT_MODE_ENABLED == true)
    {
        if(CLIENT_AUTHORIZED == true)
        {
            AutoLogin();
        }
    }

    if($_SERVER['REQUEST_METHOD'] == 'POST')
    {
        try
        {
            LoginAccount();
        }
        catch(Exception $e)
        {
            header('Location: login?callback=103');
            exit();
        }
    }

    /**
     * @return mixed
     */
    function getClientIP()
    {
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

        return $ip;
    }

    /**
     * Determines the proper redirect location based of the given parameters
     *
     * @return string
     */
    function getRedirectLocation()
    {
        if(isset($_GET['redirect']))
        {
            if($_GET['redirect'] == 'purchase_plan')
            {
                if(isset($_GET['type']))
                {
                    switch($_GET['type'])
                    {
                        case 'free':
                            return '/login?redirect=purchase_plan&type=free&';
                            break;

                        case 'basic':
                            return '/login?redirect=purchase_plan&type=basic&';
                            break;

                        case 'enterprise':
                            return '/login?redirect=purchase_plan&type=enterprise&';
                            break;
                    }
                }
            }

            if($_GET['redirect'] == 'add_balance')
            {
                return '/login?redirect=add_balance&';
            }
        }

        return '/login?';
    }


    /**
     * Returns the location to redirect the user to on success
     *
     * @return string
     */
    function getSuccessLocation()
    {
        if(isset($_GET['redirect']))
        {
            if($_GET['redirect'] == 'purchase_plan')
            {
                if(isset($_GET['type']))
                {
                    switch($_GET['type'])
                    {
                        case 'free':
                            return '/confirm_purchase?plan=free';
                            break;

                        case 'basic':
                            return '/confirm_purchase?plan=basic';
                            break;

                        case 'enterprise':
                            return '/confirm_purchase?plan=enterprise';
                            break;
                    }
                }
            }

            if($_GET['redirect'] == 'add_balance')
            {
                return '/add_balance';
            }
        }

        return '/';
    }

    /**
     * @throws ConfigurationNotFoundException
     * @throws DatabaseException
     * @throws InvalidIpException
     * @throws InvalidLoginStatusException
     * @throws InvalidSearchMethodException
     */
    function LoginAccount()
    {
        if(isset($_POST['username_email']) == false)
        {
            header('Location: ' . getRedirectLocation() . 'callback=100');
            exit();
        }

        if(isset($_POST['password']) == false)
        {
            header('Location: ' . getRedirectLocation() . 'callback=100');
            exit();
        }

        if(verify_recaptcha() == false)
        {
            header('Location: ' . getRedirectLocation() . 'callback=104');
            exit();
        }

        DynamicalWeb::loadLibrary('IntellivoidAccounts', 'IntellivoidAccounts', 'IntellivoidAccounts.php');

        if(Validate::username($_POST['username_email']) == false)
        {
            if(Validate::email($_POST['username_email']) == false)
            {
                header('Location: ' . getRedirectLocation() . 'callback=101');
                exit();
            }
        }

        if(Validate::password($_POST['password']) == false)
        {
            header('Location: ' . getRedirectLocation() . 'callback=101');
            exit();
        }

        $IntellivoidAccounts = new IntellivoidAccounts();

        try
        {
            $IntellivoidAccounts->getAccountManager()->checkLogin($_POST['username_email'], $_POST['password']);

            $Account = null;
            if(Validate::email($_POST['username_email']) == true)
            {
                $Account = $IntellivoidAccounts->getAccountManager()->getAccount(
                    AccountSearchMethod::byEmail, $_POST['username_email']
                );
            }
            else
            {
                $Account = $IntellivoidAccounts->getAccountManager()->getAccount(
                    AccountSearchMethod::byUsername, $_POST['username_email']
                );
            }

            $IntellivoidAccounts->getLoginRecordManager()->createLoginRecord(
                $Account->ID, getClientIP(), LoginStatus::Successful, 'OpenBlu WebApplication'
            );

            $sws = new sws();

            $Cookie = $sws->WebManager()->getCookie('web_session');
            $Cookie->Data['session_active'] = true;
            $Cookie->Data['account_pubid'] = $Account->PublicID;
            $Cookie->Data['account_id'] = $Account->ID;
            $Cookie->Data['account_email'] = $Account->Email;
            $Cookie->Data['account_username'] = $Account->Username;

            // If client mode is enabled
            if($Cookie->Data['client_mode_enabled'] == true)
            {
                DynamicalWeb::loadLibrary('OpenBlu', 'OpenBlu', 'OpenBlu.php');
                $OpenBlu = new OpenBlu();

                $Client = $OpenBlu->getClientManager()->getClient(ClientSearchMethod::byClientUid, $Cookie->Data['client_uid']);
                $Client->AccountID = $Account->ID;
                $Client->AuthExpires = time() + 43200;

                $OpenBlu->getClientManager()->updateClient($Client);

                $Cookie->Data['client_authorized'] = true;
                $Cookie->Data['client_account_id'] = $Client->AccountID;
                $Cookie->Data['client_auth_expires'] = $Client->AuthExpires;

            }

            // Force refresh cache
            if(isset($Cookie->Data['cache_refresh']) == true)
            {
                $Cookie->Data['cache_refresh'] = 0;
            }

            $sws->CookieManager()->updateCookie($Cookie);
            $sws->WebManager()->setCookie($Cookie);

            header('Location: ' . getSuccessLocation());
            exit();
        }
        catch(IncorrectLoginDetailsException $incorrectLoginDetailsException)
        {
            try
            {
                $Account = null;

                if(Validate::email($_POST['username_email']))
                {
                    $Account = $IntellivoidAccounts->getAccountManager()->getAccount(
                        AccountSearchMethod::byEmail, $_POST['username_email']
                    );
                }
                else
                {
                    $Account = $IntellivoidAccounts->getAccountManager()->getAccount(
                        AccountSearchMethod::byUsername, $_POST['username_email']
                    );
                }

                $IntellivoidAccounts->getLoginRecordManager()->createLoginRecord(
                    $Account->ID, getClientIP(), LoginStatus::IncorrectCredentials, 'OpenBlu WebApplication'
                );
            }
            catch(AccountNotFoundException $accountNotFoundException)
            {
                // Ignore this exception
            }

            header('Location: ' . getRedirectLocation() . 'callback=101');
            exit();
        }
        catch(AccountSuspendedException $accountSuspendedException)
        {
            header('Location: ' . getRedirectLocation() . 'callback=102');
            exit();
        }
        catch(Exception $exception)
        {
            header('Location: ' . getRedirectLocation() . 'callback=103');
            exit();
        }
    }

    /**
     * @throws ConfigurationNotFoundException
     * @throws ClientNotFoundException
     * @throws \OpenBlu\Exceptions\ConfigurationNotFoundException
     * @throws \OpenBlu\Exceptions\DatabaseException
     * @throws \OpenBlu\Exceptions\InvalidSearchMethodException
     * @throws Exception
     */
    function AutoLogin()
    {
        DynamicalWeb::loadLibrary('IntellivoidAccounts', 'IntellivoidAccounts', 'IntellivoidAccounts.php');
        DynamicalWeb::loadLibrary('OpenBlu', 'OpenBlu', 'OpenBlu.php');

        $IntellivoidAccounts = new IntellivoidAccounts();
        $OpenBlu = new OpenBlu();
        $sws = new sws();

        $Cookie = $sws->WebManager()->getCookie('web_session');
        $Client = $OpenBlu->getClientManager()->getClient(ClientSearchMethod::byClientUid, $Cookie->Data['client_uid']);

        if($Client->isAuthorized() == false)
        {
            $Cookie->Data['client_authorized'] = false;
            $Cookie->Data['client_auth_expires'] = 0;
            $sws->CookieManager()->updateCookie($Cookie);

            header('Location: /login');
            exit();
        }

        $Account = $IntellivoidAccounts->getAccountManager()->getAccount(AccountSearchMethod::byId, $Cookie->Data['client_account_id']);

        switch($Account->Status)
        {
            case AccountStatus::Suspended:
                $Cookie->Data['client_authorized'] = false;
                $Cookie->Data['client_auth_expires'] = 0;
                $sws->CookieManager()->updateCookie($Cookie);

                header('Location: /login?callback=102');
                exit();

            case AccountStatus::VerificationRequired:
                $Cookie->Data['client_authorized'] = false;
                $Cookie->Data['client_auth_expires'] = 0;
                $sws->CookieManager()->updateCookie($Cookie);

                header('Location: /login?callback=103');
                exit();

            default:
                $Cookie->Data['session_active'] = true;
                $Cookie->Data['account_pubid'] = $Account->PublicID;
                $Cookie->Data['account_id'] = $Account->ID;
                $Cookie->Data['account_email'] = $Account->Email;
                $Cookie->Data['account_username'] = $Account->Username;

                // Force refresh cache
                if(isset($Cookie->Data['cache_refresh']) == true)
                {
                    $Cookie->Data['cache_refresh'] = 0;
                }

                $sws->CookieManager()->updateCookie($Cookie);
                $sws->WebManager()->setCookie($Cookie);

                header('Location: /');
                exit();
        }
    }