<?php
    if($_SERVER['REQUEST_METHOD'] == 'POST')
    {
        RegisterAccount();
    }

    function RegisterAccount()
    {
        if(verify_recaptcha() == false)
        {
            header('Location: register?callback=108');
            exit();
        }

        \DynamicalWeb\DynamicalWeb::loadLibrary('IntellivoidAccounts', 'IntellivoidAccounts', 'IntellivoidAccounts.php');

        if(isset($_POST['username']) == false)
        {
            header('Location: register?callback=100');
            exit();
        }

        if(isset($_POST['email']) == false)
        {
            header('Location: register?callback=100');
            exit();
        }

        if(isset($_POST['password']) == false)
        {
            header('Location: register?callback=100');
            exit();
        }

        if(\IntellivoidAccounts\Utilities\Validate::username($_POST['username']) == false)
        {
            header('Location: register?callback=101');
            exit();
        }

        if(\IntellivoidAccounts\Utilities\Validate::email($_POST['email']) == false)
        {
            header('Location: register?callback=102');
            exit();
        }

        if(\IntellivoidAccounts\Utilities\Validate::password($_POST['password']) == false)
        {
            header('Location: register?callback=103');
            exit();
        }

        $IntellivoidAccounts = new \IntellivoidAccounts\IntellivoidAccounts();
        
        if($IntellivoidAccounts->getAccountManager()->usernameExists($_POST['username']) == true)
        {
            header('Location: register?callback=104');
            exit();
        }

        if($IntellivoidAccounts->getAccountManager()->emailExists($_POST['email']) == true)
        {
            header('Location: register?callback=105');
            exit();
        }

        try
        {
            $IntellivoidAccounts->getAccountManager()->registerAccount($_POST['username'], $_POST['email'], $_POST['password']);
            header('Location: register?callback=107');
            exit();
        }
        catch(Exception $exception)
        {
            header('Location: register?callback=106');
            exit();
        }
    }
