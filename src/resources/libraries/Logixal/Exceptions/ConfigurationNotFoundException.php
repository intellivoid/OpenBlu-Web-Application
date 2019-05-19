<?php


    namespace Logixal\Exceptions;

    use Exception;
    use Logixal\Abstracts\ExceptionCodes;

    /**
     * Class ConfigurationNotFoundException
     * @package Logixal\Exceptions
     */
    class ConfigurationNotFoundException extends Exception
    {
        /**
         * ConfigurationNotFoundException constructor.
         */
        public function __construct()
        {
            parent::__construct('The configuration file was not found', ExceptionCodes::ConfigurationNotFoundException, null);
        }
    }