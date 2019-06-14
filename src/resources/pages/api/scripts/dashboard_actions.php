<?php

    use DynamicalWeb\DynamicalWeb;
    use DynamicalWeb\Runtime;
    use ModularAPI\Abstracts\AccessKeySearchMethod;
    use ModularAPI\Exceptions\AccessKeyNotFoundException;
    use ModularAPI\Exceptions\NoResultsFoundException;
    use ModularAPI\Exceptions\UnsupportedSearchMethodException;
    use ModularAPI\ModularAPI;
    use OpenBlu\Abstracts\SearchMethods\PlanSearchMethod;
    use OpenBlu\Exceptions\ConfigurationNotFoundException;
    use OpenBlu\Exceptions\DatabaseException;
    use OpenBlu\Exceptions\InvalidSearchMethodException;
    use OpenBlu\Exceptions\PlanNotFoundException;
    use OpenBlu\Exceptions\UpdateRecordNotFoundException;
    use OpenBlu\OpenBlu;
    use sws\sws;

    Runtime::import('OpenBlu');
    Runtime::import('ModularAPI');

    // TODO: Add callbacks to dashboard
    if(isset($_GET['action']))
    {
        switch($_GET['action'])
        {
            case 'update_signatures':
                try
                {
                    update_signatures();
                    header('Location: /api?callback=101'); // Redirect to dashboard
                    exit();
                }
                catch(Exception $exception)
                {
                    header('Location: /api?callback=102'); // Dashboard callback
                    exit();
                }

                break;

            case 'download_certificate':
                try
                {
                    $results = get_certificate();
                    header('Content-Type: application/x-x509-user-cert');
                    header("Content-disposition: attachment; filename=\"" . $results['public_id'] . ".crt\"");
                    print($results['certificate']);
                    exit();
                }
                catch(Exception $exception)
                {
                    header('Location: /api?callback=103'); // Dashboard Callback
                    exit();
                }

            case 'cancel_plan':
                try
                {
                    cancel_plan();
                    header('Location: /api?callback=100'); // API Callback
                    exit();
                }
                catch(Exception $exception)
                {
                    header('Location: /api?callback=104'); // Dashboard callback
                    exit();
                }
        }
    }

    /**
     * @throws AccessKeyNotFoundException
     * @throws NoResultsFoundException
     * @throws UnsupportedSearchMethodException
     * @throws ConfigurationNotFoundException
     * @throws DatabaseException
     * @throws InvalidSearchMethodException
     * @throws UpdateRecordNotFoundException
     */
    function update_signatures()
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

        $Plan = $OpenBlu->getPlanManager()->getPlan(PlanSearchMethod::byAccountId, WEB_ACCOUNT_ID);
        $OpenBlu->getPlanManager()->updateSignatures($Plan);
    }

    /**
     * @return array
     * @throws ConfigurationNotFoundException
     * @throws DatabaseException
     * @throws InvalidSearchMethodException
     * @throws NoResultsFoundException
     * @throws UnsupportedSearchMethodException
     * @throws UpdateRecordNotFoundException
     */
    function get_certificate(): array
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

        if(isset(DynamicalWeb::$globalObjects['modular_api']) == false)
        {
            /** @var ModularAPI $ModularAPI */
            $ModularAPI = DynamicalWeb::setMemoryObject('modular_api', new ModularAPI());
        }
        else
        {
            /** @var ModularAPI $ModularAPI */
            $ModularAPI = DynamicalWeb::getMemoryObject('modular_api');
        }

        $Plan = $OpenBlu->getPlanManager()->getPlan(PlanSearchMethod::byAccountId, WEB_ACCOUNT_ID);
        $AccessKeyObject = $ModularAPI->AccessKeys()->Manager->get(AccessKeySearchMethod::byID, $Plan->AccessKeyId);

        return array(
            'certificate' => $AccessKeyObject->Signatures->createCertificate(),
            'public_id' => $AccessKeyObject->PublicID
        );
    }

    /**
     * @throws AccessKeyNotFoundException
     * @throws ConfigurationNotFoundException
     * @throws DatabaseException
     * @throws InvalidSearchMethodException
     * @throws NoResultsFoundException
     * @throws UnsupportedSearchMethodException
     * @throws UpdateRecordNotFoundException
     * @throws PlanNotFoundException
     */
    function cancel_plan()
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

        $OpenBlu->getPlanManager()->cancelPlan(WEB_ACCOUNT_ID);

        // Force update the cache
        /** @var sws $sws */
        $sws = DynamicalWeb::getMemoryObject('sws');

        $Cookie = $sws->WebManager()->getCookie('web_session');
        $Cookie->Data['cache_refresh'] = 0;

        $sws->CookieManager()->updateCookie($Cookie);
    }