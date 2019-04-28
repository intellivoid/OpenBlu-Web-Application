<?php


    namespace Logixal;


    use Logixal\Abstracts\MessageTypes;

    /**
     * Class Logging
     * @package Logixal
     */
    class Logging
    {
        /**
         * Writes to the log as a information entry
         *
         * @param string $module_name
         * @param string $message
         * @param MessageTypes|string $type
         * @param bool $include_sub
         * @param string $sub_name
         * @throws Exceptions\ConfigurationNotFoundException
         */
        private static function write_entry(string $module_name, string $message, string $type, bool $include_sub = false, string $sub_name = 'none')
        {
            $unix_timestamp = time();
            $str_timestamp = date('h:i:s', $unix_timestamp);

            $entry = sprintf("%s %s => %s\r\n", $str_timestamp, $type, $message);
            $j_entry = json_encode(array(
                'timestamp' => $unix_timestamp,
                'type' => 'information',
                'entry' => $message
            ));
            $j_entry = sprintf("%s\r\n", $j_entry);

            file_put_contents(Utilities::getLogLocation($module_name, 'log'), $entry, FILE_APPEND);
            file_put_contents(Utilities::getLogLocation($module_name, 'jlog'), $j_entry, FILE_APPEND);

            if($include_sub == true)
            {
                file_put_contents(Utilities::getSubLogLocation($module_name, $sub_name, 'log'), $entry, FILE_APPEND);
            }
        }

        /**
         * Writes a information entry
         *
         * @param string $module_name
         * @param string $message
         * @throws Exceptions\ConfigurationNotFoundException
         */
        public static function information(string $module_name, string $message)
        {
            self::write_entry(
                $module_name, $message,
                MessageTypes::Information, false
            );
        }

        /**
         * Writes a warning entry
         *
         * @param string $module_name
         * @param string $message
         * @throws Exceptions\ConfigurationNotFoundException
         */
        public static function warning(string $module_name, string $message)
        {
            self::write_entry(
                $module_name, $message,
                MessageTypes::Warning, false
            );
        }

        /**
         * Writes a error entry
         *
         * @param string $module_name
         * @param string $message
         * @throws Exceptions\ConfigurationNotFoundException
         */
        public static function error(string $module_name, string $message)
        {
            self::write_entry(
                $module_name, $message,
                MessageTypes::Error,
                true, 'errors'
            );
        }

        /**
         * Writes a success entry
         *
         * @param string $module_name
         * @param string $message
         * @throws Exceptions\ConfigurationNotFoundException
         */
        public static function success(string $module_name, string $message)
        {
            self::write_entry(
                $module_name, $message,
                MessageTypes::Success, false
            );
        }

    }