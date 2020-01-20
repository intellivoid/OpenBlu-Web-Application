<?php

    use DynamicalWeb\DynamicalWeb;
    use DynamicalWeb\Runtime;
use IntellivoidSubscriptionManager\Exceptions\DatabaseException;
use IntellivoidSubscriptionManager\IntellivoidSubscriptionManager;
use IntellivoidSubscriptionManager\Objects\Subscription;
use IntellivoidSubscriptionManager\Objects\SubscriptionPlan;
    use OpenBlu\Abstracts\SearchMethods\UserSubscriptionSearchMethod;
use OpenBlu\Objects\UserSubscription;
use OpenBlu\OpenBlu;

    Runtime::import('OpenBlu');
    Runtime::import('IntellivoidSubscriptionManager');

    if(WEB_SESSION_ACTIVE)
    {
        if(WEB_SUBSCRIPTION_ACTIVE == false)
        {
            check_subscription();
        }
    }

    function check_subscription()
    {
        $ApplicationConfiguration = DynamicalWeb::getConfiguration('coasniffle');

        $OpenBlu = new OpenBlu();
        $IntellivoidSubscriptionManager = new IntellivoidSubscriptionManager();

        $UserSubscription = check_user_subscription($OpenBlu);
        if(is_null($UserSubscription))
        {
            $ActiveSubscription = find_active_subscription($IntellivoidSubscriptionManager, $ApplicationConfiguration);

            if(is_null($ActiveSubscription))
            {
                return;
            }
            else
            {


                $UserSubscription = $OpenBlu->getUserSubscriptionManager()->registerUserSubscription(
                    WEB_ACCOUNT_ID, $ActiveSubscription->ID,
                );
            }
        }
    }

    /**
     * Attempts to find an active subscription (SLOW)
     *
     * @param IntellivoidSubscriptionManager $intellivoidSubscriptionManager
     * @param array $applicationConfiguration
     * @return Subscription|null
     * @throws DatabaseException
     */
    function find_active_subscription(IntellivoidSubscriptionManager $intellivoidSubscriptionManager, array $applicationConfiguration)
    {

        $SubscriptionPlans = $intellivoidSubscriptionManager->getPlanManager()->getSubscriptionPlansByApplication(
            $applicationConfiguration['APPLICATION_INTERNAL_ID']
        );

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
            $UserSubscription = $openBlu->getUserSubscriptionManager()->getUserSubscription(
                UserSubscriptionSearchMethod::byAccountID, WEB_ACCOUNT_ID
            );

            return $UserSubscription;
        }
        catch(Exception $e)
        {
            return null;
        }
    }