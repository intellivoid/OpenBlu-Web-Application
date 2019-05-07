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
    $PlanObject = null;
    $PlanExists = false;

    if($OpenBlu->getPlanManager()->accountIdExists($Account->ID) == true)
    {
        $PlanObject = $OpenBlu->getPlanManager()->getPlan(PlanSearchMethod::byAccountId, $Account->ID);

        if($PlanObject->PlanStarted == true)
        {
            returnCallback(103);
        }

        $PlanExists = true;
    }
    else
    {
        $PlanObject = new Plan();
    }


    if(PLAN_BILLING_CYCLE_C == 'MONTHLY')
    {
        $PlanObject->BillingCycle = 86400;
    }
    else
    {
        $PlanObject->BillingCycle = 31536000;
    }

    switch($_GET['plan'])
    {
        case 'free':
            $PlanObject->PlanType = APIPLan::Free;
            break;

        case 'basic':
            $PlanObject->PlanType = APIPlan::Basic;
            break;

        case 'enterprise':
            $PlanObject->PlanType = APIPlan::Enterprise;
            break;

        default:
            header('Location: /');
            exit();
    }

    $PlanObject->PricePerCycle = PLAN_PRICE_C;
    $PlanObject->MonthlyCalls = PLAN_CALLS_MONTHLY_C;
    $PlanObject->PromotionCode = PROMOTION_CODE;
    $PlanObject->AccountId = $Account->ID;
    $PlanObject->PlanStarted = true;
    $PlanObject->PaymentRequired = false;

    /** @noinspection PhpUnhandledExceptionInspection */
    $OpenBlu->getPlanManager()->createPlan($PlanObject);

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