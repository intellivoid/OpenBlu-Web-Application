<?php

    use DynamicalWeb\DynamicalWeb;
use DynamicalWeb\Page;
use DynamicalWeb\Runtime;
    use IntellivoidAccounts\Abstracts\SearchMethods\AccountSearchMethod;
    use IntellivoidAccounts\IntellivoidAccounts;
use OpenBlu\Abstracts\SearchMethods\ClientSearchMethod;
use OpenBlu\Abstracts\SearchMethods\PlanSearchMethod;
    use OpenBlu\OpenBlu;
use sws\Objects\Cookie;
use sws\sws;

    Runtime::import('OpenBlu');
    $sws = DynamicalWeb::getMemoryObject('sws');

    if($sws->WebManager()->isCookieValid('web_session') == true)
    {

        /** @var Cookie $Cookie */
        $Cookie = DynamicalWeb::getMemoryObject('(cookie)web_session');

        if(time() > $Cookie->Data['cache_refresh'])
        {
            // No need to set these values to MMS since they will be used once
            $OpenBlu = new OpenBlu();

            if(WEB_CLIENT_MODE_ENABLED == true)
            {
                try
                {
                    $Client = $OpenBlu->getClientManager()->getClient(ClientSearchMethod::byClientUid, CLIENT_UID);
                }
                catch(Exception $exception)
                {
                    Page::staticResponse(
                        "OpenBlu - Error",
                        "Client Error",
                        "There was an issue while trying to verify your client, please make restart your client."
                    );
                    exit();
                }

                if($Client->Blocked == true)
                {
                    Page::staticResponse(
                        "OpenBlu - Error",
                        "Client Blocked",
                        "Your client has been blocked by the System Administrator, please contact support if needed"
                    );
                    exit();
                }
            }

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

            if(isset($Cookie->Data['cache']['ui']['sidebar_expanded']) == false)
            {
                $Cookie->Data['cache']['ui']['sidebar_expanded'] = true;
            }

            if(defined('WEB_SESSION_ACTIVE') == true)
            {
                if(WEB_SESSION_ACTIVE == true)
                {
                    //if($OpenBlu->getPlanManager()->accountIdExists(WEB_ACCOUNT_ID) == true)
                    //{
                    //    $PlanObject = $OpenBlu->getPlanManager()->getPlan(PlanSearchMethod::byAccountId, $AccountObject->ID);
                    //    if($PlanObject->PlanStarted == true)
                    //    {
                    //        $Cookie->Data['cache']['subscription_active'] = true;
                    //        $Cookie->Data['cache']['subscription_type'] = $PlanObject->PlanType;
                    //        $Cookie->Data['cache']['subscription_billing_cycle'] = $PlanObject->BillingCycle;
                    //        $Cookie->Data['cache']['subscription_next_billing_cycle'] = $PlanObject->NextBillingCycle;
                    //        $Cookie->Data['cache']['subscription_plan_id'] = $PlanObject->Id;
                    //        $Cookie->Data['cache']['subscription_access_key_id'] = $PlanObject->AccessKeyId;
                    //        $Cookie->Data['cache']['subscription_monthly_calls'] = $PlanObject->MonthlyCalls;
                    //    }
                    //}

                }
            }

            $Cookie->Data['cache_refresh'] = time() + 30;

            $sws->CookieManager()->updateCookie($Cookie);
            DynamicalWeb::setMemoryObject('(cookie)web_session', $Cookie);
        }

        define('CACHE_TOTAL_SERVERS', $Cookie->Data['cache']['total_servers'], false);
        define('CACHE_TOTAL_SESSIONS', $Cookie->Data['cache']['total_sessions'], false);
        define('CACHE_CURRENT_SESSIONS', $Cookie->Data['cache']['current_sessions'], false);
        //define('CACHE_SUBSCRIPTION_ACTIVE', $Cookie->Data['cache']['subscription_active'], false);
        //define('CACHE_SUBSCRIPTION_TYPE', $Cookie->Data['cache']['subscription_type'], false);
        //define('CACHE_SUBSCRIPTION_BILLING_CYCLE', $Cookie->Data['cache']['subscription_billing_cycle'], false);
        //define('CACHE_SUBSCRIPTION_NEXT_BILLING_CYCLE', $Cookie->Data['cache']['subscription_next_billing_cycle'], false);
        //define('CACHE_SUBSCRIPTION_PLAN_ID', $Cookie->Data['cache']['subscription_plan_id'], false);
        //define('CACHE_SUBSCRIPTION_ACCESS_KEY_ID', $Cookie->Data['cache']['subscription_access_key_id'], false);
        //define('CACHE_SUBSCRIPTION_MONTHLY_CALLS', $Cookie->Data['cache']['subscription_monthly_calls'], false);
        define('CACHE_UI_SIDEBAR_EXPANDED', $Cookie->Data['cache']['ui']['sidebar_expanded'], false);

        if($Cookie->Data['cache']['ui']['sidebar_expanded'] == false)
        {
            define('SIDEBAR_STATE', ' class="sidebar-icon-only"', false);
            define('SIDEBAR_STATE_MINI', '', false);
        }
        else
        {
            define('SIDEBAR_STATE', '', false);
            define('SIDEBAR_STATE_MINI', ' active', false);
        }
    }