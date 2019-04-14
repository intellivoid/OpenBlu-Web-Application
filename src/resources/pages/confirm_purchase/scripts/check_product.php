<?php

    use DynamicalWeb\HTML;

    if(isset($_GET['plan']) == false)
    {
        header('Location: /api');
        exit();
    }

    if(isset($_GET['promotion_code']) == false)
    {
        define('PROMOTION_CODE', 'NORMAL', false);
        define('PROMOTION_SET', false, false);
    }
    else
    {
        if($_GET['promotion_code'] > 250)
        {
            define('PROMOTION_CODE', 'NORMAL', false);
            define('PROMOTION_SET', false, false);
        }
        else
        {
            define('PROMOTION_CODE', $_GET['promotion_code'], false);
            define('PROMOTION_SET', true, false);
        }
    }

    /** @noinspection PhpUnhandledExceptionInspection */
    HTML::importScript('api_prices');
    $PlanDetails = null;

    switch($_GET['plan'])
    {
        case 'free':
            try
            {
                $PlanDetails = api_prices_get_free(PROMOTION_CODE);
            }
            catch(Exception $exception)
            {
                header('Location: /confirm_purchase?plan=free&callback=100');
                exit();
            }
            break;

        case 'basic':
            try
            {
                $PlanDetails = api_prices_get_basic(PROMOTION_CODE);
            }
            catch(Exception $exception)
            {
                header('Location: /confirm_purchase?plan=basic&callback=100');
                exit();
            }
            break;

        case 'enterprise':
            try
            {
                $PlanDetails = api_prices_get_enterprise(PROMOTION_CODE);
            }
            catch(Exception $exception)
            {
                header('Location: /confirm_purchase?plan=enterprise&callback=100');
                exit();
            }
            break;

        default:
            header('Location: /api');
            exit();
    }

    define('PLAN_NAME', $PlanDetails->PlanName, false);
    if($PlanDetails->Price > 0)
    {
        define('PLAN_PRICE', str_ireplace('%s', $PlanDetails->Price, TEXT_PLACEHOLDER_PRICE), false);
    }
    else
    {
        define('PLAN_PRICE', TEXT_PLACEHOLDER_PRICE_FREE, false);
    }

    if($PlanDetails->CallsMonthly > 0)
    {
        define('PLAN_CALLS_MONTHLY', str_ireplace('%s', $PlanDetails->CallsMonthly, TEXT_PLACEHOLDER_MONTHLY_CALLS), false);
    }
    else
    {
        define('PLAN_CALLS_MONTHLY', TEXT_PLACEHOLDER_UNLIMITED_CALLS, false);
    }

    if($PlanDetails->Cycle == 'MONTHLY')
    {
        define('PLAN_BILLING_CYCLE', TEXT_PLACEHOLDER_MONTHLY_BILLING_CYCLE, false);
    }
    elseif($PlanDetails->Cycle == 'YEARLY')
    {
        define('PLAN_BILLING_CYCLE', TEXT_PLACEHOLDER_YEARLY_BILLING_CYCLE, false);
    }

