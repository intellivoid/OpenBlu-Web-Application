<?php

    namespace Logixal;


    use Logixal\Exceptions\ConfigurationNotFoundException;


    include_once(__DIR__ . DIRECTORY_SEPARATOR . 'Logging.php');
    include_once(__DIR__ . DIRECTORY_SEPARATOR . 'Utilities.php');

    include_once(__DIR__ . DIRECTORY_SEPARATOR . 'Abstracts' . DIRECTORY_SEPARATOR . 'ExceptionCodes.php');
    include_once(__DIR__ . DIRECTORY_SEPARATOR . 'Abstracts' . DIRECTORY_SEPARATOR . 'MessageTypes.php');

    include_once(__DIR__ . DIRECTORY_SEPARATOR . 'Exceptions' . DIRECTORY_SEPARATOR . 'ConfigurationNotFoundException.php');


    /**
     * Class Logixal
     * @package Logixal
     */
    class Logixal
    {

        /**
         * @return mixed
         * @throws ConfigurationNotFoundException
         */
        public static function getLoggingDirectory()
        {
            if(file_exists(__DIR__ . DIRECTORY_SEPARATOR . 'configuration.ini') == false)
            {
                throw new ConfigurationNotFoundException();
            }

            $Configuration = parse_ini_file(__DIR__ . DIRECTORY_SEPARATOR . 'configuration.ini');

            if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN')
            {
                return $Configuration['Windows_LoggingDirectory'];
            }
            else
            {
                return $Configuration['Unix_LoggingDirectory'];
            }
        }
    }