<?PHP

    /** @noinspection PhpUnhandledExceptionInspection */

    use DynamicalWeb\HTML;

    HTML::importScript('check_auth');
    HTML::importScript('auto_redirect');
    HTML::importScript('recaptcha');
    HTML::importScript('register_account');
    HTML::importScript('alert');

    $LoginLocation = '/login';
    $PostLocation = '/register';

    if(isset($_GET['redirect']))
    {
        if($_GET['redirect'] == 'purchase_plan')
        {
            if(isset($_GET['type']))
            {
                switch($_GET['type'])
                {
                    case 'free':
                        $LoginLocation = '/login?redirect=purchase_plan&type=free';
                        $PostLocation = '/register?redirect=purchase_plan&type=free';
                        break;

                    case 'basic':
                        $LoginLocation = '/login?redirect=purchase_plan&type=basic';
                        $PostLocation = '/register?redirect=purchase_plan&type=basic';
                        break;

                    case 'enterprise':
                        $LoginLocation = '/login?redirect=purchase_plan&type=enterprise';
                        $PostLocation = '/register?redirect=purchase_plan&type=enterprise';
                        break;
                }
            }
        }

        if($_GET['redirect'] == 'add_balance')
        {
            $LoginLocation = '/login?redirect=add_balance';
            $PostLocation = '/register?redirect=add_balance';
        }
    }
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
            <div class="container-fluid page-body-wrapper full-page-wrapper">
                <div class="row w-100">
                    <div class="content-wrapper full-page-wrapper auth-pages option-2">
                        <div class="card col-lg-4">
                            <div class="card-body px-5 py-5">
                                <div class="wrapper w-100">
                                    <h3 class="card-title text-left mb-3"><?PHP HTML::print(TEXT_HEADER); ?></h3>
                                    <?PHP HTML::importScript('callbacks'); ?>
                                </div>
                                <form action="<?PHP HTML::print($PostLocation, false); ?>" method="POST">
                                    <div class="form-group">
                                        <label for="username"><?PHP HTML::print(TEXT_FIELD_1); ?></label>
                                        <input type="text" name="username" id="username" class="form-control p_input" title="<?PHP HTML::print(TEXT_FIELD_1); ?>">
                                    </div>
                                    <div class="form-group">
                                        <label for="email"><?PHP HTML::print(TEXT_FIELD_2); ?></label>
                                        <input type="email" name="email" id="email" class="form-control p_input" title="<?PHP HTML::print(TEXT_FIELD_2); ?>">
                                    </div>
                                    <div class="form-group">
                                        <label for="password"><?PHP HTML::print(TEXT_FIELD_3); ?></label>
                                        <input type="password" name="password" id="password" class="form-control p_input" title="<?PHP HTML::print(TEXT_FIELD_3); ?>">
                                    </div>
                                    <div class="form-group">
                                        <?PHP HTML::print(re_render(), false); ?>
                                    </div>
                                    <div class="text-center">
                                        <button type="submit" class="btn btn-primary btn-block enter-btn"><?PHP HTML::print(TEXT_SUBMIT_BUTTON); ?></button>
                                    </div>
                                    <p class="sign-up text-center"><?PHP HTML::print(TEXT_LOGIN); ?><a href="<?PHP HTML::print($LoginLocation, false); ?>"> <?PHP HTML::print(TEXT_LOGIN_LINK); ?></a></p>
                                    <p class="terms">
                                        <a href="#"> <?PHP HTML::print(TEXT_TOS); ?></a>
                                    </p>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?PHP HTML::importSection('js_scripts'); ?>
    </body>
</html>