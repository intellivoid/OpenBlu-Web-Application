<?PHP \DynamicalWeb\HTML::importScript('check_auth'); ?>
<?PHP
    if(isset($_GET['action']))
    {
        if($_GET['action'] == 'select')
        {
            if(isset($_GET['token']))
            {
                \DynamicalWeb\HTML::importScript('select_vpn');
            }
        }
    }
?>
<?PHP \DynamicalWeb\HTML::importScript('time_human'); ?>
<?PHP \DynamicalWeb\HTML::importScript('table'); ?>
<?PHP \DynamicalWeb\HTML::importScript('alert'); ?>
<?PHP \DynamicalWeb\DynamicalWeb::loadLibrary('OpenBlu', 'OpenBlu', 'OpenBlu.php'); ?>
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
                        <div class="row grid-margin">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-body">
                                        <h4 class="card-title">Servers</h4>
                                        <?PHP
                                            $current_page = 1;
                                            if(isset($_GET['page']))
                                            {
                                                $current_page = (int)$_GET['page'];
                                            }

                                            $total_pages = $OpenBlu->getVPNManager()->totalServerPages();

                                            if($current_page < 1)
                                            {
                                                render_alert(TEXT_PAGE_NOT_FOUND_ERROR, 'danger', 'alert-circle');
                                                \DynamicalWeb\HTML::print('<a href="servers">' . TEXT_RELOAD_PAGE_LINK . '</a>', false);
                                            }
                                            elseif($current_page > $total_pages)
                                            {
                                                render_alert(TEXT_PAGE_NOT_FOUND_ERROR, 'danger', 'alert-circle');
                                                \DynamicalWeb\HTML::print('<a href="servers">' . TEXT_RELOAD_PAGE_LINK . '</a>', false);
                                            }
                                            else
                                            {
                                                render_table($OpenBlu);
                                            }
                                        ?>
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
        <script src="/assets/js/app-table-animations.js"></script>
    </body>
</html>
