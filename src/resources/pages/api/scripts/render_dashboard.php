<?PHP

    use DynamicalWeb\Actions;
    use DynamicalWeb\DynamicalWeb;
    use DynamicalWeb\HTML;
    use DynamicalWeb\Runtime;
    use IntellivoidAPI\Abstracts\SearchMethods\AccessRecordSearchMethod;
    use IntellivoidAPI\Exceptions\AccessRecordNotFoundException;
    use IntellivoidAPI\IntellivoidAPI;
use IntellivoidAPI\Objects\AccessRecord;
use IntellivoidSubscriptionManager\Abstracts\SearchMethods\SubscriptionSearchMethod;
    use IntellivoidSubscriptionManager\Exceptions\SubscriptionNotFoundException;
    use IntellivoidSubscriptionManager\IntellivoidSubscriptionManager;
use IntellivoidSubscriptionManager\Objects\Subscription;
use IntellivoidSubscriptionManager\Objects\Subscription\Feature;
    use OpenBlu\Abstracts\SearchMethods\UserSubscriptionSearchMethod;
    use OpenBlu\Exceptions\UserSubscriptionRecordNotFoundException;
    use OpenBlu\OpenBlu;


    /** @var AccessRecord $AccessRecord */
    $AccessRecord = DynamicalWeb::getMemoryObject('access_record');

    /** @var Subscription $Subscription */
    $Subscription = DynamicalWeb::getMemoryObject('subscription');

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

        if($UsedServerConfigurations > $ConfiguredServerConfigurations)
        {
            $UsedServerConfigurations = $ConfiguredServerConfigurations;
        }
    }
?>
<div class="row">
    <div class="col-md-6 grid-margin stretch-card">
        <div class="card animated fadeInLeft">
            <div class="card-body">
                <h4 class="card-title"><?PHP HTML::print(TEXT_DASHBOARD_SUBSCRIPTION_DETAILS_HEADER); ?></h4>

                <div class="preview-list">
                    <div class="preview-item border-bottom">
                        <div class="preview-thumbnail">
                            <div class="preview-icon bg-inverse-primary rounded">
                                <i class="mdi mdi-server-security"></i>
                            </div>
                        </div>
                        <div class="preview-item-content d-flex flex-grow">
                            <div class="flex-grow">
                                <h6 class="preview-subject"><?PHP HTML::print(TEXT_DASHBOARD_SERVER_CONFIGURATION_HEADER); ?>
                                    <span class="float-right small">
                                        <span class="text-muted">
                                            <?PHP HTML::print($UsedServerConfigurations); ?>
                                        </span>
                                    </span>
                                </h6>
                                <p>
                                    <?PHP
                                        $Text = TEXT_DASHBOARD_SERVER_CONFIGURATION_DESC;
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
                                <h6 class="preview-subject"><?PHP HTML::print(TEXT_DASHBOARD_BILLING_CYCLE_HEADER); ?>
                                    <span class="float-right small">
                                        <span class="text-muted">
                                            <?PHP
                                            if((int)time() > $Subscription->NextBillingCycle)
                                            {
                                                HTML::print(TEXT_DASHBOARD_BILLING_CYCLE_DATE_TODAY);
                                            }
                                            else
                                            {
                                                HTML::print(gmdate("j/m/Y g:i a", $Subscription->NextBillingCycle));
                                            }
                                            ?>
                                        </span>
                                    </span>
                                </h6>
                                <p><?PHP HTML::print(TEXT_DASHBOARD_BILLING_CYCLE_DESC); ?></p>
                            </div>
                        </div>
                    </div>
                </div>
                <button type="button" class="btn btn-inverse-warning" onclick="window.open('https://gist.github.com/Netkas/6d09bd76ad8a6eaee6a6229b17eb373f');">
                    <i class="mdi mdi-book"></i> <?PHP HTML::print(TEXT_API_DOCUMENTATION_BUTTON); ?>
                </button>
            </div>
        </div>
    </div>

    <div class="col-md-6 grid-margin stretch-card">
        <div class="card animated fadeInRight">
            <div class="card-body">
                <h4 class="card-title"><?PHP HTML::print(TEXT_DASHBOARD_API_KEY_HEADER); ?></h4>
                <p class="card-description"><?PHP HTML::print(TEXT_DASHBOARD_API_KEY_DESC); ?></p>
                <div class="form-group border-bottom mt-5">
                    <label for="access_key" class="card-subtitle"><?PHP HTML::print(TEXT_DASHBOARD_API_KEY_HEADER); ?></label>
                    <input type="text" id="access_key" name="access_key" class="form-control" value="<?PHP HTML::print($AccessRecord->AccessKey); ?>" readonly>
                </div>

                <div class="form-group text-right">
                    <button type="button" class="btn btn-inverse-primary" onclick="location.href='<?PHP DynamicalWeb::getRoute('api', array('action' => 'generate_access_key'), true); ?>';">
                        <i class="mdi mdi-refresh"></i><?PHP HTML::print(TEXT_BUTTON_GENERATE_ACCESS_KEY); ?>
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
                            <h4 class="text-muted"><?PHP HTML::print(TEXT_API_USAGE_CARD_PLACEHOLDER); ?></h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>