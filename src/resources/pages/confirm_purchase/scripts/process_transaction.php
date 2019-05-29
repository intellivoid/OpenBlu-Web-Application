<?php

    use DynamicalWeb\DynamicalWeb;
    use DynamicalWeb\Runtime;
    use IntellivoidAccounts\Abstracts\AccountStatus;
    use IntellivoidAccounts\Abstracts\SearchMethods\AccountSearchMethod;
    use IntellivoidAccounts\IntellivoidAccounts;
    use OpenBlu\Abstracts\APIPlan;
    use OpenBlu\OpenBlu;
    use sws\sws;

    try
    {
        Runtime::import('OpenBlu');
        Runtime::import('IntellivoidAccounts');
    }
    catch(Exception $exception)
    {
        header('Location: /500');
    }

    function returnCallback(int $callbackCode)
    {
        switch($_GET['plan'])
        {
            case 'free':
                if(PROMOTION_SET == false)
                {
                    header('Location: /confirm_purchase?plan=free&callback=' , $callbackCode);
                }
                else
                {
                    header('Location: /confirm_purchase?plan=free&callback=' . $callbackCode . '&promotion_code=' . PROMOTION_CODE);
                }

                exit();

            case 'basic':
                if(PROMOTION_SET == false)
                {
                    header('Location: /confirm_purchase?plan=basic&callback=' . $callbackCode);
                }
                else
                {
                    header('Location: /confirm_purchase?plan=basic&callback=' . $callbackCode . '&promotion_code=' . PROMOTION_CODE);
                }
                exit();

            case 'enterprise':
                if(PROMOTION_SET == false)
                {
                    header('Location: /confirm_purchase?plan=enterprise&callback=' . $callbackCode);
                }
                else
                {
                    header('Location: /confirm_purchase?plan=enterprise&callback=' . $callbackCode . '&promotion_code=' . PROMOTION_CODE);
                }
                exit();

            default:
                header('Location: /api');
                exit();
        }
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

    /** @noinspection PhpUnhandledExceptionInspection */
    $Account = $IntellivoidAccounts->getAccountManager()->getAccount(AccountSearchMethod::byId, WEB_ACCOUNT_ID);

    // Check if the plan costs anything
    if(PLAN_PRICE_C > 0)
    {
        // Check if the account has sufficient funds
        if($Account->Configuration->Balance < PLAN_PRICE_C)
        {
            returnCallback(101);
        }
    }

    // Check if the account si active and available for making purchases
    if($Account->Status !== AccountStatus::Active)
    {
        returnCallback(102);
    }

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

    $BillingCycle = 0;
    if(PLAN_BILLING_CYCLE_C == 'MONTHLY')
    {
        $BillingCycle = 86400;
    }
    else
    {
        $BillingCycle = 31536000;
    }

    $PlanType = 'Unknown';
    switch($_GET['plan'])
    {
        case 'free':
            $PlanType = APIPLan::Free;
            break;

        case 'basic':
            $PlanType = APIPlan::Basic;
            break;

        case 'enterprise':
            $PlanType = APIPlan::Enterprise;
            break;

        default:
            header('Location: /');
            exit();
    }

    try
    {
        $Plan = $OpenBlu->getPlanManager()->startPlan(
            $Account->ID,
            $PlanType,
            PLAN_CALLS_MONTHLY_C,
            $BillingCycle,
            PLAN_PRICE_C,
            PROMOTION_CODE
        );
    }
    catch(Exception $exception)
    {
        header('Location: /500');
        exit();
    }

    $Account->Configuration->Balance -= PLAN_PRICE_C;
    /** @noinspection PhpUnhandledExceptionInspection */
    $IntellivoidAccounts->getAccountManager()->updateAccount($Account);

    /** @var sws $sws */
    $sws = DynamicalWeb::getMemoryObject('sws');
    $Cookie = $sws->WebManager()->getCookie('web_session');

    // Force refresh cache
    if(isset($Cookie->Data['cache_refresh']) == true)
    {
        $Cookie->Data['cache_refresh'] = 0;
    }

    $sws->CookieManager()->updateCookie($Cookie);
    $sws->WebManager()->setCookie($Cookie);

    header('Location: /api');
    exit();