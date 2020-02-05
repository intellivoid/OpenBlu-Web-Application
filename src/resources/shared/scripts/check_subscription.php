<?php

    use DynamicalWeb\Actions;
    use DynamicalWeb\DynamicalWeb;
    use DynamicalWeb\Runtime;
    use IntellivoidAPI\Abstracts\RateLimitName;
    use IntellivoidAPI\Abstracts\SearchMethods\AccessRecordSearchMethod;
    use IntellivoidAPI\Exceptions\AccessRecordNotFoundException;
    use IntellivoidAPI\IntellivoidAPI;
    use IntellivoidAPI\Objects\AccessRecord;
    use IntellivoidSubscriptionManager\Abstracts\SearchMethods\SubscriptionSearchMethod;
    use IntellivoidSubscriptionManager\Exceptions\DatabaseException;
    use IntellivoidSubscriptionManager\Exceptions\SubscriptionNotFoundException;
    use IntellivoidSubscriptionManager\IntellivoidSubscriptionManager;
    use IntellivoidSubscriptionManager\Objects\Subscription;
    use IntellivoidSubscriptionManager\Objects\SubscriptionPlan;
    use IntellivoidSubscriptionManager\Utilities\Converter;
    use OpenBlu\Abstracts\SearchMethods\UserSubscriptionSearchMethod;
    use OpenBlu\Exceptions\UserSubscriptionRecordNotFoundException;
    use OpenBlu\Objects\UserSubscription;
    use OpenBlu\OpenBlu;
    use sws\sws;

    Runtime::import('OpenBlu');
    Runtime::import('IntellivoidSubscriptionManager');
    Runtime::import('IntellivoidAPI');

    if(WEB_SESSION_ACTIVE)
    {
        if(WEB_SUBSCRIPTION_ACTIVE)
        {
            verify_subscription();
        }
        else
        {
            check_subscription();
        }
    }

    function verify_subscription()
    {
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

        try
        {
            $UserSubscription = $OpenBlu->getUserSubscriptionManager()->getUserSubscription(
                UserSubscriptionSearchMethod::byAccountID, WEB_ACCOUNT_ID
            );
        }
        catch (UserSubscriptionRecordNotFoundException $e)
        {
            remove_subscription();
            Actions::redirect(DynamicalWeb::getRoute('index') . '#pricing');
            return;
        }
        catch(Exception $e)
        {
            Actions::redirect(DynamicalWeb::getRoute('service_error', array(
                'error_type' => 'user_subscription_fetch_failure'
            )));
        }

        if(isset(DynamicalWeb::$globalObjects['intellivoid_subscription_manager']) == false)
        {
            /** @var IntellivoidSubscriptionManager $IntellivoidSubscriptionManager */
            $IntellivoidSubscriptionManager = DynamicalWeb::setMemoryObject('intellivoid_subscription_manager', new IntellivoidSubscriptionManager());
        }
        else
        {
            /** @var IntellivoidSubscriptionManager $IntellivoidSubscriptionManager */
            $IntellivoidSubscriptionManager = DynamicalWeb::getMemoryObject('intellivoid_subscription_manager');
        }

        try
        {
            $IntellivoidSubscriptionManager->getSubscriptionManager()->getSubscription(
                SubscriptionSearchMethod::byId, $UserSubscription->SubscriptionID
            );
        }
        catch (SubscriptionNotFoundException $e)
        {
            remove_subscription();
            Actions::redirect(DynamicalWeb::getRoute('index') . '#pricing');
            return;
        }
        catch(Exception $e)
        {

            var_dump($e);
            die();
            Actions::redirect(DynamicalWeb::getRoute('service_error', array(
                'error_type' => 'user_subscription_fetch_failure'
            )));
        }

        return;
    }

    function check_subscription()
    {
        try
        {
            $ApplicationConfiguration = DynamicalWeb::getConfiguration('coasniffle');
        }
        catch (Exception $e)
        {
            Actions::redirect(DynamicalWeb::getRoute('service_error', array(
                'error_type' => 'configuration_read_error'
            )));
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

        if(isset(DynamicalWeb::$globalObjects['intellivoid_subscription_manager']) == false)
        {
            /** @var IntellivoidSubscriptionManager $IntellivoidSubscriptionManager */
            $IntellivoidSubscriptionManager = DynamicalWeb::setMemoryObject('intellivoid_subscription_manager', new IntellivoidSubscriptionManager());
        }
        else
        {
            /** @var IntellivoidSubscriptionManager $IntellivoidSubscriptionManager */
            $IntellivoidSubscriptionManager = DynamicalWeb::getMemoryObject('intellivoid_subscription_manager');
        }

        $UserSubscription = check_user_subscription($OpenBlu);
        if(is_null($UserSubscription))
        {
            try
            {
                $ActiveSubscription = find_active_subscription($IntellivoidSubscriptionManager, $ApplicationConfiguration);
            }
            catch (Exception $e)
            {
                Actions::redirect(DynamicalWeb::getRoute('service_error', array(
                    'error_type' => 'find_active_subscription_error'
                )));
                return;
            }

            if(is_null($ActiveSubscription))
            {
                return;
            }
            else
            {
                $UserSubscription = register_subscription(
                    $OpenBlu, $ActiveSubscription,
                    $ApplicationConfiguration['APPLICATION_INTERNAL_ID']
                );

                set_subscription($UserSubscription);
                return;
            }
        }
        else
        {

            if($UserSubscription->SubscriptionID > 0)
            {
                try
                {
                    $IntellivoidSubscriptionManager->getSubscriptionManager()->getSubscription(
                        SubscriptionSearchMethod::byId, $UserSubscription->SubscriptionID
                    );
                    set_subscription($UserSubscription);
                    return;
                }
                catch (SubscriptionNotFoundException $e)
                {
                    $UserSubscription->SubscriptionID = 0;
                    try
                    {
                        $OpenBlu->getUserSubscriptionManager()->updateUserSubscription($UserSubscription);
                    }
                    catch(Exception $e)
                    {
                        Actions::redirect(DynamicalWeb::getRoute('service_error', array(
                            'error_type' => 'us_update_failure::clause(snfe)'
                        )));
                    }
                    remove_subscription();
                    Actions::redirect(DynamicalWeb::getRoute('index') . '#pricing');
                    return;
                }
                catch(Exception $exception)
                {
                    Actions::redirect(DynamicalWeb::getRoute('service_error', array(
                        'error_type' => 'subscription_fetch_failure'
                    )));
                }
            }
            else
            {
                try
                {
                    $ActiveSubscription = find_active_subscription($IntellivoidSubscriptionManager, $ApplicationConfiguration);
                }
                catch (Exception $e)
                {
                    Actions::redirect(DynamicalWeb::getRoute('service_error', array(
                        'error_type' => 'find_active_subscription_error'
                    )));
                    return;
                }

                if(is_null($ActiveSubscription))
                {
                    return;
                }
                else
                {

                    $UserSubscription->SubscriptionID = $ActiveSubscription->ID;
                    $UserSubscription = update_existing_subscription(
                        $ApplicationConfiguration['APPLICATION_INTERNAL_ID'], $UserSubscription, $ActiveSubscription
                    );
                    try
                    {
                        $OpenBlu->getUserSubscriptionManager()->updateUserSubscription($UserSubscription);
                    }
                    catch(Exception $e)
                    {
                        Actions::redirect(DynamicalWeb::getRoute('service_error', array(
                            'error_type' => 'us_update_failure::clause(snfe)'
                        )));
                    }
                    set_subscription($UserSubscription);
                    return;
                }
            }
        }
    }

    function update_existing_subscription(int $application_id, UserSubscription $userSubscription, Subscription $subscription): UserSubscription
    {
        if(isset(DynamicalWeb::$globalObjects['intellivoid_api']) == false)
        {
            /** @var IntellivoidAPI $IntellivoidAPI */
            $IntellivoidAPI = DynamicalWeb::setMemoryObject('intellivoid_api', new IntellivoidAPI());
        }
        else
        {
            /** @var IntellivoidAPI $IntellivoidAPI */
            $IntellivoidAPI = DynamicalWeb::getMemoryObject('intellivoid_api');
        }

        try
        {
            $AccessRecord = $IntellivoidAPI->getAccessKeyManager()->getAccessRecord(
                AccessRecordSearchMethod::bySubscriptionID, $userSubscription->AccessRecordID
            );
        }
        catch(AccessRecordNotFoundException $e)
        {
            try
            {
                $AccessRecord = $IntellivoidAPI->getAccessKeyManager()->createAccessRecord(
                    $application_id, $userSubscription->SubscriptionID,
                    RateLimitName::None, array()
                );
            }
            catch(Exception $e)
            {
                Actions::redirect(DynamicalWeb::getRoute('service_error', array(
                    'error_type' => 'access_record_recreation_failed'
                )));

                return null;
            }
        }
        catch(Exception $e)
        {
            Actions::redirect(DynamicalWeb::getRoute('service_error', array(
                'error_type' => 'access_record_update_clause_failed'
            )));
            return null;
        }

        $AccessRecord = updateAccessRecord($AccessRecord, $subscription);

        try
        {
            $IntellivoidAPI->getAccessKeyManager()->updateAccessRecord($AccessRecord);
        }
        catch(Exception $e)
        {
            Actions::redirect(DynamicalWeb::getRoute('service_error', array(
                'error_type' => 'ar_update_failure'
            )));
        }

        $userSubscription->AccessRecordID = $AccessRecord->ID;
        return $userSubscription;
    }

    function set_subscription(UserSubscription $userSubscription)
    {
        /** @var sws $sws */
        $sws = DynamicalWeb::getMemoryObject('sws');

        $Cookie = $sws->WebManager()->getCookie('web_session');
        $Cookie->Data['subscription_active'] = true;
        $Cookie->Data['user_subscription_id'] = $userSubscription->SubscriptionID;

        $sws->CookieManager()->updateCookie($Cookie);
        Actions::redirect(DynamicalWeb::getRoute('api'));
    }

    function remove_subscription()
    {
        /** @var sws $sws */
        $sws = DynamicalWeb::getMemoryObject('sws');

        $Cookie = $sws->WebManager()->getCookie('web_session');
        $Cookie->Data['subscription_active'] = false;
        $Cookie->Data['user_subscription_id'] = 0;

        $sws->CookieManager()->updateCookie($Cookie);
    }

    function register_subscription(OpenBlu $openBlu, Subscription $subscription, int $application_id): UserSubscription
    {
        if(isset(DynamicalWeb::$globalObjects['intellivoid_api']) == false)
        {
            /** @var IntellivoidAPI $IntellivoidAPI */
            $IntellivoidAPI = DynamicalWeb::setMemoryObject('intellivoid_api', new IntellivoidAPI());
        }
        else
        {
            /** @var IntellivoidAPI $IntellivoidAPI */
            $IntellivoidAPI = DynamicalWeb::getMemoryObject('intellivoid_api');
        }

        try
        {
            $AccessRecord = $IntellivoidAPI->getAccessKeyManager()->createAccessRecord(
                $application_id, $subscription->ID,
                RateLimitName::None, array()
            );
        }
        catch (AccessRecordNotFoundException $e)
        {
            Actions::redirect(DynamicalWeb::getRoute('service_error', array(
                'error_type' => 'access_record_not_found'
            )));
            return null;
        }
        catch(Exception $e)
        {
            Actions::redirect(DynamicalWeb::getRoute('service_error', array(
                'error_type' => 'create_access_record_error'
            )));
        }

        $AccessRecord = updateAccessRecord($AccessRecord, $subscription);
        try
        {
            $IntellivoidAPI->getAccessKeyManager()->updateAccessRecord($AccessRecord);
        }
        catch(Exception $e)
        {
            Actions::redirect(DynamicalWeb::getRoute('service_error', array(
                'error_type' => 'ar_update_failure'
            )));
        }

        try
        {
            return $openBlu->getUserSubscriptionManager()->registerUserSubscription(
                WEB_ACCOUNT_ID, $subscription->ID, $AccessRecord->ID
            );
        }
        catch(Exception $e)
        {
            Actions::redirect(DynamicalWeb::getRoute('service_error', array(
                'error_type' => 'register_user_subscription_error'
            )));
        }

        return null;
    }

    function updateAccessRecord(AccessRecord $accessRecord, Subscription $subscription): AccessRecord
    {
        $Features  = Converter::featuresToSA($subscription->Properties->Features);

        $accessRecord->Variables = array();
        $accessRecord->Variables['SERVER_CONFIGS'] = 0;
        $accessRecord->Variables['MAX_SERVER_CONFIGS'] = (int)$Features['SERVER_CONFIGS'];

        return $accessRecord;
    }

    /**
     * Attempts to find an active subscription (SLOW)
     *
     * @param IntellivoidSubscriptionManager $intellivoidSubscriptionManager
     * @param array $applicationConfiguration
     * @return Subscription|null
     */
    function find_active_subscription(IntellivoidSubscriptionManager $intellivoidSubscriptionManager, array $applicationConfiguration)
    {

        try
        {
            $SubscriptionPlans = $intellivoidSubscriptionManager->getPlanManager()->getSubscriptionPlansByApplication(
                $applicationConfiguration['APPLICATION_INTERNAL_ID']
            );
        }
        catch (DatabaseException $e)
        {
            Actions::redirect(DynamicalWeb::getRoute('service_error', array(
                'error_type' => 'failure_plan_fetch'
            )));
        }

        $Subscription = null;

        /** @var SubscriptionPlan $subscriptionPlan */
        foreach($SubscriptionPlans as $subscriptionPlan)
        {
            try
            {
                $Subscription = $intellivoidSubscriptionManager->getSubscriptionManager()->getSubscriptionPlanAssociatedWithAccount(
                    WEB_ACCOUNT_ID, $subscriptionPlan->ID
                );
                break;
            }
            catch(Exception $e)
            {
                continue;
            }
        }

        return $Subscription;
    }

    /**
     * Checks if the user subscription is already registered
     *
     * @param OpenBlu $openBlu
     * @return UserSubscription|null
     */
    function check_user_subscription(OpenBlu $openBlu)
    {
        try
        {
            return $openBlu->getUserSubscriptionManager()->getUserSubscription(
                UserSubscriptionSearchMethod::byAccountID, WEB_ACCOUNT_ID
            );
        }
        catch(Exception $e)
        {
            return null;
        }
    }