<?PHP \DynamicalWeb\HTML::importScript('check_auth'); ?>
<?PHP \DynamicalWeb\HTML::importScript('cache'); ?>
<?PHP \DynamicalWeb\HTML::importScript('time_human'); ?>
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

                        <div class="row">
                            <div class="col-md-6 grid-margin">
                                <div class="card animated bounceInLeft">
                                    <div class="card-body">
                                        <h4 class="card-title mb-0"><?PHP \DynamicalWeb\HTML::print(TEXT_TOTAL_SERVERS_HEADER); ?></h4>
                                        <div class="d-flex justify-content-between align-items-center">
                                            <div class="d-inline-block pt-3">
                                                <div class="d-flex">
                                                    <h2 class="mb-0"><?PHP \DynamicalWeb\HTML::print(number_format(CACHE_TOTAL_SERVERS)); ?></h2>
                                                </div>
                                                <small class="text-gray"><?PHP \DynamicalWeb\HTML::print(TEXT_TOTAL_SERVERS_DESC); ?></small>
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
                                        <h4 class="card-title mb-0"><?PHP \DynamicalWeb\HTML::print(TEXT_CURRENT_USERS_HEADER); ?></h4>
                                        <div class="d-flex justify-content-between align-items-center">
                                            <div class="d-inline-block pt-3">
                                                <div class="d-flex">
                                                    <h2 class="mb-0"><?PHP \DynamicalWeb\HTML::print(number_format(CACHE_CURRENT_SESSIONS)); ?></h2>
                                                </div>
                                                <small class="text-gray"><?PHP \DynamicalWeb\HTML::print(TEXT_CURRENT_USERS_DESC); ?></small>
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
                            <div class="col-md-12 grid-margin">
                                <div class="card animated bounceIn">
                                    <div class="card-body">
                                        <h4 class="card-title"><?PHP \DynamicalWeb\HTML::print(TEXT_SUPPORT_SERVICE_HEADER); ?></h4>
                                        <p class="card-description"><?PHP \DynamicalWeb\HTML::print(TEXT_SUPPORT_SERVICE_TEXT); ?></p>

                                        <hr/>
                                        <div class="row">
                                            <div class="col-12">
                                                <h5><?PHP \DynamicalWeb\HTML::print(TEXT_DONATE_HEADER); ?></h5>
                                                <p><?PHP \DynamicalWeb\HTML::print(TEXT_DONATE_TEXT); ?></p>
                                                <a class="btn btn-primary btn-rounded btn-lg btn-fw">
                                                    <i class="mdi mdi-paypal"></i><?PHP \DynamicalWeb\HTML::print(TEXT_DONATE_BUTTON_TEXT); ?>
                                                </a>
                                            </div>
                                        </div>

                                        <hr/>
                                        <div class="row">
                                            <div class="col-12">
                                                <h5><?PHP \DynamicalWeb\HTML::print(TEXT_API_HEADER); ?></h5>
                                                <p><?PHP \DynamicalWeb\HTML::print(TEXT_API_TEXT); ?></p>
                                                <a class="btn btn-danger btn-rounded btn-lg btn-fw">
                                                    <i class="mdi mdi-console"></i><?PHP \DynamicalWeb\HTML::print(TEXT_API_BUTTON_TEXT); ?>
                                                </a>
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
                                        <h4 class="card-title"><?PHP \DynamicalWeb\HTML::print(TEXT_CARD_ANALYTICS_HEADER); ?></h4>

                                        <div class="row mt-3">
                                            <div class="col-12 bg-gray-dark d-flex flex-row py-3 px-4 rounded">
                                                <div class="align-self-top">
                                                    <h6 class="mb-1"><?PHP \DynamicalWeb\HTML::print(TEXT_CARD_ANALYTICS_TOTAL_CURRENT_SESSIONS_TEXT); ?></h6>
                                                </div>
                                                <div class="align-self-center flex-grow text-right">
                                                    <h6 class="font-weight-bold mb-0"><?PHP \DynamicalWeb\HTML::print(number_format(CACHE_CURRENT_SESSIONS)); ?></h6>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row mt-3">
                                            <div class="col-12 bg-gray-dark d-flex flex-row py-3 px-4 rounded">
                                                <div class="align-self-top">
                                                    <h6 class="mb-1"><?PHP \DynamicalWeb\HTML::print(TEXT_CARD_ANALYTICS_TOTAL_VPN_SERVERS); ?></h6>
                                                </div>
                                                <div class="align-self-center flex-grow text-right">
                                                    <h6 class="font-weight-bold mb-0"><?PHP \DynamicalWeb\HTML::print(number_format(CACHE_TOTAL_SERVERS)); ?></h6>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                            <div class="col-md-8 grid-margin stretch-card">
                                <div class="card animated fadeInUp">
                                    <div class="card-body">
                                        <div class="d-flex flex-row">
                                            <div class="align-self-top">
                                                <h4 class="card-title"><?PHP \DynamicalWeb\HTML::print(TEXT_CARD_POPULAR_SERVERS_HEADER); ?></h4>
                                                <p><?PHP \DynamicalWeb\HTML::print(TEXT_CARD_POPULAR_SERVERS_TEXT); ?></p>
                                            </div>
                                            <div class="align-self-center flex-grow text-right">
                                                <p class="text-muted">
                                                    <a href="servers"><?PHP \DynamicalWeb\HTML::print(TEXT_CARD_POPULAR_SERVERS_VIEW_SERVERS); ?></a>
                                                </p>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-12">
                                                <div class="preview-list">

                                                    <?PHP
                                                        $PopularServers = $OpenBlu->getVPNManager()->getPopularServers();
                                                        foreach($PopularServers as $VPN)
                                                        {
                                                            $VPN = \OpenBlu\Objects\VPN::fromArray($VPN);
                                                            ?>
                                                            <div class="preview-item border-bottom" onclick="location.href='/server?pub_id=<?PHP \DynamicalWeb\HTML::print($VPN->PublicID) ?>';">
                                                                <div class="preview-thumbnail">
                                                                    <div class="preview-icon">
                                                                        <i class="flag-icon flag-icon-<?PHP \DynamicalWeb\HTML::print(strtolower($VPN->CountryShort)); ?>"></i>
                                                                    </div>
                                                                </div>
                                                                <div class="preview-item-content d-flex flex-grow">
                                                                    <div class="flex-grow">
                                                                        <h6 class="preview-subject"><?PHP \DynamicalWeb\HTML::print($VPN->IP); ?></h6>
                                                                        <p><?PHP \DynamicalWeb\HTML::print($VPN->Country) ?></p>
                                                                    </div>
                                                                    <div class="mr-auto text-right">
                                                                        <p class="text-muted"><?PHP \DynamicalWeb\HTML::print(time_elapsed_string($VPN->LastUpdated)); ?></p>
                                                                        <p><?PHP \DynamicalWeb\HTML::print(str_ireplace('%s', $VPN->Sessions, TEXT_CARD_POPULAR_SERVERS_VPN_SESSIONS)); ?></p>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <?PHP
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
            </div>

            <?PHP \DynamicalWeb\HTML::importSection('footer'); ?>
        </div>

        <?PHP \DynamicalWeb\HTML::importSection('js_scripts'); ?>

    </body>
</html>
