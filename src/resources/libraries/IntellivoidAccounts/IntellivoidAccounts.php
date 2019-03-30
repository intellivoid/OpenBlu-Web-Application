<?php

    namespace IntellivoidAccounts;
    use IntellivoidAccounts\Exceptions\ConfigurationNotFoundException;

    include_once(__DIR__ . DIRECTORY_SEPARATOR . 'Abstracts' . DIRECTORY_SEPARATOR . 'SearchMethods' . DIRECTORY_SEPARATOR . 'AccountSearchMethod.php');
    include_once(__DIR__ . DIRECTORY_SEPARATOR . 'Abstracts' . DIRECTORY_SEPARATOR . 'AccountStatus.php');
    include_once(__DIR__ . DIRECTORY_SEPARATOR . 'Abstracts' . DIRECTORY_SEPARATOR . 'ExceptionCodes.php');
    include_once(__DIR__ . DIRECTORY_SEPARATOR . 'Abstracts' . DIRECTORY_SEPARATOR . 'LoginStatus.php');

    include_once(__DIR__ . DIRECTORY_SEPARATOR . 'Exceptions' . DIRECTORY_SEPARATOR . 'AccountNotFoundException.php');
    include_once(__DIR__ . DIRECTORY_SEPARATOR . 'Exceptions' . DIRECTORY_SEPARATOR . 'AccountSuspendedException.php');
    include_once(__DIR__ . DIRECTORY_SEPARATOR . 'Exceptions' . DIRECTORY_SEPARATOR . 'ConfigurationNotFoundException.php');
    include_once(__DIR__ . DIRECTORY_SEPARATOR . 'Exceptions' . DIRECTORY_SEPARATOR . 'DatabaseException.php');
    include_once(__DIR__ . DIRECTORY_SEPARATOR . 'Exceptions' . DIRECTORY_SEPARATOR . 'EmailAlreadyExistsException.php');
    include_once(__DIR__ . DIRECTORY_SEPARATOR . 'Exceptions' . DIRECTORY_SEPARATOR . 'IncorrectLoginDetailsException.php');
    include_once(__DIR__ . DIRECTORY_SEPARATOR . 'Exceptions' . DIRECTORY_SEPARATOR . 'InvalidEmailException.php');
    include_once(__DIR__ . DIRECTORY_SEPARATOR . 'Exceptions' . DIRECTORY_SEPARATOR . 'InvalidPasswordException.php');
    include_once(__DIR__ . DIRECTORY_SEPARATOR . 'Exceptions' . DIRECTORY_SEPARATOR . 'InvalidSearchMethodException.php');
    include_once(__DIR__ . DIRECTORY_SEPARATOR . 'Exceptions' . DIRECTORY_SEPARATOR . 'InvalidUsernameException.php');
    include_once(__DIR__ . DIRECTORY_SEPARATOR . 'Exceptions' . DIRECTORY_SEPARATOR . 'UsernameAlreadyExistsException.php');

    include_once(__DIR__ . DIRECTORY_SEPARATOR . 'Managers' . DIRECTORY_SEPARATOR . 'AccountManager.php');

    include_once(__DIR__ . DIRECTORY_SEPARATOR . 'Objects' . DIRECTORY_SEPARATOR . 'Account' . DIRECTORY_SEPARATOR . 'PersonalInformation' . DIRECTORY_SEPARATOR . 'BirthDate.php');
    include_once(__DIR__ . DIRECTORY_SEPARATOR . 'Objects' . DIRECTORY_SEPARATOR . 'Account' . DIRECTORY_SEPARATOR . 'Configuration.php');
    include_once(__DIR__ . DIRECTORY_SEPARATOR . 'Objects' . DIRECTORY_SEPARATOR . 'Account' . DIRECTORY_SEPARATOR . 'PersonalInformation.php');
    include_once(__DIR__ . DIRECTORY_SEPARATOR . 'Objects' . DIRECTORY_SEPARATOR . 'Account.php');
    include_once(__DIR__ . DIRECTORY_SEPARATOR . 'Objects' . DIRECTORY_SEPARATOR . 'ApplicationConfiguration.php');
    include_once(__DIR__ . DIRECTORY_SEPARATOR . 'Objects' . DIRECTORY_SEPARATOR . 'LoginRecord.php');

    include_once(__DIR__ . DIRECTORY_SEPARATOR . 'Utilities' . DIRECTORY_SEPARATOR . 'Hashing.php');
    include_once(__DIR__ . DIRECTORY_SEPARATOR . 'Utilities' . DIRECTORY_SEPARATOR . 'Validate.php');

    include_once(__DIR__ . DIRECTORY_SEPARATOR . 'ZiProto' . DIRECTORY_SEPARATOR . 'ZiProto.php');

    /**
     * Class IntellivoidAccounts
     * @package IntellivoidAccounts
     */
    class IntellivoidAccounts
    {
        /**
         * @var array|bool
         */
        public $configuration;

        /**
         * @var \mysqli
         */
        public $database;

        /**
         * IntellivoidAccounts constructor.
         * @throws ConfigurationNotFoundException
         */
        public function __construct()
        {
            if(file_exists(__DIR__ . DIRECTORY_SEPARATOR . 'configuration.ini') == false)
            {
                throw new ConfigurationNotFoundException();
            }

            $this->configuration = parse_ini_file(__DIR__ . DIRECTORY_SEPARATOR . 'configuration.ini');

            $this->database = new \mysqli(
                $this->configuration['DatabaseHost'],
                $this->configuration['DatabaseUsername'],
                $this->configuration['DatabasePassword'],
                $this->configuration['DatabaseName'],
                $this->configuration['DatabasePort']
            );
        }
    }