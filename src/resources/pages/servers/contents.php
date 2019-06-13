<?PHP

    /** @noinspection PhpUnhandledExceptionInspection */

use DynamicalWeb\DynamicalWeb;
use DynamicalWeb\HTML;
    use DynamicalWeb\Runtime;
    use OpenBlu\OpenBlu;

    Runtime::import('OpenBlu');

    if(isset($_GET['action']))
    {
        if($_GET['action'] == 'select')
        {
            if(isset($_GET['token']))
            {
                HTML::importScript('select_vpn');
            }
        }
    }

    HTML::importScript('time_human');
    HTML::importScript('table');
    HTML::importScript('alert');

    if(isset(DynamicalWeb::$globalObjects['openblu']) == false)
    {
        /** @var OpenBlu $OpenBlu */
        $OpenBlu = DynamicalWeb::setMemoryObject('openblu', new OpenBlu());
    }
    else
    {
        /** @var OpenBlu $OpenBlu */
        $OpenBlu = DynamicalWeb::getMemoryObject('openblu');
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
                        <?PHP HTML::importScript('callbacks'); ?>
                        <div class="row grid-margin">
                            <div class="col-12">
                                <div class="card" id="servers_table">
                                    <div class="card-body">
                                        <h4 class="card-title">Servers</h4>
                                        <?PHP
                                            $current_page = 1;
                                            if(isset($_GET['page']))
                                            {
                                                $current_page = (int)$_GET['page'];
                                            }

                                            $total_pages = $OpenBlu->getVPNManager()->totalServerPages();

                                            if($total_pages == 0)
                                            {
                                                render_alert(TEXT_NO_SERVERS_AVAILABLE_ERROR, 'primary', 'alert-circle');
                                                HTML::print('<a href="servers">' . TEXT_RELOAD_PAGE_LINK . '</a>', false);
                                            }
                                            elseif($current_page < 1)
                                            {
                                                render_alert(TEXT_PAGE_NOT_FOUND_ERROR, 'danger', 'alert-circle');
                                                HTML::print('<a href="servers">' . TEXT_RELOAD_PAGE_LINK . '</a>', false);
                                            }
                                            elseif($current_page > $total_pages)
                                            {
                                                render_alert(TEXT_PAGE_NOT_FOUND_ERROR, 'danger', 'alert-circle');
                                                HTML::print('<a href="servers">' . TEXT_RELOAD_PAGE_LINK . '</a>', false);
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
            <?PHP HTML::importSection('footer'); ?>
        </div>
        <?PHP HTML::importSection('js_scripts'); ?>
        <script src="/assets/js/app-table-animations.js"></script>
    </body>
</html>
