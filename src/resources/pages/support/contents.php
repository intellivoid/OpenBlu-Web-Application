<?PHP
    /** @noinspection PhpUnhandledExceptionInspection */

    use DynamicalWeb\DynamicalWeb;
    use DynamicalWeb\HTML;

    HTML::importScript('submit_report');
    HTML::importScript('alert');
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
                                <?PHP HTML::importScript('callbacks'); ?>
                                <div class="card animated fadeInUp">
                                    <div class="card-body">
                                        <h4 class="card-title"><?PHP HTML::print(TEXT_CARD_TITLE); ?></h4>
                                        <div class="card-description"><?PHP HTML::print(TEXT_CARD_DESC); ?></div>
                                        <div class="border-bottom mb-2"></div>
                                        <form class="mt-3" action="<?PHP DynamicalWeb::getRoute('support', array(), true); ?>" method="POST">
                                            <div class="form-group">
                                                <label for="email"><?PHP HTML::print(TEXT_EMAIL_LABEL); ?></label>
                                                <input type="email" class="form-control" id="email" name="email" placeholder="<?PHP HTML::print(TEXT_EMAIL_PLACEHOLDER); ?>">
                                            </div>
                                            <div class="form-group">
                                                <label for="subject"><?PHP HTML::print(TEXT_SUBJECT_LABEL); ?></label>
                                                <input type="text" class="form-control" id="subject" name="subject" placeholder="<?PHP HTML::print(TEXT_SUBJECT_PLACEHOLDER); ?>">
                                            </div>
                                            <div class="form-group">
                                                <label for="message"><?PHP HTML::print(TEXT_MESSAGE_LABEL); ?></label>
                                                <textarea class="form-control" id="message" name="message" rows="20"></textarea>
                                            </div>
                                            <input type="submit" class="btn btn-inverse-success mr-2" value="<?PHP HTML::print(TEXT_SUBMIT_BUTTON); ?>">
                                        </form>
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
