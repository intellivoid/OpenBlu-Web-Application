<?PHP

    use DynamicalWeb\DynamicalWeb;
    use DynamicalWeb\HTML;
    use ModularAPI\Abstracts\AccessKeySearchMethod;
    use ModularAPI\ModularAPI;
    use ModularAPI\Utilities\Hashing;

    if(class_exists('ModularAPI\ModularAPI') == false)
    {
        DynamicalWeb::loadLibrary('ModularAPI', 'ModularAPI', 'ModularAPI');
    }

    $ModularAPI = new ModularAPI();
    $AccessKeyObject = $ModularAPI->AccessKeys()->Manager->get(AccessKeySearchMethod::byID, CACHE_SUBSCRIPTION_ACCESS_KEY_ID);

?>
<div class="row">

    <div class="col-md-6 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Current Plan</h4>
                <div class="alert alert-fill-primary" role="alert">
                    Your billing cycle will only be processed when the API is being used, your plan will not
                    be cancelled unless you cancel it manually
                </div>
                <div class="preview-list">
                    <div class="preview-item border-bottom">
                        <div class="preview-thumbnail">
                            <div class="preview-icon bg-inverse-primary rounded">
                                <i class="mdi mdi-chart-pie"></i>
                            </div>
                        </div>
                        <div class="preview-item-content d-flex flex-grow">
                            <div class="flex-grow">
                                <h6 class="preview-subject">Plan Type
                                    <span class="float-right small">
                                        <span class="text-muted border-right pr-3">Basic</span>
                                        <span class="text-muted pl-3">Intellivoid Telegram Promotion</span>
                                    </span>
                                </h6>
                                <p>The current plan that this API is running on</p>
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
                                <h6 class="preview-subject">Monthly Calls
                                    <span class="float-right small">
                                        <span class="text-muted border-right pr-3">5000</span>
                                        <span class="text-muted pl-3">13 calls this month</span>
                                    </span>
                                </h6>
                                <p>The amount of monthly calls you can make with this plan</p>
                            </div>
                        </div>
                    </div>
                    <div class="preview-item">
                        <div class="preview-thumbnail">
                            <div class="preview-icon bg-inverse-primary rounded">
                                <i class="mdi mdi-chart-pie"></i>
                            </div>
                        </div>
                        <div class="preview-item-content d-flex flex-grow">
                            <div class="flex-grow">
                                <h6 class="preview-subject">Next Billing Cycle <span class="float-right small">
                                    <span class="float-right small">
                                        <span class="text-muted border-right pr-3">08.07.2017</span>
                                    </span>
                                </h6>
                                <p>The date for when the system will process your next billing cycle</p>
                            </div>
                        </div>
                    </div>


                </div>

                <button type="button" class="btn btn-inverse-danger">
                    <i class="mdi mdi-refresh"></i>Cancel Plan
                </button>

            </div>
        </div>
    </div>

    <div class="col-md-6 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Authentication</h4>
                <p class="card-description">Authentication details for using the OpenBlu API</p>

                <div class="form-group">
                    <label for="api_key" class="card-subtitle">API Key</label>
                    <input type="text" id="api_key" name="api_key" class="form-control" value="<?PHP HTML::print($AccessKeyObject->PublicKey); ?>" readonly>
                </div>

                <div class="form-group">
                    <label for="certificate" class="card-subtitle">Certificate</label>
                    <textarea id="certificate" name="certificate" class="form-control" rows="11" readonly><?PHP HTML::print(Hashing::buildCertificateKey(
                            $AccessKeyObject->Signatures->IssuerName,
                            $AccessKeyObject->Signatures->PrivateSignature,
                            $AccessKeyObject->Signatures->PublicSignature
                        )); ?></textarea>
                </div>

                <hr/>

                <div class="form-group text-right">
                    <button type="button" class="btn btn-inverse-success">
                        <i class="mdi mdi-cloud-download"></i>Download Certificate
                    </button>
                    <button type="button" class="btn btn-inverse-primary">
                        <i class="mdi mdi-refresh"></i>Update Signatures
                    </button>
                </div>

            </div>
        </div>
    </div>

</div>

<div class="row grid-margin">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">API Usage</h4>
                <div id="api-usage-chart"></div>
            </div>
        </div>
    </div>
</div>