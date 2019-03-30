<!DOCTYPE html>
<html lang="<?PHP \DynamicalWeb\HTML::print(APP_LANGUAGE_ISO_639); ?>">
    <head>
        <?PHP \DynamicalWeb\HTML::importSection('header'); ?>
        <title>Login to OpenBlu</title>
    </head>
    <body>
        <div class="container-scroller">
            <div class="container-fluid page-body-wrapper full-page-wrapper">
                <div class="row w-100">
                    <div class="content-wrapper full-page-wrapper auth-pages login-2">
                        <div class="card col-lg-4">
                            <div class="card-body px-5 py-5">
                                <h3 class="card-title text-left mb-3">Intellivoid Accounts</h3>
                                <form>
                                    <div class="form-group">
                                        <label>Username or email *</label>
                                        <input type="text" class="form-control p_input">
                                    </div>
                                    <div class="form-group">
                                        <label>Password *</label>
                                        <input type="text" class="form-control p_input">
                                    </div>
                                    <div class="text-center">
                                        <button type="submit" class="btn btn-primary btn-block enter-btn">Login</button>
                                    </div>

                                    <p class="sign-up">Don't have an Intellivoid Account?<a href="register"> Sign Up</a></p>
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