<?php

    use DynamicalWeb\DynamicalWeb;
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
    use sws\sws;

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
        }

        return '/login?';
    }


    /**
     * @throws ConfigurationNotFoundException
     * @throws DatabaseException
     * @throws InvalidIpException
     * @throws InvalidLoginStatusException
     * @throws InvalidSearchMethodException
     * @throws Exception
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

            $sws->CookieManager()->updateCookie($Cookie);
            $sws->WebManager()->setCookie($Cookie);

            header('Location: /');
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