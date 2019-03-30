<?php

    namespace OpenBlu\Objects;
    use OpenBlu\Abstracts\DefaultValues;

    /**
     * Class VPN
     * @package OpenBlu\Objects
     */
    class VPN
    {
        /**
         * The unique ID of the VPN which is represented in the database
         *
         * @var int
         */
        public $ID;

        /**
         * The unique Public ID to represent this VPN from the database
         *
         * @var string
         */
        public $PublicID;

        /**
         * The name of the VPN host
         *
         * @var string
         */
        public $HostName;

        /**
         * The IP Address of the VPN Server
         *
         * @var string
         */
        public $IP;

        /**
         * The quality of the VPN Server
         *
         * @var int
         */
        public $Score;

        /**
         * The ping time for this VPN Server
         *
         * @var int
         */
        public $Ping;

        /**
         * The name of the country that this VPN Server is located in
         *
         * @var string
         */
        public $Country;

        /**
         * Two characters to represent a country name
         *
         * @var string
         */
        public $CountryShort;

        /**
         * The current amount of sessions that are established to this VPN Server
         *
         * @var int
         */
        public $Sessions;

        /**
         * The total amount of sessions that has been established to this VPN Server
         *
         * @var int
         */
        public $TotalSessions;

        /**
         * Configuration Parameters used within the configuration
         *
         * @var array
         */
        public $ConfigurationParameters;

        /**
         * Certificate Authority data (<ca>)
         *
         * @var string
         */
        public $CertificateAuthority;

        /**
         * Certificate data (<cert>)
         *
         * @var string
         */
        public $Certificate;

        /**
         * Key data (<key>)
         *
         * @var string
         */
        public $Key;

        /**
         * The Unix Timestamp of when this VPN was created
         *
         * @var int
         */
        public $Created;

        /**
         * The Unix Timestamp fo when this VPN was last updated
         *
         * @var int
         */
        public $LastUpdated;

        /**
         * Returns the object as an array
         *
         * @return array
         */
        public function toArray(): array
        {
            return array(
                'id' => (int)$this->ID,
                'public_id' => $this->PublicID,
                'host_name' => $this->HostName,
                'ip_address' => $this->IP,
                'score' => (int)$this->Score,
                'ping' => (int)$this->Ping,
                'country' => $this->Country,
                'country_short' => $this->CountryShort,
                'sessions' => (int)$this->Sessions,
                'total_sessions' => (int)$this->TotalSessions,
                'configuration_parameters' => $this->ConfigurationParameters,
                'certificate_authority' => $this->CertificateAuthority,
                'certificate' => $this->Certificate,
                'key' => $this->Key,
                'last_updated' => (int)$this->LastUpdated,
                'created' => (int)$this->Created
            );
        }

        /**
         * Constructs object from array
         *
         * @param array $data
         * @return VPN
         */
        public static function fromArray(array $data): VPN
        {
            $VPNObject = new VPN();

            if(isset($data['id']))
            {
                $VPNObject->ID = (int)$data['id'];
            }
            else
            {
                $VPNObject->ID = 0;
            }

            if(isset($data['public_id']))
            {
                $VPNObject->PublicID = (string)$data['public_id'];
            }
            else
            {
                $VPNObject->PublicID = DefaultValues::None;
            }

            if(isset($data['host_name']))
            {
                $VPNObject->HostName = (string)$data['host_name'];
            }
            else
            {
                $VPNObject->HostName = DefaultValues::Unknown;
            }

            if(isset($data['ip_address']))
            {
                $VPNObject->IP = (string)$data['ip_address'];
            }
            else
            {
                $VPNObject->IP = DefaultValues::Unknown;
            }

            if(isset($data['score']))
            {
                $VPNObject->Score = (int)$data['score'];
            }
            else
            {
                $VPNObject->Score = 0;
            }

            if(isset($data['ping']))
            {
                $VPNObject->Ping = (int)$data['ping'];
            }
            else
            {
                $VPNObject->Ping = 0;
            }

            if(isset($data['country']))
            {
                $VPNObject->Country = (string)$data['country'];
            }
            else
            {
                $VPNObject->Country = DefaultValues::Unknown;
            }

            if(isset($data['country_short']))
            {
                $VPNObject->CountryShort = (string)$data['country_short'];
            }
            else
            {
                $VPNObject->CountryShort = DefaultValues::Unknown;
            }

            if(isset($data['sessions']))
            {
                $VPNObject->Sessions = (int)$data['sessions'];
            }
            else
            {
                $VPNObject->Sessions = 0;
            }

            if(isset($data['total_sessions']))
            {
                $VPNObject->TotalSessions = (int)$data['total_sessions'];
            }
            else
            {
                $VPNObject->TotalSessions = 0;
            }

            if(isset($data['configuration_parameters']))
            {
                $VPNObject->ConfigurationParameters = $data['configuration_parameters'];
            }
            else
            {
                $VPNObject->ConfigurationParameters = [];
            }

            if(isset($data['certificate_authority']))
            {
                $VPNObject->CertificateAuthority = $data['certificate_authority'];
            }
            else
            {
                $VPNObject->CertificateAuthority = DefaultValues::None;
            }

            if(isset($data['certificate']))
            {
                $VPNObject->Certificate = $data['certificate'];
            }
            else
            {
                $VPNObject->CertificateAuthority = DefaultValues::None;
            }

            if(isset($data['key']))
            {
                $VPNObject->Key = $data['key'];
            }
            else
            {
                $VPNObject->Key = DefaultValues::None;
            }

            if(isset($data['created']))
            {
                $VPNObject->Created = (int)$data['created'];
            }
            else
            {
                $VPNObject->Created = 0;
            }

            if(isset($data['last_updated']))
            {
                $VPNObject->LastUpdated = (int)$data['last_updated'];
            }
            else
            {
                $VPNObject->LastUpdated = 0;
            }

            return $VPNObject;
        }
    }