<?PHP \DynamicalWeb\HTML::importScript('check_auth'); ?>
<?PHP \DynamicalWeb\HTML::importScript('auto_redirect'); ?>
<?PHP \DynamicalWeb\HTML::importScript('recaptcha'); ?>
<?PHP \DynamicalWeb\HTML::importScript('register_account'); ?>
<?PHP \DynamicalWeb\HTML::importScript('alert'); ?>
<!DOCTYPE html>
<html lang="<?PHP \DynamicalWeb\HTML::print(APP_LANGUAGE_ISO_639); ?>">
    <head>
        <?PHP \DynamicalWeb\HTML::importSection('header'); ?>
        <?PHP \DynamicalWeb\HTML::print(re_import(), false); ?>
        <title><?PHP \DynamicalWeb\HTML::print(TEXT_PAGE_TITLE); ?></title>
    </head>
    <body>
        <div class="container-scroller">
            <div class="container-fluid page-body-wrapper full-page-wrapper">
                <div class="row w-100">
                    <div class="content-wrapper full-page-wrapper auth-pages option-2">
                        <div class="card col-lg-4">
                            <div class="card-body px-5 py-5">
                                <div class="wrapper w-100">
                                    <h3 class="card-title text-left mb-3"><?PHP \DynamicalWeb\HTML::print(TEXT_HEADER); ?></h3>
                                    <?PHP \DynamicalWeb\HTML::importScript('callbacks'); ?>
                                </div>
                                <form action="register" method="POST">
                                    <div class="form-group">
                                        <label><?PHP \DynamicalWeb\HTML::print(TEXT_FIELD_1); ?></label>
                                        <input type="text" name="username" id="username" class="form-control p_input" title="<?PHP \DynamicalWeb\HTML::print(TEXT_FIELD_1); ?>">
                                    </div>
                                    <div class="form-group">
                                        <label><?PHP \DynamicalWeb\HTML::print(TEXT_FIELD_2); ?></label>
                                        <input type="email" name="email" id="email" class="form-control p_input" title="<?PHP \DynamicalWeb\HTML::print(TEXT_FIELD_2); ?>">
                                    </div>
                                    <div class="form-group">
                                        <label><?PHP \DynamicalWeb\HTML::print(TEXT_FIELD_3); ?></label>
                                        <input type="password" name="password" id="password" class="form-control p_input" title="<?PHP \DynamicalWeb\HTML::print(TEXT_FIELD_3); ?>">
                                    </div>
                                    <div class="form-group">
                                        <?PHP \DynamicalWeb\HTML::print(re_render(), false); ?>
                                    </div>
                                    <div class="text-center">
                                        <button type="submit" class="btn btn-primary btn-block enter-btn"><?PHP \DynamicalWeb\HTML::print(TEXT_SUBMIT_BUTTON); ?></button>
                                    </div>
                                    <p class="sign-up text-center"><?PHP \DynamicalWeb\HTML::print(TEXT_LOGIN); ?><a href="login"> <?PHP \DynamicalWeb\HTML::print(TEXT_LOGIN_LINK); ?></a></p>
                                    <p class="terms">
                                        <a href="#"> <?PHP \DynamicalWeb\HTML::print(TEXT_TOS); ?></a>
                                    </p>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?PHP \DynamicalWeb\HTML::importSection('js_scripts'); ?>
    </body>
</html>