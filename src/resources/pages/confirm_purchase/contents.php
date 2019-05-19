<?PHP
    /** @noinspection PhpUnhandledExceptionInspection */

    use DynamicalWeb\HTML;

    HTML::importScript('check_auth');
    HTML::importScript('cache');

    if(WEB_SESSION_ACTIVE == false)
    {
        header('Location: /');
        exit();
    }

    if(CACHE_SUBSCRIPTION_ACTIVE == true)
    {
        header('Location: /api');
        exit();
    }

    HTML::importScript('alert');
    HTML::importScript('check_product');

    $TypeURL = 'None';

    switch($_GET['plan'])
    {
        case 'free': $TypeURL = 'free'; break;
        case 'basic': $TypeURL = 'basic'; break;
        case 'enterprise': $TypeURL = 'enterprise'; break;
    }

    $PurchaseURL = '';

    if(isset($_GET['promotion_code']))
    {
        $PurchaseURL = '/confirm_purchase?plan=' . $TypeURL . '&promotion_code=' . urlencode($_GET['promotion_code']) . '&action=complete_purchase';
    }
    else
    {
        $PurchaseURL = '/confirm_purchase?plan=' . $TypeURL . '&action=complete_purchase';
    }

    if(isset($_GET['action']))
    {
        if($_GET['action'] == 'complete_purchase')
        {
            HTML::importScript('process_transaction');
        }
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
                            <div class="card animated fadeInUp">
                                <div class="card-body">

                                    <h4 class="card-title"><?PHP HTML::print(TEXT_DETAILS_HEADER); ?></h4>
                                    <p class="card-description"><?PHP HTML::print(TEXT_DETAILS_DESC); ?></p>

                                    <table class="table">
                                        <tbody>
                                        <tr class="animated fadeInLeft">
                                            <td><?PHP HTML::print(TEXT_DETAILS_PLAN_NAME); ?></td>
                                            <td><?PHP HTML::print(PLAN_NAME); ?></td>
                                        </tr>
                                        <tr class="animated fadeInLeft">
                                            <td><?PHP HTML::print(TEXT_DETAILS_MONTHLY_CALLS); ?></td>
                                            <td><?PHP HTML::print(PLAN_CALLS_MONTHLY); ?></td>
                                        </tr>
                                        <tr class="animated fadeInLeft">
                                            <td><?PHP HTML::print(TEXT_DETAILS_BILLING_CYCLE); ?></td>
                                            <td><?PHP HTML::print(PLAN_BILLING_CYCLE); ?></td>
                                        </tr>
                                        <tr class="animated fadeInLeft">
                                            <td><?PHP HTML::print(TEXT_DETAILS_PRICE); ?></td>
                                            <td><?PHP HTML::print(PLAN_PRICE); ?></td>
                                        </tr>
                                        </tbody>
                                    </table>

                                </div>

                                <?PHP
                                    if(PROMOTION_SET == false)
                                    {
                                        ?>
                                        <div class="card-body animated fadeIn">
                                            <h4 class="card-title"><?PHP HTML::print(TEXT_PROMOTION_HEADER); ?></h4>
                                            <p class="card-description"><?PHP HTML::print(TEXT_PROMOTION_DESC); ?></p>
                                            <form action="confirm_purchase" method="GET">
                                                <input type="hidden" name="plan" id="plan" value="<?PHP HTML::print($TypeURL, true); ?>">
                                                <div class="form-group">
                                                    <label for="promotion_code"><?PHP HTML::print(TEXT_PROMOTION_LABEL); ?></label>
                                                    <input type="text" class="form-control" name="promotion_code" id="promotion_code" placeholder="<?PHP HTML::print(TEXT_PROMOTION_PLACEHOLDER); ?>">
                                                </div>

                                                <button type="submit" class="btn btn-inverse-info btn-lg mr-2"><?PHP HTML::print(TEXT_PROMOTION_SUBMIT_BUTTON); ?></button>
                                            </form>
                                        </div>
                                        <?PHP
                                    }
                                ?>

                                <div class="card-body">
                                    <button type="button" onclick="location.href='<?PHP HTML::print($PurchaseURL); ?>';" class="btn btn-outline-primary float-right"><?PHP HTML::print(TEXT_CONFIRM_PURCHASE_BUTTON); ?></button>
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
