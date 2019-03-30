<?php
    if($_SERVER['REQUEST_METHOD'] == 'POST')
    {
        RegisterAccount();
    }

    function RegisterAccount()
    {
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

        \DynamicalWeb\DynamicalWeb::loadLibrary('IntellivoidAccounts', 'IntellivoidAccounts', 'IntellivoidAccounts.php');
        $IntellivoidAccounts = new \IntellivoidAccounts\IntellivoidAccounts();
        
        if($IntellivoidAccounts->)
    }
