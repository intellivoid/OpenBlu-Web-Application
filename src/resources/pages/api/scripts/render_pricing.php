<?PHP

    use DynamicalWeb\DynamicalWeb;
    use DynamicalWeb\HTML;
    use DynamicalWeb\Page;
    use DynamicalWeb\Runtime;
    use IntellivoidSubscriptionManager\Exceptions\SubscriptionPlanNotFoundException;
    use IntellivoidSubscriptionManager\IntellivoidSubscriptionManager;
    use IntellivoidSubscriptionManager\Objects\Subscription\Feature;

    Runtime::import('IntellivoidSubscriptionManager');

    $IntellivoidSubscriptionManager = new IntellivoidSubscriptionManager();
    $ApplicationConfiguration = DynamicalWeb::getConfiguration('coasniffle');

    try
    {
        $FreeSubscriptionPlan = $IntellivoidSubscriptionManager->getPlanManager()->getSubscriptionPlanByName(
            $ApplicationConfiguration['APPLICATION_INTERNAL_ID'], "Free"
        );
    }
    catch (SubscriptionPlanNotFoundException $e)
    {
        Page::staticResponse(
            "Configuration Error", "Intellivoid Accounts Error",
            "The subscription plan for 'FREE' is not configured properly"
        );
        exit();
    }
    catch(Exception $e)
    {
        Page::staticResponse(
            "Configuration Error", "Intellivoid Accounts Error",
            "The subscription plan for 'FREE' raised an unknown error"
        );
        exit();
    }

    try
    {
        $BasicSubscriptionPlan = $IntellivoidSubscriptionManager->getPlanManager()->getSubscriptionPlanByName(
            $ApplicationConfiguration['APPLICATION_INTERNAL_ID'], "Basic"
        );
    }
    catch (SubscriptionPlanNotFoundException $e)
    {
        Page::staticResponse(
            "Configuration Error", "Intellivoid Accounts Error",
            "The subscription plan for 'BASIC' is not configured properly"
        );
        exit();
    }
    catch(Exception $e)
    {
        Page::staticResponse(
            "Configuration Error", "Intellivoid Accounts Error",
            "The subscription plan for 'BASIC' raised an unknown error"
        );
        exit();
    }

    try
    {
        $EnterpriseSubscriptionPlan = $IntellivoidSubscriptionManager->getPlanManager()->getSubscriptionPlanByName(
            $ApplicationConfiguration['APPLICATION_INTERNAL_ID'], "Enterprise"
        );
    }
    catch (SubscriptionPlanNotFoundException $e)
    {
        Page::staticResponse(
            "Configuration Error", "Intellivoid Accounts Error",
            "The subscription plan for 'ENTERPRISE' is not configured properly"
        );
        exit();
    }
    catch(Exception $e)
    {
        Page::staticResponse(
            "Configuration Error", "Intellivoid Accounts Error",
            "The subscription plan for 'ENTERPRISE' raised an unknown error"
        );
        exit();
    }

    $COASniffle = DynamicalWeb::getMemoryObject('coasniffle');
    $Protocol = strtolower(substr($_SERVER["SERVER_PROTOCOL"],0,strpos( $_SERVER["SERVER_PROTOCOL"],'/'))).'://';

    $FreeLocation = '';
    $BasicLocation = '';
    $EnterpriseLocation = '';

    if(WEB_SESSION_ACTIVE == false)
    {
        $FreeLocation = $COASniffle->getCOA()->getAuthenticationURL(
            $Protocol . $_SERVER['HTTP_HOST'] . DynamicalWeb::getRoute('index', array(
                'redirect' => 'confirm_purchase', 'plan' => 'free'
            ))
        );
        $BasicLocation = $COASniffle->getCOA()->getAuthenticationURL(
            $Protocol . $_SERVER['HTTP_HOST'] . DynamicalWeb::getRoute('index', array(
                'redirect' => 'confirm_purchase', 'plan' => 'basic'
            ))
        );
        $EnterpriseLocation = $COASniffle->getCOA()->getAuthenticationURL(
            $Protocol . $_SERVER['HTTP_HOST'] . DynamicalWeb::getRoute('index', array(
                'redirect' => 'confirm_purchase', 'plan' => 'enterprise'
            ))
        );
    }
    else
    {
        $FreeLocation = DynamicalWeb::getRoute('purchase', array('plan' => 'free'));
        $BasicLocation = DynamicalWeb::getRoute('purchase', array('plan' => 'basic'));
        $EnterpriseLocation = DynamicalWeb::getRoute('purchase', array('plan' => 'enterprise'));
    }


?>
<div class="col-12">
    <div class="card animated fadeInUp">
        <div class="card-body">
            <h4 class="card-title">API Plans</h4>
            <?PHP HTML::importScript('callbacks'); ?>
            <div class="container text-center pt-5">
                <h4 class="mb-3 mt-2"><?PHP HTML::print(TEXT_PRICING_HEADER); ?></h4>
                <p class="w-75 mx-auto mb-5"><?PHP HTML::print(TEXT_PRICING_DESC); ?></p>
                <div class="row pricing-table">
                    <div class="col-md-4 grid-margin stretch-card pricing-card">
                        <div class="card border-primary border pricing-card-body">
                            <div class="text-center pricing-card-head">
                                <h3>
                                    <i class="mdi mdi-console-line"></i>
                                    <?PHP HTML::print($FreeSubscriptionPlan->PlanName); ?>
                                </h3>
                                <p class="text-muted"><?PHP HTML::print(TEXT_PLAN_FREE_DESCRIPTION); ?></p>
                            </div>
                            <ul class="list-unstyled plan-features">
                                <?PHP
                                    /** @var Feature $feature */
                                    foreach($FreeSubscriptionPlan->Features as $feature)
                                    {
                                        switch($feature->Name)
                                        {
                                            case 'SERVER_CONFIGS':
                                                $Text = TEXT_PLAN_VPN_CONFIGS_AMOUNT;
                                                if($feature->Value > 0)
                                                {
                                                    $Text = str_ireplace('%s', $feature->Value, $Text);
                                                }
                                                else
                                                {
                                                    $Text = str_ireplace('%s', TEXT_PLAN_UNLIMITED_VPN_CONFIGS, $Text);
                                                }
                                                ?><li><?PHP HTML::print($Text); ?></li><?PHP
                                                break;
                                        }
                                    }
                                ?>
                                <li><?PHP HTML::print(TEXT_PLAN_FEATURE_1); ?></li>
                                <li><?PHP HTML::print(TEXT_PLAN_FEATURE_2); ?></li>
                            </ul>
                            <div class="wrapper">
                                <a href="<?PHP HTML::print($FreeLocation, false); ?>" class="btn btn-inverse-primary btn-block"><?PHP HTML::print(TEXT_BUTTON_SUBMIT_FREE); ?></a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 grid-margin stretch-card pricing-card">
                        <div class="card border border-success pricing-card-body">
                            <div class="text-center pricing-card-head">
                                <h3 class="text-success">
                                    <i class="mdi mdi-console-line"></i>
                                    <?PHP HTML::print($BasicSubscriptionPlan->PlanName); ?>
                                </h3>
                                
                                <p><?PHP HTML::print($Text); ?></p>
                            </div>
                            <ul class="list-unstyled plan-features">
                                <?PHP
                                /** @var Feature $feature */
                                foreach($BasicSubscriptionPlan->Features as $feature)
                                {
                                    switch($feature->Name)
                                    {
                                        case 'SERVER_CONFIGS':
                                            $Text = TEXT_PLAN_VPN_CONFIGS_AMOUNT;
                                            if($feature->Value > 0)
                                            {
                                                $Text = str_ireplace('%s', $feature->Value, $Text);
                                            }
                                            else
                                            {
                                                $Text = str_ireplace('%s', TEXT_PLAN_UNLIMITED_VPN_CONFIGS, $Text);
                                            }
                                            ?><li><?PHP HTML::print($Text); ?></li><?PHP
                                            break;
                                    }
                                }
                                ?>
                                <li><?PHP HTML::print(TEXT_PLAN_FEATURE_1); ?></li>
                                <li><?PHP HTML::print(TEXT_PLAN_FEATURE_2); ?></li>
                            </ul>
                            <div class="wrapper">
                                <a href="<?PHP HTML::print($BasicLocation, false); ?>" class="btn btn-inverse-success btn-block">
                                    <?PHP HTML::print(str_ireplace('%s', $BasicSubscriptionPlan->InitialPrice, TEXT_BUTTON_SUBMIT_PAID)); ?>
                                </a>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4 grid-margin stretch-card pricing-card">
                        <div class="card border border-danger pricing-card-body">
                            <div class="text-center pricing-card-head">
                                <h3 class="text-danger">
                                    <i class="mdi mdi-console-line"></i>
                                    <?PHP HTML::print($EnterpriseSubscriptionPlan->PlanName); ?>
                                </h3>
                                <?PHP
                                $Text = TEXT_PLAN_MONTHLY_PRICE;
                                $Text = str_ireplace('%s', $EnterpriseSubscriptionPlan->CyclePrice, $Text);
                                ?>
                                <p><?PHP HTML::print($Text); ?></p>
                            </div>
                            <ul class="list-unstyled plan-features">
                                <?PHP
                                /** @var Feature $feature */
                                foreach($EnterpriseSubscriptionPlan->Features as $feature)
                                {
                                    switch($feature->Name)
                                    {
                                        case 'SERVER_CONFIGS':
                                            $Text = TEXT_PLAN_VPN_CONFIGS_AMOUNT;
                                            if($feature->Value > 0)
                                            {
                                                $Text = str_ireplace('%s', $feature->Value, $Text);
                                            }
                                            else
                                            {
                                                $Text = str_ireplace('%s', TEXT_PLAN_UNLIMITED_VPN_CONFIGS, $Text);
                                            }
                                            ?><li><?PHP HTML::print($Text); ?></li><?PHP
                                            break;
                                    }
                                }
                                ?>
                                <li><?PHP HTML::print(TEXT_PLAN_FEATURE_1); ?></li>
                                <li><?PHP HTML::print(TEXT_PLAN_FEATURE_2); ?></li>
                            </ul>
                            <div class="wrapper">
                                <a href="<?PHP HTML::print($EnterpriseLocation, false); ?>" class="btn btn-inverse-danger btn-block">
                                    <?PHP HTML::print(str_ireplace('%s', $EnterpriseSubscriptionPlan->InitialPrice, TEXT_BUTTON_SUBMIT_PAID)); ?>
                                </a>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>