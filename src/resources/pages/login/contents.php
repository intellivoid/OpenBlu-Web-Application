<!DOCTYPE html>
<html lang="<?PHP \DynamicalWeb\HTML::print(APP_LANGUAGE_ISO_639); ?>">
    <head>
        <?PHP \DynamicalWeb\HTML::importSection('header'); ?>
        <title><?PHP \DynamicalWeb\HTML::print(TEXT_PAGE_TITLE); ?></title>
    </head>
    <body>
        <div class="container-scroller">
            <div class="container-fluid page-body-wrapper full-page-wrapper">
                <div class="row w-100">
                    <div class="content-wrapper full-page-wrapper auth-pages login-2">
                        <div class="card col-lg-4">
                            <div class="card-body px-5 py-5">
                                <h3 class="card-title text-left mb-3"><?PHP \DynamicalWeb\HTML::print(TEXT_HEADER); ?></h3>
                                <form>

                                    <div class="form-group">
                                        <label><?PHP \DynamicalWeb\HTML::print(TEXT_FIELD_1); ?></label>
                                        <input type="text" class="form-control p_input" title="<?PHP \DynamicalWeb\HTML::print(TEXT_FIELD_1); ?>">
                                    </div>
                                    <div class="form-group">
                                        <label><?PHP \DynamicalWeb\HTML::print(TEXT_FIELD_2); ?></label>
                                        <input type="text" class="form-control p_input" title="<?PHP \DynamicalWeb\HTML::print(TEXT_FIELD_2); ?>">
                                    </div>
                                    <div class="text-center">
                                        <button type="submit" class="btn btn-primary btn-block enter-btn"><?PHP \DynamicalWeb\HTML::print(TEXT_SUBMIT_BUTTON); ?></button>
                                    </div>

                                    <p class="sign-up"><?PHP \DynamicalWeb\HTML::print(TEXT_REGISTER); ?><a href="register"> <?PHP \DynamicalWeb\HTML::print(TEXT_REGISTER_LINK); ?></a></p>
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