<?php

    use DynamicalWeb\DynamicalWeb;
    use ModularAPI\Abstracts\AccessKeySearchMethod;
    use ModularAPI\Exceptions\AccessKeyNotFoundException;
    use ModularAPI\Exceptions\NoResultsFoundException;
    use ModularAPI\Exceptions\UnsupportedSearchMethodException;
    use ModularAPI\ModularAPI;
    use OpenBlu\Abstracts\SearchMethods\PlanSearchMethod;
    use OpenBlu\Exceptions\ConfigurationNotFoundException;
    use OpenBlu\Exceptions\DatabaseException;
    use OpenBlu\Exceptions\InvalidSearchMethodException;
    use OpenBlu\Exceptions\UpdateRecordNotFoundException;
    use OpenBlu\OpenBlu;
use sws\sws;

// TODO: Add callbacks to dashboard
    if(isset($_GET['action']))
    {
        switch($_GET['action'])
        {
            case 'update_signatures':
                try
                {
                    update_signatures();
                    header('Location: /api'); // Redirect to dashboard
                    exit();
                }
                catch(Exception $exception)
                {
                    header('Location: /api?callback=100'); // Dashboard callback
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
                    header('Location: /api?callback=101'); // Dashboard Callback
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
                    die(var_dump($exception));
                    header('Location: /api?callback=103'); // Dashboard callback
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
        $OpenBlu = new OpenBlu();

        $Plan = $OpenBlu->getPlanManager()->getPlan(PlanSearchMethod::byAccountId, WEB_ACCOUNT_ID);
        $OpenBlu->getPlanManager()->updateSignatures($Plan);
    }

    /**
     * @return string
     * @throws ConfigurationNotFoundException
     * @throws DatabaseException
     * @throws InvalidSearchMethodException
     * @throws NoResultsFoundException
     * @throws UnsupportedSearchMethodException
     * @throws UpdateRecordNotFoundException
     */
    function get_certificate(): array
    {
        if(class_exists('ModularAPI\ModularAPI') == false)
        {
            DynamicalWeb::loadLibrary('ModularAPI', 'ModularAPI', 'ModularAPI');
        }

        $OpenBlu = new OpenBlu();
        $ModularAPI = new ModularAPI();

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
     * @throws \OpenBlu\Exceptions\PlanNotFoundException
     */
    function cancel_plan()
    {
        $OpenBlu = new OpenBlu();
        $OpenBlu->getPlanManager()->cancelPlan(WEB_ACCOUNT_ID);

        // Force update the cache
        $sws = new sws();
        $Cookie = $sws->WebManager()->getCookie('web_session');
        $Cookie->Data['cache_refresh'] = 0;

        $sws->CookieManager()->updateCookie($Cookie);
    }