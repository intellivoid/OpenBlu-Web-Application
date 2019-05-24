<?php

    use DynamicalWeb\DynamicalWeb;
    use IntellivoidAccounts\Abstracts\AccountStatus;
    use IntellivoidAccounts\Abstracts\SearchMethods\AccountSearchMethod;
    use IntellivoidAccounts\IntellivoidAccounts;
    use OpenBlu\Abstracts\APIPlan;
    use OpenBlu\Abstracts\SearchMethods\PlanSearchMethod;
    use OpenBlu\Objects\Plan;
    use OpenBlu\OpenBlu;
    use sws\sws;

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

    /** @noinspection PhpUnhandledExceptionInspection */
    DynamicalWeb::loadLibrary('IntellivoidAccounts', 'IntellivoidAccounts', 'IntellivoidAccounts.php');

    /** @noinspection PhpUnhandledExceptionInspection */
    DynamicalWeb::loadLibrary('OpenBlu', 'OpenBlu', 'OpenBlu.php');

    $IntellivoidAccounts = new IntellivoidAccounts();

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

    $OpenBlu = new OpenBlu();

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

    $Plan = $OpenBlu->getPlanManager()->startPlan(
        $Account->ID,
        $PlanType,
        PLAN_CALLS_MONTHLY_C,
        $BillingCycle,
        PLAN_PRICE_C,
        PROMOTION_CODE
    );

    $Account->Configuration->Balance -= PLAN_PRICE_C;
    /** @noinspection PhpUnhandledExceptionInspection */
    $IntellivoidAccounts->getAccountManager()->updateAccount($Account);

    $sws = new sws();
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