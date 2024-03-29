<?PHP
    /** @noinspection PhpUnhandledExceptionInspection */
    use DynamicalWeb\DynamicalWeb;
    use DynamicalWeb\HTML;
    use DynamicalWeb\Runtime;
    use OpenBlu\Objects\VPN;
    use OpenBlu\OpenBlu;

    Runtime::import('OpenBlu');

    HTML::importScript('authenticate_coa');
    HTML::importScript('toggle_sidebar');
    HTML::importScript('time_human');
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
                        <div class="row">
                            <div class="col-md-6 grid-margin">
                                <div class="card animated bounceInLeft">
                                    <div class="card-body">
                                        <h4 class="card-title mb-0"><?PHP HTML::print(TEXT_TOTAL_SERVERS_HEADER); ?></h4>
                                        <div class="d-flex justify-content-between align-items-center">
                                            <div class="d-inline-block pt-3">
                                                <div class="d-flex">
                                                    <h2 class="mb-0"><?PHP HTML::print(number_format(CACHE_TOTAL_SERVERS)); ?></h2>
                                                </div>
                                                <small class="text-gray"><?PHP HTML::print(TEXT_TOTAL_SERVERS_DESC); ?></small>
                                            </div>
                                            <div class="d-inline-block">
                                                <div class="bg-info px-4 py-2 rounded">
                                                    <i class="mdi mdi-server text-white icon-lg"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 grid-margin">
                                <div class="card animated bounceInRight">
                                    <div class="card-body">
                                        <h4 class="card-title mb-0"><?PHP HTML::print(TEXT_CURRENT_USERS_HEADER); ?></h4>
                                        <div class="d-flex justify-content-between align-items-center">
                                            <div class="d-inline-block pt-3">
                                                <div class="d-flex">
                                                    <h2 class="mb-0"><?PHP HTML::print(number_format(CACHE_CURRENT_SESSIONS)); ?></h2>
                                                </div>
                                                <small class="text-gray"><?PHP HTML::print(TEXT_CURRENT_USERS_DESC); ?></small>
                                            </div>
                                            <div class="d-inline-block">
                                                <div class="bg-success px-4 py-2 rounded">
                                                    <i class="mdi mdi-account-group text-white icon-lg"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4 grid-margin stretch-card">
                                <div class="card animated fadeInUp">
                                    <div class="card-body">
                                        <h4 class="card-title"><?PHP HTML::print(TEXT_CARD_ANALYTICS_HEADER); ?></h4>
                                        <div id="basic-analytics" class="morris-chart"></div>
                                        <div id="legend" class="donut-legend"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-8 grid-margin stretch-card">
                                <div class="card animated fadeInUp">
                                    <div class="card-body">
                                        <div class="d-flex flex-row">
                                            <div class="align-self-top">
                                                <h4 class="card-title"><?PHP HTML::print(TEXT_CARD_POPULAR_SERVERS_HEADER); ?></h4>
                                                <p><?PHP HTML::print(TEXT_CARD_POPULAR_SERVERS_TEXT); ?></p>
                                            </div>
                                            <div class="align-self-center flex-grow text-right">
                                                <p class="text-muted">
                                                    <a href="<?PHP DynamicalWeb::getRoute('servers', array(), true); ?>"><?PHP HTML::print(TEXT_CARD_POPULAR_SERVERS_VIEW_SERVERS); ?></a>
                                                </p>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-12">
                                                <?PHP
                                                    $PopularServers = $OpenBlu->getVPNManager()->getPopularServers();
                                                    if(count($PopularServers) == 0)
                                                    {
                                                        print("<h4 class=\"text-center pt-lg-4 text-muted\">");
                                                        HTML::print(TEXT_CARD_POPULAR_SERVERS_NO_ITEMS);
                                                        print("</h4>");
                                                    }
                                                    else
                                                    {
                                                        print("<div class=\"preview-list\">");
                                                        HTML::importScript('popular_servers');
                                                        renderPopularServers($OpenBlu->getVPNManager()->getPopularServers());
                                                        print("</div>");
                                                    }
                                                ?>
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
        <?PHP HTML::importScript('render_donut_chart'); ?>
    </body>
</html>
