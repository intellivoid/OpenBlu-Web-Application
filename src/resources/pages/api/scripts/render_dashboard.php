<?PHP

    use DynamicalWeb\DynamicalWeb;
    use DynamicalWeb\HTML;
    use DynamicalWeb\Runtime;
use IntellivoidAPI\IntellivoidAPI;
use IntellivoidSubscriptionManager\IntellivoidSubscriptionManager;
use ModularAPI\Abstracts\AccessKeySearchMethod;
    use ModularAPI\ModularAPI;
    use OpenBlu\Abstracts\APIPlan;
    use OpenBlu\Abstracts\SearchMethods\PlanSearchMethod;
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

?>
<div class="row">
    <div class="col-md-6 grid-margin stretch-card">
        <div class="card animated fadeInLeft">
            <div class="card-body">
                <h4 class="card-title"><?PHP HTML::print("Subscription Details"); ?></h4>
            </div>
        </div>
    </div>

    <div class="col-md-6 grid-margin stretch-card">
        <div class="card animated fadeInRight">
            <div class="card-body">
                <h4 class="card-title"><?PHP HTML::print(TEXT_AUTHENTICATION_CARD_TITLE); ?></h4>
                <p class="card-description"><?PHP HTML::print(TEXT_AUTHENTICATION_CARD_DESC); ?></p>
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