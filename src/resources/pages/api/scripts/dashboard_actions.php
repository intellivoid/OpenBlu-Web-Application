<?php

    use ModularAPI\Exceptions\AccessKeyNotFoundException;
    use ModularAPI\Exceptions\NoResultsFoundException;
    use ModularAPI\Exceptions\UnsupportedSearchMethodException;
    use OpenBlu\Abstracts\SearchMethods\PlanSearchMethod;
    use OpenBlu\Exceptions\ConfigurationNotFoundException;
    use OpenBlu\Exceptions\DatabaseException;
    use OpenBlu\Exceptions\InvalidSearchMethodException;
    use OpenBlu\Exceptions\UpdateRecordNotFoundException;
    use OpenBlu\OpenBlu;

    if(isset($_GET['action']))
    {
        switch($_GET['action'])
        {
            case 'update_signatures':
                try
                {
                    update_signatures();
                    header('Location: /api');
                    exit();
                }
                catch(Exception $exception)
                {
                    header('Location: /api?callback=100');
                    exit();
                }

                break;
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