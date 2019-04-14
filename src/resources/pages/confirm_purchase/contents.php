<?PHP
    /** @noinspection PhpUnhandledExceptionInspection */

    use DynamicalWeb\HTML;

    HTML::importScript('check_auth');
    HTML::importScript('cache');
    HTML::importScript('alert');
    HTML::importScript('check_product');

    $TypeURL = 'None';

    switch($_GET['plan'])
    {
        case 'free': $TypeURL = 'free'; break;
        case 'basic': $TypeURL = 'basic'; break;
        case 'enterprise': $TypeURL = 'enterprise'; break;

    }
?>
<!DOCTYPE html>
<html lang="<?PHP HTML::print(APP_LANGUAGE_ISO_639); ?>">
    <head>
        <?PHP HTML::importSection('header'); ?>
        <title><?PHP HTML::print(TEXT_PAGE_TITLE); ?></title>
    </head>

    <body>

        <div class="container-scrollbar">
            <?PHP HTML::importSection('navigation'); ?>
            <div class="container-fluid page-body-wrapper">
                <?PHP HTML::importSection('sidebar'); ?>
                <div class="main-panel">
                    <div class="content-wrapper">

                        <div class="col-12">
                            <?PHP HTML::importScript('callbacks'); ?>
                            <div class="card">
                                <div class="card-body">

                                    <h4 class="card-title">Confirm Purchase</h4>
                                    <p class="card-description"> Please confirm the purchase of this subscription.</p>

                                    <table class="table">
                                        <tbody>
                                        <tr>
                                            <td>Plan Name</td>
                                            <td><?PHP HTML::print(PLAN_NAME); ?></td>
                                        </tr>
                                        <tr>
                                            <td>Monthly Calls</td>
                                            <td><?PHP HTML::print(PLAN_CALLS_MONTHLY); ?></td>
                                        </tr>
                                        <tr>
                                            <td>Billing Cycle</td>
                                            <td><?PHP HTML::print(PLAN_BILLING_CYCLE); ?></td>
                                        </tr>
                                        <tr>
                                            <td>Price</td>
                                            <td><?PHP HTML::print(PLAN_PRICE); ?></td>
                                        </tr>
                                        </tbody>
                                    </table>

                                </div>

                                <?PHP
                                    if(PROMOTION_SET == false)
                                    {
                                        ?>
                                        <div class="card-body">
                                            <h4 class="card-title">Promotion Code (Optional)</h4>
                                            <p class="card-description"> If you have a promotion code to receive a special offer, you can enter it below and verify it</p>
                                            <form action="confirm_purchase" method="GET">
                                                <input type="hidden" name="plan" id="plan" value="<?PHP HTML::print($TypeURL, true); ?>">
                                                <div class="form-group">
                                                    <label for="promotion_code">Promotion Code</label>
                                                    <input type="text" class="form-control" name="promotion_code" id="promotion_code" placeholder="Enter Promotion Code">
                                                </div>

                                                <button type="submit" class="btn btn-inverse-info btn-lg mr-2">Verify</button>
                                            </form>
                                        </div>
                                        <?PHP
                                    }
                                ?>

                                <div class="card-body">
                                    <a href="#" class="btn btn-outline-primary float-right">Confirm Purchase</a>
                                </div>
                            </div>
                        </div>


                    </div>
                </div>
            </div>

            <?PHP HTML::importSection('footer'); ?>
        </div>

        <?PHP HTML::importSection('js_scripts'); ?>

    </body>
</html>
