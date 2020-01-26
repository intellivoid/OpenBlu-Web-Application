<?php

    use DynamicalWeb\Actions;
    use DynamicalWeb\DynamicalWeb;
    use IntellivoidAPI\Abstracts\SearchMethods\AccessRecordSearchMethod;
    use IntellivoidAPI\Exceptions\AccessRecordNotFoundException;
    use IntellivoidAPI\Exceptions\InvalidRateLimitConfiguration;
    use IntellivoidAPI\IntellivoidAPI;
    use OpenBlu\Abstracts\SearchMethods\UserSubscriptionSearchMethod;
    use OpenBlu\Exceptions\DatabaseException;
    use OpenBlu\Exceptions\InvalidSearchMethodException;
    use OpenBlu\Exceptions\UserSubscriptionRecordNotFoundException;
    use OpenBlu\OpenBlu;

    if(isset($_GET['action']))
    {
        switch($_GET['action'])
        {
            case 'generate_access_key':
                try
                {
                    generate_access_key();
                    Actions::redirect(DynamicalWeb::getRoute('api', array('callback' => '103')));
                    exit();
                }
                catch(Exception $exception)
                {
                    Actions::redirect(DynamicalWeb::getRoute('api', array('callback' => '100')));
                    exit();
                }

                break;
        }
    }


    /**
     * @throws AccessRecordNotFoundException
     * @throws \IntellivoidAPI\Exceptions\DatabaseException
     * @throws InvalidRateLimitConfiguration
     * @throws \IntellivoidAPI\Exceptions\InvalidSearchMethodException
     * @throws DatabaseException
     * @throws InvalidSearchMethodException
     * @throws UserSubscriptionRecordNotFoundException
     */
    function generate_access_key()
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

        $UserSubscription = $OpenBlu->getUserSubscriptionManager()->getUserSubscription(
            UserSubscriptionSearchMethod::byAccountID, WEB_ACCOUNT_ID
        );

        $AccessRecord = $IntellivoidAPI->getAccessKeyManager()->getAccessRecord(
            AccessRecordSearchMethod::byId, $UserSubscription->AccessRecordID
        );

        $IntellivoidAPI->getAccessKeyManager()->generateNewAccessKey($AccessRecord);

    }