<?PHP
    use DynamicalWeb\HTML;
?>
<div class="col-12">
    <div class="card">
        <div class="card-body">
            <div class="container text-center pt-5">
                <h4 class="mb-3 mt-5"><?PHP HTML::print(TEXT_PRICING_HEADER); ?></h4>
                <p class="w-75 mx-auto mb-5"><?PHP HTML::print(TEXT_PRICING_DESC); ?></p>
                <div class="row pricing-table">
                    <div class="col-md-4 grid-margin stretch-card pricing-card">
                        <div class="card border-primary border pricing-card-body">
                            <div class="text-center pricing-card-head">
                                <h3> >_ <?PHP HTML::print(TEXT_PRICING_FREE_HEADER); ?></h3>
                                <p><?PHP HTML::print(TEXT_PRICING_FREE_SUB_HEADER); ?></p>
                                <h1 class="font-weight-normal mb-4">$0.00</h1>
                            </div>
                            <ul class="list-unstyled plan-features">
                                <li><?PHP HTML::print(TEXT_PRICING_FREE_FEATURE_1); ?></li>
                                <li><?PHP HTML::print(TEXT_PRICING_FREE_FEATURE_2); ?></li>
                                <li><?PHP HTML::print(TEXT_PRICING_FREE_FEATURE_3); ?></li>
                                <li><?PHP HTML::print(TEXT_PRICING_FREE_FEATURE_4); ?></li>
                            </ul>
                            <div class="wrapper">
                                <a href="#" class="btn btn-inverse-primary btn-block">Get API Key</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 grid-margin stretch-card pricing-card">
                        <div class="card border border-success pricing-card-body">
                            <div class="text-center pricing-card-head">
                                <h3 class="text-success"> >_ <?PHP HTML::print(TEXT_PRICING_BASIC_HEADER); ?></h3>
                                <p><?PHP HTML::print(TEXT_PRICING_BASIC_SUB_HEADER); ?></p>
                                <h1 class="font-weight-normal mb-4">
                                    $7.99
                                    <p class="text-muted"><?PHP HTML::print(TEXT_PRICING_BASIC_CYCLE); ?></p>
                                </h1>

                            </div>
                            <ul class="list-unstyled plan-features">
                                <li><?PHP HTML::print(TEXT_PRICING_BASIC_FEATURE_1) ?></li>
                                <li><?PHP HTML::print(TEXT_PRICING_BASIC_FEATURE_2); ?></li>
                                <li><?PHP HTML::print(TEXT_PRICING_BASIC_FEATURE_3); ?></li>
                                <li><?PHP HTML::print(TEXT_PRICING_BASIC_FEATURE_4); ?></li>
                            </ul>
                            <div class="wrapper">
                                <a href="#" class="btn btn-inverse-success btn-block">Purchase Now</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 grid-margin stretch-card pricing-card">
                        <div class="card border border-primary pricing-card-body">
                            <div class="text-center pricing-card-head">
                                <h3> >_ Enterprise</h3>
                                <p>For Large Scale Use</p>
                                <h1 class="font-weight-normal mb-4">
                                    $39.99
                                    <p class="text-muted">Yearly</p>
                                </h1>
                            </div>
                            <ul class="list-unstyled plan-features">
                                <li>Unlimited Requests</li>
                                <li>Public server listings</li>
                                <li>OpenVPN configurations</li>
                                <li>For commercial use</li>
                            </ul>
                            <div class="wrapper">
                                <a href="#" class="btn btn-inverse-primary btn-block">Purchase Now</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>