<?php

    use DynamicalWeb\DynamicalWeb;
    use DynamicalWeb\Runtime;
    use IntellivoidAccounts\Exceptions\ConfigurationNotFoundException;
    use IntellivoidAccounts\Exceptions\DatabaseException;
    use IntellivoidAccounts\Exceptions\InvalidSearchMethodException;
    use IntellivoidAccounts\IntellivoidAccounts;
    use IntellivoidAccounts\Utilities\Validate;

    Runtime::import('IntellivoidAccounts');

    if($_SERVER['REQUEST_METHOD'] == 'POST')
    {
        try
        {
            RegisterAccount();
        }
        catch (Exception $e)
        {
            header('Location: register?callback=106');
            exit();
        }
    }

    /**
     * Determines the proper redirect location
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
                            return '/register?redirect=purchase_plan&type=free&';
                            break;

                        case 'basic':
                            return '/register?redirect=purchase_plan&type=basic&';
                            break;

                        case 'enterprise':
                            return '/register?redirect=purchase_plan&type=enterprise&';
                            break;
                    }
                }
            }

            if($_GET['redirect'] == 'add_balance')
            {
                return '/register?redirect=add_balance&';
            }
        }

        return '/register?';
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

            if(isset($_GET['redirect']) == 'add_balance')
            {
                return '/add_balance';
            }
        }

        return '/';
    }

    /**
     * @throws ConfigurationNotFoundException
     * @throws DatabaseException
     * @throws InvalidSearchMethodException
     * @throws Exception
     */
    function RegisterAccount()
    {
        if(verify_recaptcha() == false)
        {
            header('Location: ' . getRedirectLocation() . 'callback=108');
            exit();
        }

        if(isset($_POST['username']) == false)
        {
            header('Location: ' . getRedirectLocation() . 'callback=100');
            exit();
        }

        if(isset($_POST['email']) == false)
        {
            header('Location: ' . getRedirectLocation() . 'callback=100');
            exit();
        }

        if(isset($_POST['password']) == false)
        {
            header('Location: ' . getRedirectLocation() . 'callback=100');
            exit();
        }

        if(Validate::username($_POST['username']) == false)
        {
            header('Location: ' . getRedirectLocation() . 'callback=101');
            exit();
        }

        if(Validate::email($_POST['email']) == false)
        {
            header('Location: ' . getRedirectLocation() . 'callback=102');
            exit();
        }

        if(Validate::password($_POST['password']) == false)
        {
            header('Location: ' . getRedirectLocation() . 'callback=103');
            exit();
        }

        if(isset(DynamicalWeb::$globalObjects['intellivoid_accounts']) == false)
        {
            /** @var IntellivoidAccounts $IntellivoidAccounts */
            $IntellivoidAccounts = DynamicalWeb::setMemoryObject('intellivoid_accounts', new IntellivoidAccounts());
        }
        else
        {
            /** @var IntellivoidAccounts $IntellivoidAccounts */
            $IntellivoidAccounts = DynamicalWeb::getMemoryObject('intellivoid_accounts');
        }
        
        if($IntellivoidAccounts->getAccountManager()->usernameExists($_POST['username']) == true)
        {
            header('Location: ' . getRedirectLocation() . 'callback=104');
            exit();
        }

        if($IntellivoidAccounts->getAccountManager()->emailExists($_POST['email']) == true)
        {
            header('Location: ' . getRedirectLocation() . 'callback=105');
            exit();
        }

        try
        {
            $IntellivoidAccounts->getAccountManager()->registerAccount($_POST['username'], $_POST['email'], $_POST['password']);
            header('Location: ' . getSuccessLocation());
            exit();
        }
        catch(Exception $exception)
        {
            header('Location: ' . getRedirectLocation() . 'callback=106');
            exit();
        }
    }