<?php

    use DynamicalWeb\DynamicalWeb;
    use IntellivoidAccounts\Abstracts\SearchMethods\AccountSearchMethod;
    use IntellivoidAccounts\IntellivoidAccounts;
use OpenBlu\Abstracts\SearchMethods\PlanSearchMethod;
use OpenBlu\OpenBlu;
    use sws\sws;

    try
    {
        DynamicalWeb::loadLibrary('sws', 'sws', 'sws.php');
    }
    catch (Exception $e)
    {
        header('Location: /500');
        exit();
    }

    try
    {
        DynamicalWeb::loadLibrary('OpenBlu', 'OpenBlu', 'OpenBlu.php');
    }
    catch (Exception $e)
    {
        header('Location: /500');
        exit();
    }

    $sws = new sws();

    if($sws->WebManager()->isCookieValid('web_session') == true)
    {

        $Cookie = $sws->WebManager()->getCookie('web_session');

        if(time() > $Cookie->Data['cache_refresh'])
        {
            $OpenBlu = new OpenBlu();

            $Cookie->Data['cache']['total_servers'] = $OpenBlu->getVPNManager()->totalServers();
            $Cookie->Data['cache']['total_sessions'] = $OpenBlu->getVPNManager()->totalSessions();
            $Cookie->Data['cache']['current_sessions'] = $OpenBlu->getVPNManager()->currentSessions();
            $Cookie->Data['cache']['balance_available'] = false;
            $Cookie->Data['cache']['balance_amount'] = 0;
            $Cookie->Data['cache']['subscription_active'] = false;
            $Cookie->Data['cache']['subscription_type'] = 0;
            $Cookie->Data['cache']['subscription_billing_cycle'] = 0;
            $Cookie->Data['cache']['subscription_next_billing_cycle'] = 0;
            $Cookie->Data['cache']['subscription_plan_id'] = 0;
            $Cookie->Data['cache']['subscription_access_key_id'] = 0;
            $Cookie->Data['cache']['subscription_monthly_calls'] = 0;

            if(defined('WEB_SESSION_ACTIVE') == true)
            {
                if(WEB_SESSION_ACTIVE == true)
                {
                    /** @noinspection PhpUnhandledExceptionInspection */
                    DynamicalWeb::loadLibrary('IntellivoidAccounts', 'IntellivoidAccounts', 'IntellivoidAccounts.php');

                    $IntellivoidAccounts = new IntellivoidAccounts();

                    /** @noinspection PhpUnhandledExceptionInspection */
                    $AccountObject = $IntellivoidAccounts->getAccountManager()->getAccount(AccountSearchMethod::byId, WEB_ACCOUNT_ID);

                    $Cookie->Data['cache']['balance_available'] = true;
                    $Cookie->Data['cache']['balance_amount'] = $AccountObject->Configuration->Balance;


                    if($OpenBlu->getPlanManager()->accountIdExists(WEB_ACCOUNT_ID) == true)
                    {
                        $PlanObject = $OpenBlu->getPlanManager()->getPlan(PlanSearchMethod::byAccountId, $AccountObject->ID);

                        if($PlanObject->PlanStarted == true)
                        {
                            $Cookie->Data['cache']['subscription_active'] = true;
                            $Cookie->Data['cache']['subscription_type'] = $PlanObject->PlanType;
                            $Cookie->Data['cache']['subscription_billing_cycle'] = $PlanObject->BillingCycle;
                            $Cookie->Data['cache']['subscription_next_billing_cycle'] = $PlanObject->NextBillingCycle;
                            $Cookie->Data['cache']['subscription_plan_id'] = $PlanObject->Id;
                            $Cookie->Data['cache']['subscription_access_key_id'] = $PlanObject->AccessKeyId;
                            $Cookie->Data['cache']['subscription_monthly_calls'] = $PlanObject->MonthlyCalls;
                        }

                    }

                }
            }

            $Cookie->Data['cache_refresh'] = time() + 30;

            $sws->CookieManager()->updateCookie($Cookie);
        }

        define('CACHE_TOTAL_SERVERS', $Cookie->Data['cache']['total_servers'], false);
        define('CACHE_TOTAL_SESSIONS', $Cookie->Data['cache']['total_sessions'], false);
        define('CACHE_CURRENT_SESSIONS', $Cookie->Data['cache']['current_sessions'], false);
        define('CACHE_BALANCE_AVAILABLE', $Cookie->Data['cache']['balance_available'], false);
        define('CACHE_BALANCE_AMOUNT', $Cookie->Data['cache']['balance_amount'], false);
        define('CACHE_SUBSCRIPTION_ACTIVE', $Cookie->Data['cache']['subscription_active'], false);
        define('CACHE_SUBSCRIPTION_TYPE', $Cookie->Data['cache']['subscription_type'], false);
        define('CACHE_SUBSCRIPTION_BILLING_CYCLE', $Cookie->Data['cache']['subscription_billing_cycle'], false);
        define('CACHE_SUBSCRIPTION_NEXT_BILLING_CYCLE', $Cookie->Data['cache']['subscription_next_billing_cycle'], false);
        define('CACHE_SUBSCRIPTION_PLAN_ID', $Cookie->Data['cache']['subscription_plan_id'], false);
        define('CACHE_SUBSCRIPTION_ACCESS_KEY_ID', $Cookie->Data['cache']['subscription_access_key_id'], false);
        define('CACHE_SUBSCRIPTION_MONTHLY_CALLS', $Cookie->Data['cache']['subscription_monthly_calls'], false);

    }