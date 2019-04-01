<?php

    if($_SERVER['REQUEST_METHOD'] == 'POST')
    {
        LoginAccount();
    }

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


    function LoginAccount()
    {
        if(isset($_POST['username_email']) == false)
        {
            header('Location: login?callback=100');
            exit();
        }

        if(isset($_POST['password']) == false)
        {
            header('Location: login?callback=100');
            exit();
        }

        if(verify_recaptcha() == false)
        {
            header('Location: login?callback=104');
            exit();
        }

        \DynamicalWeb\DynamicalWeb::loadLibrary('IntellivoidAccounts', 'IntellivoidAccounts', 'IntellivoidAccounts.php');

        if(\IntellivoidAccounts\Utilities\Validate::username($_POST['username_email']) == false)
        {
            if(\IntellivoidAccounts\Utilities\Validate::email($_POST['username_email']) == false)
            {
                header('Location: login?callback=101');
                exit();
            }
        }

        if(\IntellivoidAccounts\Utilities\Validate::password($_POST['password']) == false)
        {
            header('Location: login?callback=101');
            exit();
        }

        $IntellivoidAccounts = new \IntellivoidAccounts\IntellivoidAccounts();

        try
        {
            $IntellivoidAccounts->getAccountManager()->checkLogin($_POST['username_email'], $_POST['password']);

            $Account = null;
            if(\IntellivoidAccounts\Utilities\Validate::email($_POST['username_email']) == true)
            {
                $Account = $IntellivoidAccounts->getAccountManager()->getAccount(
                    \IntellivoidAccounts\Abstracts\SearchMethods\AccountSearchMethod::byEmail, $_POST['username_email']
                );
            }
            else
            {
                $Account = $IntellivoidAccounts->getAccountManager()->getAccount(
                    \IntellivoidAccounts\Abstracts\SearchMethods\AccountSearchMethod::byUsername, $_POST['username_email']
                );
            }

            $IntellivoidAccounts->getLoginRecordManager()->createLoginRecord(
                $Account->ID, getClientIP(), \IntellivoidAccounts\Abstracts\LoginStatus::Successful, 'OpenBlu WebApplication'
            );

            $sws = new \sws\sws();

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
        catch(\IntellivoidAccounts\Exceptions\IncorrectLoginDetailsException $incorrectLoginDetailsException)
        {
            try
            {
                $Account = null;

                if(\IntellivoidAccounts\Utilities\Validate::email($_POST['username_email']))
                {
                    $Account = $IntellivoidAccounts->getAccountManager()->getAccount(
                        \IntellivoidAccounts\Abstracts\SearchMethods\AccountSearchMethod::byEmail, $_POST['username_email']
                    );
                }
                else
                {
                    $Account = $IntellivoidAccounts->getAccountManager()->getAccount(
                        \IntellivoidAccounts\Abstracts\SearchMethods\AccountSearchMethod::byUsername, $_POST['username_email']
                    );
                }

                $IntellivoidAccounts->getLoginRecordManager()->createLoginRecord(
                    $Account->ID, getClientIP(), \IntellivoidAccounts\Abstracts\LoginStatus::IncorrectCredentials, 'OpenBlu WebApplication'
                );
            }
            catch(\IntellivoidAccounts\Exceptions\AccountNotFoundException $accountNotFoundException)
            {
                // Ignore this exception
            }

            header('Location: login?callback=101');
            exit();
        }
        catch(\IntellivoidAccounts\Exceptions\AccountSuspendedException $accountSuspendedException)
        {
            header('Location: login?callback=102');
            exit();
        }
        catch(Exception $exception)
        {
            var_dump($exception);
            die();
            header('Location: login?callback=103');
            exit();
        }
    }