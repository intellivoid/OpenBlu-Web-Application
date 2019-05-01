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

            </div>
        </div>
    </div>

    <div class="col-md-6 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Authentication</h4>
                <p class="card-description">Authentication details for using the OpenBlu API</p>

                <div class="row grid-margin">
                    <label for="api_key" class="card-subtitle">API Key</label>
                    <input type="text" id="api_key" name="api_key" class="form-control" value="<?PHP HTML::print($AccessKeyObject->PublicKey); ?>" readonly>
                </div>
                <div class="row grid-margin">
                    <label for="certificate" class="card-subtitle">Certificate</label>
                    <textarea id="certificate" name="certificate" class="form-control" rows="13" readonly><?PHP HTML::print(Hashing::buildCertificateKey(
                            $AccessKeyObject->Signatures->IssuerName,
                            $AccessKeyObject->Signatures->PrivateSignature,
                            $AccessKeyObject->Signatures->PublicSignature
                        )); ?></textarea>
                </div>

                <div class="text-right">
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