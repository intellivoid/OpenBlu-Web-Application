<?PHP
    use DynamicalWeb\HTML;

    $FreeLocation = '';
    $BasicLocation = '';
    $EnterpriseLocation = '';

    if(WEB_SESSION_ACTIVE == false)
    {
        $FreeLocation = '/register?redirect=purchase_plan&type=free';
        $BasicLocation = '/register?redirect=purchase_plan&type=basic';
        $EnterpriseLocation = '/register?redirect=purchase_plan&type=enterprise';
    }
    else
    {
        $FreeLocation = '/confirm_purchase?plan=free';
        $BasicLocation = '/confirm_purchase?plan=basic';
        $EnterpriseLocation = '/confirm_purchase?plan=enterprise';
    }

    /** @noinspection PhpUnhandledExceptionInspection */
    HTML::importScript('api_prices');

    /** @noinspection PhpUnhandledExceptionInspection */
    $Free = api_prices_get_free();

    /** @noinspection PhpUnhandledExceptionInspection */
    $Basic = api_prices_get_basic();

    /** @noinspection PhpUnhandledExceptionInspection */
    $Enterprise = api_prices_get_enterprise();

    $FreePrice = "$0.00";
    $BasicPrice = "$0.00";
    $EnterprisePrice = "$0.00";

    if($Free->Price > 0) { $FreePrice = '$' . $Free->Price; }
    if($Basic->Price > 0) { $BasicPrice = '$' . $Basic->Price; }
    if($Enterprise->Price > 0) { $EnterprisePrice = '$' . $Enterprise->Price; }

    $FreeCalls = TEXT_UNLIMITED_CALLS;
    $BasicCalls = TEXT_UNLIMITED_CALLS;
    $EnterpriseCalls = TEXT_UNLIMITED_CALLS;

    if($Free->CallsMonthly > 0 ) { $FreeCalls = str_ireplace('%s', $Free->CallsMonthly, TEXT_CALLS_PER_MONTH); }
    if($Basic->CallsMonthly > 0 ) { $BasicCalls = str_ireplace('%s', $Basic->CallsMonthly, TEXT_CALLS_PER_MONTH); }
    if($Enterprise->CallsMonthly > 0 ) { $EnterpriseCalls = str_ireplace('%s', $Enterprise->CallsMonthly, TEXT_CALLS_PER_MONTH); }
?>
<div class="col-12">
    <div class="card">
        <div class="card-body">
            <h4 class="card-title">API Plans</h4>
            <div class="container text-center pt-5">
                <h4 class="mb-3 mt-5"><?PHP HTML::print(TEXT_PRICING_HEADER); ?></h4>
                <p class="w-75 mx-auto mb-5"><?PHP HTML::print(TEXT_PRICING_DESC); ?></p>
                <div class="row pricing-table">
                    <div class="col-md-4 grid-margin stretch-card pricing-card">
                        <div class="card border-primary border pricing-card-body">
                            <div class="text-center pricing-card-head">
                                <h3> <i class="mdi mdi-console-line"></i> <?PHP HTML::print(TEXT_PRICING_FREE_HEADER); ?></h3>
                                <p><?PHP HTML::print(TEXT_PRICING_FREE_SUB_HEADER); ?></p>
                                <h1 class="font-weight-normal mb-4"><?PHP HTML::print($FreePrice); ?></h1>
                            </div>
                            <ul class="list-unstyled plan-features">
                                <li><?PHP HTML::print($FreeCalls); ?></li>
                                <li><?PHP HTML::print(TEXT_PRICING_FREE_FEATURE_1); ?></li>
                                <li><?PHP HTML::print(TEXT_PRICING_FREE_FEATURE_2); ?></li>
                                <li><?PHP HTML::print(TEXT_PRICING_FREE_FEATURE_3); ?></li>
                            </ul>
                            <div class="wrapper">
                                <a href="<?PHP HTML::print($FreeLocation, false); ?>" class="btn btn-inverse-primary btn-block">Get API Key</a href="#">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 grid-margin stretch-card pricing-card">
                        <div class="card border border-success pricing-card-body">
                            <div class="text-center pricing-card-head">
                                <h3 class="text-success"> <i class="mdi mdi-console-line"></i> <?PHP HTML::print(TEXT_PRICING_BASIC_HEADER); ?></h3>
                                <p><?PHP HTML::print(TEXT_PRICING_BASIC_SUB_HEADER); ?></p>
                                <h1 class="font-weight-normal mb-4">
                                    <?PHP HTML::print($BasicPrice); ?></h1>
                                    <p class="text-muted"><?PHP HTML::print(TEXT_PRICING_BASIC_CYCLE); ?></p>
                                </h1>

                            </div>
                            <ul class="list-unstyled plan-features">
                                <li><?PHP HTML::print($BasicCalls); ?></li>
                                <li><?PHP HTML::print(TEXT_PRICING_BASIC_FEATURE_1) ?></li>
                                <li><?PHP HTML::print(TEXT_PRICING_BASIC_FEATURE_2); ?></li>
                                <li><?PHP HTML::print(TEXT_PRICING_BASIC_FEATURE_3); ?></li>
                            </ul>
                            <div class="wrapper">
                                <a href="<?PHP HTML::print($BasicLocation, false); ?>" class="btn btn-inverse-success btn-block"><?PHP HTML::print(TEXT_PRICING_BASIC_SUBMIT); ?></a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 grid-margin stretch-card pricing-card">
                        <div class="card border border-danger pricing-card-body">
                            <div class="text-center pricing-card-head">
                                <h3 class="text-danger"> <i class="mdi mdi-console-line"></i> <?PHP HTML::print(TEXT_PRICING_ENTERPRISE_HEADER); ?></h3>
                                <p><?PHP HTML::print(TEXT_PRICING_ENTERPRISE_SUB_HEADER); ?></p>
                                <h1 class="font-weight-normal mb-4">
                                    <?PHP HTML::print($EnterprisePrice); ?></h1>
                                    <p class="text-muted"><?PHP HTML::print(TEXT_PRICING_ENTERPRISE_CYCLE); ?></p>
                                </h1>
                            </div>
                            <ul class="list-unstyled plan-features">
                                <li><?PHP HTML::print($EnterpriseCalls); ?></li>
                                <li><?PHP HTML::print(TEXT_PRICING_ENTERPRISE_FEATURE_1); ?></li>
                                <li><?PHP HTML::print(TEXT_PRICING_ENTERPRISE_FEATURE_2); ?></li>
                                <li><?PHP HTML::print(TEXT_PRICING_ENTERPRISE_FEATURE_3); ?></li>
                            </ul>
                            <div class="wrapper">
                                <a href="<?PHP HTML::print($EnterpriseLocation, false); ?>" class="btn btn-inverse-danger btn-block"><?PHP HTML::print(TEXT_PRICING_ENTERPRISE_SUBMIT); ?></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>