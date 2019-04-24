<?php

    use DynamicalWeb\DynamicalWeb;
    use IntellivoidAccounts\Abstracts\AccountStatus;
    use IntellivoidAccounts\Abstracts\SearchMethods\AccountSearchMethod;
    use IntellivoidAccounts\IntellivoidAccounts;

    /** @noinspection PhpUnhandledExceptionInspection */
    DynamicalWeb::loadLibrary('IntellivoidAccounts', 'IntellivoidAccounts', 'IntellivoidAccounts.php');

    /** @noinspection PhpUnhandledExceptionInspection */
    DynamicalWeb::loadLibrary('ModularAPI', 'ModularAPI', 'ModularAPI.php');

    /** @noinspection PhpUnhandledExceptionInspection */
    DynamicalWeb::loadLibrary('OpenBlu', 'OpenBlu', 'OpenBlu.php');

    $IntellivoidAccounts = new IntellivoidAccounts();

    /** @noinspection PhpUnhandledExceptionInspection */
    $Account = $IntellivoidAccounts->getAccountManager()->getAccount(AccountSearchMethod::byId, WEB_ACCOUNT_ID);

    if($Account->Status !== AccountStatus::Active)
    {
        // TODO: Redirect depending on status
    }

    if($Account->Configuration->OpenBlu->Active == true)
    {
        // TODO: Redirect if already active
    }

    