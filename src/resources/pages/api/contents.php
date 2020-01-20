<?PHP
    /** @noinspection PhpUnhandledExceptionInspection */

    use DynamicalWeb\HTML;

    HTML::importScript('check_subscription');

    if(WEB_SUBSCRIPTION_ACTIVE == true)
    {
        //HTML::importScript('dashboard_actions');
    }

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

                        <?PHP
                            if(WEB_SUBSCRIPTION_ACTIVE == false)
                            {
                                HTML::importScript('render_pricing');
                            }
                            else
                            {
                                HTML::importScript('render_dashboard');
                            }
                        ?>

                    </div>
                </div>
            </div>

            <?PHP HTML::importSection('footer'); ?>
        </div>

        <?PHP HTML::importSection('js_scripts'); ?>
        <?PHP
            if(WEB_SUBSCRIPTION_ACTIVE == true)
            {
                //HTML::importScript('render_charts_js');
            }
       ?>
    </body>
</html>
