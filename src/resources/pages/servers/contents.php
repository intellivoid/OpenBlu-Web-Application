<?PHP

    /** @noinspection PhpUnhandledExceptionInspection */

    use DynamicalWeb\DynamicalWeb;
    use DynamicalWeb\HTML;
    use DynamicalWeb\Runtime;
use msqg\Abstracts\SortBy;
use msqg\QueryBuilder;
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
    HTML::importScript('db_render_helper');

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

    $where = null;
    $where_value = null;

    if(isset($_GET['filter']))
    {
        if ($_GET['filter'] == 'country_short')
        {
            if (isset($_GET['value']))
            {
                if(strlen($_GET['value']) < 5)
                {
                    $where = 'country_short';
                    $where_value = $OpenBlu->database->real_escape_string(strtolower($_GET['value']));
                }

            }
        }
    }

    $order_by = 'last_updated';
    $sort_by = SortBy::descending;

    if(isset($_GET['order_by']))
    {
        switch(strtolower($_GET['order_by']))
        {
            case 'last_updated':
            case 'ping':
            case 'sessions':
                $order_by = strtolower($_GET['order_by']);
                break;
        }
    }

    if(isset($_GET['sort_by']))
    {
        switch(strtolower($_GET['sort_by']))
        {
            case 'ascending':
                $sort_by = SortBy::ascending;
                break;

            case 'descending':
                $sort_by = SortBy::descending;
                break;
        }
    }

    $Results = get_results($OpenBlu->database, 1000, 'vpns', 'id',
        QueryBuilder::select(
            'vpns', ['id', 'public_id', 'country', 'country_short', 'ping', 'sessions', 'total_sessions', 'last_updated'],
            $where, $where_value, $order_by, $sort_by
        ),
        $where, $where_value);

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
                                    <div class="card-header header-sm d-flex justify-content-between align-items-center">
                                        <h4 class="card-title mt-auto mb-auto">Servers</h4>
                                        <div class="wrapper d-flex align-items-center">
                                            <?PHP
                                                if(isset($_GET['order_by']))
                                                {
                                                    ?>
                                                    <button class="btn btn-transparent icon-btn arrow-disabled pl-2 pr-2 text-white text-small" onclick="location.href='<?PHP DynamicalWeb::getRoute('servers', array(), true); ?>';" type="button">
                                                        <i class="mdi mdi-close"></i>
                                                    </button>
                                                    <?PHP
                                                }
                                            ?>
                                            <button class="btn btn-transparent icon-btn arrow-disabled pl-2 pr-2 text-white text-small" data-toggle="modal" data-target="#filterDialog" type="button">
                                                <i class="mdi mdi-filter"></i>
                                            </button>
                                        </div>
                                    </div>
                                    <div class="card-body">

                                        <?PHP
                                            $current_page = 1;
                                            if(isset($_GET['page']))
                                            {
                                                $current_page = (int)$_GET['page'];
                                            }

                                            $total_pages = $Results['total_pages'];

                                            if($total_pages == 0)
                                            {
                                                render_alert("No results were found", 'primary', 'alert-circle');
                                                HTML::print('<a href="' . DynamicalWeb::getRoute('servers') . '">' . TEXT_RELOAD_PAGE_LINK . '</a>', false);
                                            }
                                            elseif($current_page < 1)
                                            {
                                                render_alert(TEXT_PAGE_NOT_FOUND_ERROR, 'danger', 'alert-circle');
                                                HTML::print('<a href="' . DynamicalWeb::getRoute('servers') . '">' . TEXT_RELOAD_PAGE_LINK . '</a>', false);
                                            }
                                            elseif($current_page > $total_pages)
                                            {
                                                render_alert(TEXT_PAGE_NOT_FOUND_ERROR, 'danger', 'alert-circle');
                                                HTML::print('<a href="' . DynamicalWeb::getRoute('servers') . '">' . TEXT_RELOAD_PAGE_LINK . '</a>', false);
                                            }
                                            else
                                            {
                                                render_table($Results);
                                            }
                                        ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?PHP HTML::importScript('filter_dialog'); ?>
                </div>
            </div>
            <?PHP HTML::importSection('footer'); ?>
        </div>
        <?PHP HTML::importSection('js_scripts'); ?>
        <script src="/assets/js/app-table-animations.js"></script>
        <script>
            function process_download(server_id)
            {
                $.ajax({
                    type: "GET",
                    url: "<?PHP DynamicalWeb::getRoute('server', array('action' => 'gen_token'), true); ?>&pub_id={0}".format(server_id),
                    success: function(results)
                    {
                        if(results.success === false)
                        {
                            if(results.message === "authentication_required")
                            {
                                show_notification(
                                    "<?PHP HTML::print(TEXT_NOTIFICATION_AUTH_REQUIRED_TITLE); ?>",
                                    "<?PHP HTML::print(TEXT_NOTIFICATION_AUTH_REQUIRED_MESSAGE); ?>",
                                    "error"
                                );
                            }
                            else
                            {
                                show_notification(
                                    "<?PHP HTML::print(TEXT_NOTIFICATION_DOWNLOAD_ERROR_TITLE); ?>",
                                    "<?PHP HTML::print(TEXT_NOTIFICATION_DOWNLOAD_ERROR_MESSAGE); ?>",
                                    "error"
                                );
                            }
                        }
                        else
                        {
                            show_notification(
                                "<?PHP HTML::print(TEXT_NOTIFICATION_DOWNLOAD_STARTED_TITLE); ?>",
                                "<?PHP HTML::print(TEXT_NOTIFICATION_DOWNLOAD_STARTED_MESSAGE); ?>",
                                "success"
                            );
                            location.href = '<?PHP DynamicalWeb::getRoute('server', array('action' => 'download'), true); ?>&token={0}'.format(results.download_token);
                        }
                    }
                });
            }
        </script>
    </body>
</html>
