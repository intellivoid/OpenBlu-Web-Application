<?PHP \DynamicalWeb\HTML::importScript('check_auth'); ?>
<?PHP \DynamicalWeb\HTML::importScript('check_selection'); ?>
<?PHP \DynamicalWeb\HTML::importScript('cache'); ?>
<?PHP \DynamicalWeb\HTML::importScript('time_human'); ?>
<?PHP $OpenBlu = new \OpenBlu\OpenBlu(); ?>
<!DOCTYPE html>
<html lang="<?PHP \DynamicalWeb\HTML::print(APP_LANGUAGE_ISO_639); ?>">
    <head>
        <?PHP \DynamicalWeb\HTML::importSection('header'); ?>
        <title><?PHP \DynamicalWeb\HTML::print(TEXT_PAGE_TITLE); ?></title>
    </head>

    <body>

        <div class="container-scrollbar">
            <?PHP \DynamicalWeb\HTML::importSection('navigation'); ?>
            <div class="container-fluid page-body-wrapper">
                <?PHP \DynamicalWeb\HTML::importSection('sidebar'); ?>
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

            <?PHP \DynamicalWeb\HTML::importSection('footer'); ?>
        </div>
        <?PHP \DynamicalWeb\HTML::importSection('js_scripts'); ?>
    </body>
</html>
