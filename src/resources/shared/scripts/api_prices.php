<?php

    use DynamicalWeb\DynamicalWeb;

    /**
     * Class PricingDetails
     */
    class PricingDetails
    {
        /**
         * PricingDetails constructor.
         * @param array $data
         */
        public function __construct(array $data)
        {
            $this->PlanName = $data['plan_name'];
            $this->Price = (float)$data['price'];
            $this->Cycle = $data['cycle'];
            $this->CallsMonthly = (int)$data['calls_monthly'];
            $this->IsAffiliated = (bool)$data['affiliation']['affiliated'];
            $this->AffiliationShare = (float)$data['affiliation']['affiliation_share'];
            $this->AffiliationUsername = $data['affiliation']['account_username'];
        }

        /**
         * The name of the plan
         *
         * @var string
         */
        public $PlanName;

        /**
         * How much the plan costs
         *
         * @var float
         */
        public $Price;

        /**
         * The billing cycle (MONTHLY/YEARLY)
         *
         * @var string
         */
        public $Cycle;

        /**
         * The calls that are allowed monthly
         * If it's 0, it's unlimited
         *
         * @var int
         */
        public $CallsMonthly;

        /**
         * Determines if the plan is affiliated with someone
         *
         * @var bool
         */
        public $IsAffiliated;

        /**
         * The share that the affiliation gets for each purchase
         *
         * @var float
         */
        public $AffiliationShare;

        /**
         * The username of the account to send the share to
         *
         * @var string
         */
        public $AffiliationUsername;
    }

    /**
     * @param string $code
     * @return PricingDetails
     * @throws Exception
     */
    function api_prices_get_free(string $code = 'NORMAL'): PricingDetails
    {
        /** @noinspection PhpUnhandledExceptionInspection */

        if(isset(DynamicalWeb::$globalVariables['db 0x83']['config_prices']) == false)
        {
            /** @var array $Configuration */
            $Configuration = DynamicalWeb::setArray('config_prices', DynamicalWeb::getConfiguration('prices'));
        }
        else
        {
            /** @var array $Configuration */
            $Configuration = DynamicalWeb::getArray('config_prices');
        }

        if(isset($Configuration['FREE'][$code]) == false)
        {
            throw new Exception('Invalid promotion code');
        }

        return new PricingDetails($Configuration['FREE'][$code]);
    }

    /**
     * @param string $code
     * @return PricingDetails
     * @throws Exception
     */
    function api_prices_get_basic(string $code = 'NORMAL'): PricingDetails
    {
        /** @noinspection PhpUnhandledExceptionInspection */
        if(isset(DynamicalWeb::$globalVariables['db 0x83']['config_prices']) == false)
        {
            /** @var array $Configuration */
            $Configuration = DynamicalWeb::setArray('config_prices', DynamicalWeb::getConfiguration('prices'));
        }
        else
        {
            /** @var array $Configuration */
            $Configuration = DynamicalWeb::getArray('config_prices');
        }

        if(isset($Configuration['BASIC'][$code]) == false)
        {
            throw new Exception('Invalid promotion code');
        }

        return new PricingDetails($Configuration['BASIC'][$code]);
    }

    /**
     * @param string $code
     * @return PricingDetails
     * @throws Exception
     */
    function api_prices_get_enterprise(string $code = 'NORMAL'): PricingDetails
    {
        /** @noinspection PhpUnhandledExceptionInspection */
        if(isset(DynamicalWeb::$globalVariables['db 0x83']['config_prices']) == false)
        {
            /** @var array $Configuration */
            $Configuration = DynamicalWeb::setArray('config_prices', DynamicalWeb::getConfiguration('prices'));
        }
        else
        {
            /** @var array $Configuration */
            $Configuration = DynamicalWeb::getArray('config_prices');
        }

        if(isset($Configuration['ENTERPRISE'][$code]) == false)
        {
            throw new Exception('Invalid promotion code');
        }

        return new PricingDetails($Configuration['ENTERPRISE'][$code]);
    }