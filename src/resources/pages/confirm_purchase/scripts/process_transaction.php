<?php

    use DynamicalWeb\DynamicalWeb;
    use DynamicalWeb\Runtime;
    use IntellivoidAccounts\Abstracts\AccountStatus;
    use IntellivoidAccounts\Abstracts\SearchMethods\AccountSearchMethod;
    use IntellivoidAccounts\Abstracts\TransactionType;
    use IntellivoidAccounts\Exceptions\InsufficientFundsException;
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
        $IntellivoidAccounts->getTransactionRecordManager()->createTransaction(
            $Account->ID, -PLAN_PRICE_C, 'Intellivoid',
            TransactionType::SubscriptionPayment
        );
    }
    catch(InsufficientFundsException $insufficientFundsException)
    {
        returnCallback(101);
    }
    catch(Exception $exception)
    {
        header('Location: /500');
        exit();
    }

    try
    {
        if(PROMOTION_SET == true)
        {
            $PlanDetails = api_prices_get_basic(PROMOTION_CODE);
            if($PlanDetails->IsAffiliated == true)
            {
                $AffiliationAccount = $IntellivoidAccounts->getAccountManager()->getAccount(
                    AccountSearchMethod::byUsername, $PlanDetails->AffiliationUsername
                );

                $IntellivoidAccounts->getTransactionRecordManager()->createTransaction(
                    $AffiliationAccount->ID, $PlanDetails->AffiliationShare, 'Intellivoid',
                    TransactionType::Payment
                );
            }

        }
    }
    catch(Exception $exception)
    {
        header('Location: /500');
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