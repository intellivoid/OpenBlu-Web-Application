<?PHP
    /** @noinspection PhpUnhandledExceptionInspection */
    use DynamicalWeb\HTML;
    
    if(WEB_SESSION_ACTIVE == true)
    {
        header('Location: /');
        exit();
    }

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
                                        <h4 class="card-title text-danger">
                                            <i class="mdi mdi-lock"></i><?PHP HTML::print(TEXT_CARD_TITLE); ?>
                                        </h4>
                                        <div class="card-description"><?PHP HTML::print(TEXT_CARD_DESC); ?></div>
                                        <div class="border-bottom"></div>
                                        <br/>

                                        <div class="text-center">
                                            <div class="justify-content-center">

                                                <div class="d-inline-block pr-1">
                                                    <div class="bg-primary px-4 py-2 rounded" onclick="location.href='/login'">
                                                        <i class="mdi mdi-login text-white icon-lg"></i>
                                                    </div>
                                                </div>
                                                <div class="d-inline-block pt-3">
                                                    <div class="d-flex">
                                                        <h2 class="mb-0"><?PHP HTML::print(TEXT_LOGIN_BLOCK_TITLE); ?></h2>
                                                    </div>
                                                    <small class="text-gray"><?PHP HTML::print(TEXT_LOGIN_BLOCK_DESC); ?></small>
                                                    <div class="d-flex">
                                                        <button class="btn btn-primary" onclick="location.href='/login'"><?PHP HTML::print(TEXT_LOGIN_BLOCK_BUTTON) ?></button>
                                                    </div>
                                                </div>

                                                <div class="d-inline-block pr-1 pl-5">
                                                    <div class="bg-danger px-4 py-2 rounded" onclick="location.href='/register'">
                                                        <i class="mdi mdi-account-plus text-white icon-lg"></i>
                                                    </div>
                                                </div>
                                                <div class="d-inline-block pt-3">
                                                    <div class="d-flex">
                                                        <h2 class="mb-0"><?PHP HTML::print(TEXT_REGISTER_BLOCK_TITLE); ?></h2>
                                                    </div>
                                                    <small class="text-gray"><?PHP HTML::print(TEXT_REGISTER_BLOCK_DESC); ?></small>
                                                    <div class="d-flex">
                                                        <button class="btn btn-danger" onclick="location.href='/register'"><?PHP HTML::print(TEXT_REGISTER_BLOCK_BUTTON); ?></button>
                                                    </div>
                                                </div>
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
