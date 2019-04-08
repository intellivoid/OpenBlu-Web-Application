<?PHP
    /** @noinspection PhpUnhandledExceptionInspection */

    use DynamicalWeb\HTML;
    use OpenBlu\OpenBlu;

    HTML::importScript('check_auth');
    HTML::importScript('check_selection');
    HTML::importScript('cache');
    HTML::importScript('time_human');

    $OpenBlu = new OpenBlu();
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


                        <div class="row">
                            <div class="col-md-12 grid-margin">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="d-flex flex-row align-items-top">
                                            <i class="flag-icon flag-icon-ca text-primary icon-md"></i>
                                            <div class="ml-3">
                                                <h6 class="text-primary">2.62 Subscribers</h6>
                                                <p class="mt-2 text-muted card-text">You main list growing</p>
                                            </div>
                                        </div>
                                    </div>
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
