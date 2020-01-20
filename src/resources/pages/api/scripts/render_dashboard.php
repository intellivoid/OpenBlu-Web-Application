<?PHP

    use DynamicalWeb\DynamicalWeb;
    use DynamicalWeb\HTML;
    use DynamicalWeb\Runtime;
use IntellivoidAPI\Abstracts\SearchMethods\AccessRecordSearchMethod;
use IntellivoidAPI\IntellivoidAPI;
use IntellivoidSubscriptionManager\Abstracts\SearchMethods\SubscriptionSearchMethod;
use IntellivoidSubscriptionManager\IntellivoidSubscriptionManager;
use IntellivoidSubscriptionManager\Objects\Subscription\Feature;
use ModularAPI\Abstracts\AccessKeySearchMethod;
    use ModularAPI\ModularAPI;
    use OpenBlu\Abstracts\APIPlan;
    use OpenBlu\Abstracts\SearchMethods\PlanSearchMethod;
use OpenBlu\Abstracts\SearchMethods\UserSubscriptionSearchMethod;
use OpenBlu\OpenBlu;

    Runtime::import('OpenBlu');
    Runtime::import('IntellivoidSubscriptionManager');
    Runtime::import('IntellivoidAPI');

    if(isset(DynamicalWeb::$globalObjects['intellivoid_api']) == false)
    {
        /** @var IntellivoidAPI $IntellivoidAPI */
        $IntellivoidAPI = DynamicalWeb::setMemoryObject('intellivoid_api', new IntellivoidAPI());
    }
    else
    {
        /** @var IntellivoidAPI $IntellivoidAPI */
        $IntellivoidAPI = DynamicalWeb::getMemoryObject('intellivoid_api');
    }

    if(isset(DynamicalWeb::$globalObjects['intellivoid_subscription_manager']) == false)
    {
        /** @var IntellivoidSubscriptionManager $IntellivoidSubscriptionManager */
        $IntellivoidSubscriptionManager = DynamicalWeb::setMemoryObject('intellivoid_subscription_manager', new IntellivoidSubscriptionManager());
    }
    else
    {
        /** @var IntellivoidSubscriptionManager $IntellivoidSubscriptionManager */
        $IntellivoidSubscriptionManager = DynamicalWeb::getMemoryObject('intellivoid_subscription_manager');
    }

    if(isset(DynamicalWeb::$globalObjects['openblu']) == false)
    {
        /** @var OpenBlu $OpenBlu */
        $OpenBlu = DynamicalWeb::setMemoryObject('openblu', new OpenBlu());
    }
    else
    {
        /** @var OpenBlu $OpenBlu */
        $OpenBlu = DynamicalWeb::getMemoryObject('openblu');
    }

    $UserSubscription = $OpenBlu->getUserSubscriptionManager()->getUserSubscription(
            UserSubscriptionSearchMethod::byAccountID, WEB_ACCOUNT_ID
    );

    $Subscription = $IntellivoidSubscriptionManager->getSubscriptionManager()->getSubscription(
            SubscriptionSearchMethod::byId, $UserSubscription->SubscriptionID
    );

    $AccessRecord = $IntellivoidAPI->getAccessKeyManager()->getAccessRecord(
            AccessRecordSearchMethod::byId, $UserSubscription->AccessRecordID
    );

    $ConfiguredServerConfigurations = "Unknown";
    $UsedServerConfigurations = "Unknown";

    /** @var Feature $feature */
    foreach($Subscription->Properties->Features as $feature)
    {
        switch($feature->Name)
        {
            case 'SERVER_CONFIGS':
                $ConfiguredServerConfigurations = (int)$feature->Value;
                break;
        }
    }

    if(isset($AccessRecord->Variables['SERVER_CONFIGS']))
    {
        $UsedServerConfigurations = (int)$AccessRecord->Variables['SERVER_CONFIGS'];
    }
?>
<div class="row">
    <div class="col-md-6 grid-margin stretch-card">
        <div class="card animated fadeInLeft">
            <div class="card-body">
                <h4 class="card-title"><?PHP HTML::print("Subscription Details"); ?></h4>

                <div class="preview-list">
                    <div class="preview-item border-bottom">
                        <div class="preview-thumbnail">
                            <div class="preview-icon bg-inverse-primary rounded">
                                <i class="mdi mdi-server-security"></i>
                            </div>
                        </div>
                        <div class="preview-item-content d-flex flex-grow">
                            <div class="flex-grow">
                                <h6 class="preview-subject">Server Configurations
                                    <span class="float-right small">
                                        <span class="text-muted">
                                            <?PHP HTML::print($UsedServerConfigurations); ?>
                                        </span>
                                    </span>
                                </h6>
                                <p>
                                    <?PHP
                                        $Text = "You retrieve %s server configurations from the API, this will reset for every billing cycle";
                                        $Text = str_ireplace('%s', $ConfiguredServerConfigurations, $Text);
                                        HTML::print($Text);
                                    ?>
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="preview-item">
                        <div class="preview-thumbnail">
                            <div class="preview-icon bg-inverse-primary rounded">
                                <i class="mdi mdi-timer"></i>
                            </div>
                        </div>
                        <div class="preview-item-content d-flex flex-grow">
                            <div class="flex-grow">
                                <h6 class="preview-subject">Next Billing Cycle
                                    <span class="float-right small">
                                        <span class="text-muted">
                                            <?PHP
                                            if((int)time() > $Subscription->NextBillingCycle)
                                            {
                                                HTML::print("Today");
                                            }
                                            else
                                            {
                                                HTML::print(gmdate("j/m/Y g:i a", $Subscription->NextBillingCycle));
                                            }
                                            ?>
                                        </span>
                                    </span>
                                </h6>
                                <p><?PHP HTML::print("Your billing will be processed automatically when you use the API"); ?></p>
                            </div>
                        </div>
                    </div>
                </div>
                <button type="button" class="btn btn-inverse-warning" onclick="window.open('https://gist.github.com/Netkas/584b0648c93620060f60d89b1878564f');">
                    <i class="mdi mdi-book"></i> <?PHP HTML::print(TEXT_API_DOCUMENTATION_BUTTON); ?>
                </button>
            </div>
        </div>
    </div>

    <div class="col-md-6 grid-margin stretch-card">
        <div class="card animated fadeInRight">
            <div class="card-body">
                <h4 class="card-title"><?PHP HTML::print(TEXT_AUTHENTICATION_CARD_TITLE); ?></h4>
                <p class="card-description"><?PHP HTML::print(TEXT_AUTHENTICATION_CARD_DESC); ?></p>
                <div class="form-group border-bottom mt-5">
                    <label for="api_key" class="card-subtitle"><?PHP HTML::print("Access Key"); ?></label>
                    <input type="text" id="access_key" name="access_key" class="form-control" value="<?PHP HTML::print($AccessRecord->AccessKey); ?>" readonly>
                </div>

                <div class="form-group text-right">
                    <button type="button" class="btn btn-inverse-primary" onclick="location.href='/api?action=update_signatures';">
                        <i class="mdi mdi-refresh"></i><?PHP HTML::print("Generate new Access Key"); ?>
                    </button>
                </div>
            </div>
        </div>
    </div>

</div>

<div class="row grid-margin">
    <div class="col-12">
        <div class="card animated fadeInUp">
            <div class="card-body">
                <h4 class="card-title"><?PHP HTML::print(TEXT_API_USAGE_CARD_TITLE); ?></h4>
                <div id="api-usage-chart">
                    <div class="d-flex flex-column justify-content-center align-items-center" style="height:30vh;">
                        <div class="p-2 my-flex-item">
                            <h4 class="text-muted">Coming soon</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>