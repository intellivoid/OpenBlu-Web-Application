<?php


    namespace Logixal;


    use Logixal\Exceptions\ConfigurationNotFoundException;


    /**
     * Class Utilities
     * @package Logixal
     */
    class Utilities
    {
        /**
         * Construct the directories and files for the module
         *
         * @return string
         * @throws ConfigurationNotFoundException
         */
        public static function loggingDirectory()
        {
            try
            {
                $logging_directory = Logixal::getLoggingDirectory();
            }
            catch(ConfigurationNotFoundException $configurationNotFoundException)
            {
                throw $configurationNotFoundException;
            }

            $today_directory = $logging_directory . DIRECTORY_SEPARATOR . date("Y-m-d");

            if(file_exists($today_directory) == false)
            {
                $oldmask = umask(0);
                mkdir($today_directory, 0777);
                umask($oldmask);
            }

            return $today_directory;
        }

        /**
         * Gets the main log file location
         *
         * @param string $module_name
         * @param string $file_type
         * @return string
         * @throws ConfigurationNotFoundException
         */
        public static function getLogLocation(string $module_name, string $file_type = 'log'): string
        {
            $log_name = strtolower($module_name);
            $log_name = str_ireplace(' ', '_', $log_name);
            $log_name = str_ireplace('.', '_', $log_name);

            $active_directory = self::loggingDirectory();
            $log_file = sprintf('%s.%s', $active_directory. DIRECTORY_SEPARATOR . $log_name, $file_type);

            if(file_exists($log_file) == false)
            {
                file_put_contents($log_file, '');
            }

            return $log_file;
        }


        /**
         * Gets the sub log location
         *
         * @param string $module_name
         * @param string $sub_name
         * @param string $file_type
         * @return string
         * @throws ConfigurationNotFoundException
         */
        public static function getSubLogLocation(string $module_name, string $sub_name, string $file_type = 'log'): string
        {

            $log_name = strtolower($module_name);
            $log_name = str_ireplace(' ', '_', $log_name);
            $log_name = str_ireplace('.', '_', $log_name);

            $active_directory = self::loggingDirectory();
            $log_file = sprintf('%s_%s.%s', $active_directory . DIRECTORY_SEPARATOR . $log_name, $sub_name, $file_type);

            if(file_exists($log_file) == false)
            {
                file_put_contents($log_file, '');
            }

            return $log_file;
        }
    }