<?PHP
    /** @noinspection PhpUnhandledExceptionInspection */

    use DynamicalWeb\HTML;

    HTML::importScript('auto_redirect');
    HTML::importScript('recaptcha');
    HTML::importScript('login_account');
    HTML::importScript('alert');

?>
<!DOCTYPE html>
<html lang="<?PHP HTML::print(APP_LANGUAGE_ISO_639); ?>">
    <head>
        <?PHP HTML::importSection('header'); ?>
        <?PHP HTML::print(re_import(), false); ?>
        <title><?PHP HTML::print(TEXT_PAGE_TITLE); ?></title>
    </head>
    <body>
        <div class="container-scroller">
            <?PHP
                if(CLIENT_MODE_ENABLED == false)
                {
                    ?>
                    <div class="container-fluid page-body-wrapper full-page-wrapper">
                        <div class="row w-100" style="margin-right: 0px; margin-left: 0px;">
                            <div class="content-wrapper full-page-wrapper auth-pages login-2">
                                <div class="card col-lg-4">
                                    <div class="card-body px-5 py-5">
                                        <?PHP HTML::importScript('login_contents'); ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?PHP
                }
                else
                {
                    ?>
                    <div class="container-fluid page-body-wrapper full-page-wrapper">
                        <div class="row w-100" style="margin-left: 0; margin-right: 0;">
                            <div class="content-wrapper full-page-wrapper auth-pages login-2">
                                <div class="card">
                                    <div class="card-body px-5 py-5">
                                        <?PHP HTML::importScript('login_contents'); ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?PHP
                }
            ?>

        </div>
        <?PHP HTML::importSection('js_scripts'); ?>
    </body>
</html>