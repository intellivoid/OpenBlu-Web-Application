<?php

    namespace MongoDB\Operation;

    use MongoDB\Driver\Command;
    use MongoDB\Driver\Exception\RuntimeException as DriverRuntimeException;
    use MongoDB\Driver\Server;
    use MongoDB\Driver\Session;
    use MongoDB\Driver\WriteConcern;
    use MongoDB\Exception\InvalidArgumentException;
    use MongoDB\Exception\UnsupportedException;
    use function current;
    use function is_array;
    use function MongoDB\server_supports_feature;

    /**
     * Operation for the dropDatabase command.
     *
     * @api
     * @see \MongoDB\Client::dropDatabase()
     * @see \MongoDB\Database::drop()
     * @see http://docs.mongodb.org/manual/reference/command/dropDatabase/
     */
    class DropDatabase implements Executable
    {
        /** @var integer */
        private static $wireVersionForWriteConcern = 5;

        /** @var string */
        private $databaseName;

        /** @var array */
        private $options;

        /**
         * Constructs a dropDatabase command.
         *
         * Supported options:
         *
         *  * session (MongoDB\Driver\Session): Client session.
         *
         *    Sessions are not supported for server versions < 3.6.
         *
         *  * typeMap (array): Type map for BSON deserialization. This will be used
         *    for the returned command result document.
         *
         *  * writeConcern (MongoDB\Driver\WriteConcern): Write concern.
         *
         *    This is not supported for server versions < 3.4 and will result in an
         *    exception at execution time if used.
         *
         * @param string $databaseName Database name
         * @param array  $options      Command options
         * @throws InvalidArgumentException for parameter/option parsing errors
         */
        public function __construct($databaseName, array $options = [])
        {
            if (isset($options['session']) && ! $options['session'] instanceof Session) {
                throw InvalidArgumentException::invalidType('"session" option', $options['session'], Session::class);
            }

            if (isset($options['typeMap']) && ! is_array($options['typeMap'])) {
                throw InvalidArgumentException::invalidType('"typeMap" option', $options['typeMap'], 'array');
            }

            if (isset($options['writeConcern']) && ! $options['writeConcern'] instanceof WriteConcern) {
                throw InvalidArgumentException::invalidType('"writeConcern" option', $options['writeConcern'], WriteConcern::class);
            }

            if (isset($options['writeConcern']) && $options['writeConcern']->isDefault()) {
                unset($options['writeConcern']);
            }

            $this->databaseName = (string) $databaseName;
            $this->options = $options;
        }

        /**
         * Execute the operation.
         *
         * @see Executable::execute()
         * @param Server $server
         * @return array|object Command result document
         * @throws UnsupportedException if writeConcern is used and unsupported
         * @throws DriverRuntimeException for other driver errors (e.g. connection errors)
         */
        public function execute(Server $server)
        {
            if (isset($this->options['writeConcern']) && ! server_supports_feature($server, self::$wireVersionForWriteConcern)) {
                throw UnsupportedException::writeConcernNotSupported();
            }

            $command = new Command(['dropDatabase' => 1]);
            $cursor = $server->executeWriteCommand($this->databaseName, $command, $this->createOptions());

            if (isset($this->options['typeMap'])) {
                $cursor->setTypeMap($this->options['typeMap']);
            }

            return current($cursor->toArray());
        }

        /**
         * Create options for executing the command.
         *
         * @see http://php.net/manual/en/mongodb-driver-server.executewritecommand.php
         * @return array
         */
        private function createOptions()
        {
            $options = [];

            if (isset($this->options['session'])) {
                $options['session'] = $this->options['session'];
            }

            if (isset($this->options['writeConcern'])) {
                $options['writeConcern'] = $this->options['writeConcern'];
            }

            return $options;
        }
    }
