<?PHP

    use DynamicalWeb\DynamicalWeb;
    use DynamicalWeb\HTML;
    use DynamicalWeb\Runtime;
    use ModularAPI\Abstracts\AccessKeySearchMethod;
    use ModularAPI\ModularAPI;
    use OpenBlu\Abstracts\APIPlan;
    use OpenBlu\Abstracts\SearchMethods\PlanSearchMethod;
    use OpenBlu\OpenBlu;

    Runtime::import('OpenBlu');
    Runtime::import('ModularAPI');

    if(isset(DynamicalWeb::$globalObjects['modular_api']) == false)
    {
        /** @var ModularAPI $ModularAPI */
        $ModularAPI = DynamicalWeb::setMemoryObject('modular_api', new ModularAPI());
    }
    else
    {
        /** @var ModularAPI $ModularAPI */
        $ModularAPI = DynamicalWeb::getMemoryObject('modular_api');
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

    $AccessKeyObject = $ModularAPI->AccessKeys()->Manager->get(AccessKeySearchMethod::byID, CACHE_SUBSCRIPTION_ACCESS_KEY_ID);
    $Plan = $OpenBlu->getPlanManager()->getPlan(PlanSearchMethod::byAccountId, WEB_ACCOUNT_ID);

    $UsageCurrentMonth = 0;
    foreach($AccessKeyObject->Analytics->CurrentMonthUsage as $Month => $Usage)
    {
        $UsageCurrentMonth += $Usage;
    }

    $PlanTypeName = TEXT_PLAN_TYPE_UNKNOWN;

    switch($Plan->PlanType)
    {
        case APIPlan::Free:
            $PlanTypeName = TEXT_PLAN_TYPE_FREE;
            break;

        case APIPlan::Basic:
            $PlanTypeName = TEXT_PLAN_TYPE_BASIC;
            break;

        case APIPlan::Enterprise:
            $PlanTypeName = TEXT_PLAN_TYPE_ENTERPRISE;
            break;
    }

?>
<div class="row">

    <div class="col-md-6 grid-margin stretch-card">
        <div class="card animated fadeInLeft">
            <div class="card-body">
                <h4 class="card-title"><?PHP HTML::print(TEXT_CURRENT_PLAN_CARD_TITLE); ?></h4>
                <div class="alert alert-fill-primary" role="alert"><?PHP HTML::print(TEXT_CURRENT_PLAN_ALERT); ?></div>
                <div class="preview-list">
                    <div class="preview-item border-bottom">
                        <div class="preview-thumbnail">
                            <div class="preview-icon bg-inverse-primary rounded">
                                <i class="mdi mdi-chart-pie"></i>
                            </div>
                        </div>
                        <div class="preview-item-content d-flex flex-grow">
                            <div class="flex-grow">
                                <h6 class="preview-subject"><?PHP HTML::print(TEXT_CURRENT_PLAN_ROW_PLAN_TYPE_TITLE); ?>
                                    <span class="float-right small">
                                        <span class="text-muted pr-3"><?PHP HTML::print($PlanTypeName); ?></span>
                                        <?PHP
                                            if($Plan->PromotionCode !== 'NORMAL')
                                            {
                                                HTML::print("<span class=\"text-muted border-left pl-3\">", false);
                                                HTML::print($Plan->PromotionCode, true);
                                                HTML::print("</span>", false);
                                            }
                                        ?>
                                    </span>
                                </h6>
                                <p><?PHP HTML::print(TEXT_CURRENT_PLAN_ROW_PLAN_TYPE_DESC); ?></p>
                            </div>
                        </div>
                    </div>
                    <div class="preview-item border-bottom">
                        <div class="preview-thumbnail">
                            <div class="preview-icon bg-inverse-primary rounded">
                                <i class="mdi mdi-server-network"></i>
                            </div>
                        </div>
                        <div class="preview-item-content d-flex flex-grow">
                            <div class="flex-grow">
                                <h6 class="preview-subject"><?PHP HTML::print(TEXT_CURRENT_PLAN_ROW_MONTHLY_CALLS_TITLE); ?>
                                    <span class="float-right small">
                                        <?PHP
                                            if($Plan->MonthlyCalls == 0)
                                            {
                                                ?>
                                                <span class="text-muted border-right pr-3"><?PHP HTML::print(TEXT_CURRENT_PLAN_ROW_MONTHLY_CALLS_UNLIMITED_USAGE); ?></span>
                                                <?PHP
                                            }
                                            else
                                            {
                                                ?>
                                                <span class="text-muted border-right pr-3"><?PHP HTML::print(str_ireplace('%s', number_format($Plan->MonthlyCalls), TEXT_CURRENT_PLAN_ROW_MONTHLY_CALLS_PLACEHOLDER)); ?></span>
                                                <?PHP
                                            }
                                        ?>
                                        <span class="text-muted pl-3"><?PHP HTML::print(str_ireplace('%s', number_format($UsageCurrentMonth), TEXT_CURRENT_PLAN_ROW_MONTHLY_CALLS_CURRENT_USAGE_PLACEHOLDER)); ?></span>
                                    </span>
                                </h6>
                                <p><?PHP HTML::print(TEXT_CURRENT_PLAN_ROW_MONTHLY_CALLS_DESC); ?></p>
                            </div>
                        </div>
                    </div>
                    <div class="preview-item">
                        <div class="preview-thumbnail">
                            <div class="preview-icon bg-inverse-primary rounded">
                                <i class="mdi mdi-receipt"></i>
                            </div>
                        </div>
                        <div class="preview-item-content d-flex flex-grow">
                            <div class="flex-grow">
                                <h6 class="preview-subject"><?PHP HTML::print(TEXT_CURRENT_PLAN_ROW_BILLING_CYCLE_TITLE); ?>
                                    <span class="float-right small">
                                        <span class="border-right pr-3"><?PHP HTML::print(gmdate("Y-m-d", $Plan->NextBillingCycle)); ?></span>
                                        <span class="text-muted pl-3"><?PHP HTML::print('$' . $Plan->PricePerCycle . ' U.S.'); ?></span>
                                    </span>
                                </h6>
                                <p><?PHP HTML::print(TEXT_CURRENT_PLAN_ROW_BILLING_CYCLE_DESC); ?></p>
                            </div>
                        </div>
                    </div>
                </div>

                <button type="button" class="btn btn-inverse-danger" data-toggle="modal" data-target="#cancel-plan-dialog">
                    <i class="mdi mdi-cancel"></i><?PHP HTML::print(TEXT_CANCEL_PLAN_BUTTON); ?>
                </button>
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

                <div class="form-group">
                    <label for="api_key" class="card-subtitle"><?PHP HTML::print(TEXT_AUTHENTICATION_CARD_API_KEY_TITLE); ?></label>
                    <input type="text" id="api_key" name="api_key" class="form-control" value="<?PHP HTML::print($AccessKeyObject->PublicKey); ?>" readonly>
                </div>

                <div class="form-group">
                    <label for="certificate" class="card-subtitle"><?PHP HTML::print(TEXT_AUTHENTICATION_CARD_CERTIFICATE_TITLE); ?></label>
                    <textarea id="certificate" name="certificate" class="form-control" rows="13" readonly><?PHP HTML::print($AccessKeyObject->Signatures->createCertificate()); ?></textarea>
                </div>

                <hr/>

                <div class="form-group text-right">
                    <button type="button" class="btn btn-inverse-success" onclick="location.href='/api?action=download_certificate';">
                        <i class="mdi mdi-cloud-download"></i><?PHP HTML::print(TEXT_AUTHENTICATION_CARD_DOWNLOAD_CERTIFICATE_BUTTON); ?>
                    </button>
                    <button type="button" class="btn btn-inverse-primary" onclick="location.href='/api?action=update_signatures';">
                        <i class="mdi mdi-refresh"></i><?PHP HTML::print(TEXT_AUTHENTICATION_CARD_UPDATE_SIGNATURES_BUTTON); ?>
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
                <div id="api-usage-chart"></div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="cancel-plan-dialog" tabindex="-1" role="dialog" aria-labelledby="cancel-plan-label" style="display: none;" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="cancel-plan-label"><?PHP HTML::print(TEXT_CANCEL_DIALOG_TITLE); ?></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">
                        <i class="mdi mdi-close"></i>
                    </span>
                </button>
            </div>
            <div class="modal-body">
                <div class="alert alert-fill-danger" role="alert">
                    <i class="mdi mdi-alert-circle"></i>
                    <?PHP HTML::print(TEXT_CANCEL_DIALOG_ALERT); ?>
                </div>
                <p><?PHP HTML::print(TEXT_CANCEL_DIALOG_TEXT); ?></p>
                <p class="text-danger">
                    <?PHP HTML::print(TEXT_CANCEL_DIALOG_WARNING); ?> <i class="mdi mdi-alert"></i>
                </p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light" data-dismiss="modal"><?PHP HTML::print(TEXT_CANCEL_DIALOG_DISMISS_BUTTON); ?></button>
                <button type="button" class="btn btn-danger" onclick="location.href='/api?action=cancel_plan';"><?PHP HTML::print(TEXT_CANCEL_DIALOG_CANCEL_SUBSCRIPTION_BUTTON); ?></button>
            </div>
        </div>
    </div>
</div>