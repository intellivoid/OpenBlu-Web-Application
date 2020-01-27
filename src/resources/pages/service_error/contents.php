<?PHP
    /** @noinspection PhpUnhandledExceptionInspection */

    use DynamicalWeb\DynamicalWeb;
    use DynamicalWeb\HTML;
    http_response_code(500);
?>
<!DOCTYPE html>
<html lang="<?PHP HTML::print(APP_LANGUAGE_ISO_639); ?>">
    <head>
        <?PHP HTML::importSection('header'); ?>
        <title><?PHP HTML::print(TEXT_PAGE_TITLE); ?></title>
    </head>

    <body<?PHP HTML::print(SIDEBAR_STATE, false); ?>>

        <div class="container-scrollbar">
            <?PHP HTML::importSection('navigation'); ?>
            <div class="container-fluid page-body-wrapper">
                <?PHP HTML::importSection('sidebar'); ?>
                <div class="main-panel">
                    <div class="content-wrapper">

                        <div class="row">
                            <div class="col-12 grid-margin">
                                <div class="card animated fadeInUp">
                                    <div class="card-body">
                                        <h4 class="card-title"><?PHP HTML::print(TEXT_ERROR_CARD_TITLE); ?></h4>
                                        <div class="card-description"><?PHP HTML::print(TEXT_ERROR_CARD_DESC); ?></div>
                                        <button class="btn btn-primary" onclick="location.href='<?PHP DynamicalWeb::getRoute('index', array(), true); ?>'">
                                            <i class="mdi mdi-home"></i><?PHP HTML::print(TEXT_BUTTON_HOME); ?>
                                        </button>
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
