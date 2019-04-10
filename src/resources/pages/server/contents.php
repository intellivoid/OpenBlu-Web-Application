<?PHP
    /** @noinspection PhpUnhandledExceptionInspection */

    use DynamicalWeb\HTML;

    HTML::importScript('check_auth');
    HTML::importScript('check_selection');
    HTML::importScript('cache');
    HTML::importScript('time_human');
?>

<!DOCTYPE html>
<html lang="<?PHP HTML::print(APP_LANGUAGE_ISO_639); ?>">
    <head>
        <?PHP HTML::importSection('header'); ?>
        <title><?PHP HTML::print(str_ireplace('%s', CACHE_VPN_PUBLIC_ID, TEXT_PAGE_TITLE)); ?></title>
    </head>

    <body>

        <div class="container-scrollbar">
            <?PHP HTML::importSection('navigation'); ?>
            <div class="container-fluid page-body-wrapper">
                <?PHP HTML::importSection('sidebar'); ?>
                <div class="main-panel">
                    <div class="content-wrapper">


                        <div class="row">
                            <div class="col-md-12 grid-margin">
                                <div class="card animated flipInX">
                                    <div class="card-body">
                                        <div class="d-flex flex-row align-items-top">
                                            <i class="flag-icon flag-icon-<?PHP HTML::print(strtolower(CACHE_VPN_COUNTRY_SHORT)); ?> text-primary icon-md"></i>
                                            <div class="ml-3">
                                                <h6 class="text-primary"><?PHP HTML::print(CACHE_VPN_IP); ?></h6>
                                                <p class="mt-2 text-muted card-text"><?PHP HTML::print(str_ireplace('%s', CACHE_VPN_SESSIONS, TEXT_HEADER_CURRENT_SESSIONS)); ?></p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">

                            <div class="col-md-8 grid-margin stretch-card">
                                <div class="card animated slideInLeft">
                                    <div class="card-body">
                                        <div class="d-flex flex-row">
                                            <div class="align-self-top">
                                                <h4 class="card-title"><?PHP HTML::print(TEXT_CARD_SERVER_DETAILS_TITLE); ?></h4>
                                                <p class="card-description"><?PHP HTML::print(str_ireplace('%s', time_elapsed_string(CACHE_VPN_LAST_UPDATED), TEXT_CARD_SERVER_DETAILS_DESC)); ?></p>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-12">
                                                <div class="preview-list">

                                                    <div class="preview-item border-bottom">
                                                        <div class="preview-thumbnail">
                                                            <div class="preview-icon bg-primary rounded">
                                                                <i class="mdi mdi-server"></i>
                                                            </div>
                                                        </div>
                                                        <div class="preview-item-content d-flex flex-grow">
                                                            <div class="flex-grow">
                                                                <h6 class="preview-subject"><?PHP HTML::print(TEXT_CARD_SERVER_DETAILS_IP_ADDRESS_TITLE); ?></h6>
                                                                <p><?PHP HTML::print(TEXT_CARD_SERVER_DETAILS_IP_ADDRESS_DESC); ?></p>
                                                            </div>
                                                            <div class="mr-auto text-right">
                                                                <p class="text-info"><?PHP HTML::print(CACHE_VPN_IP); ?></p>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="preview-item border-bottom">
                                                        <div class="preview-thumbnail">
                                                            <div class="preview-icon bg-primary rounded">
                                                                <i class="mdi mdi-map-marker"></i>
                                                            </div>
                                                        </div>
                                                        <div class="preview-item-content d-flex flex-grow">
                                                            <div class="flex-grow">
                                                                <h6 class="preview-subject"><?PHP HTML::print(TEXT_CARD_SERVER_DETAILS_COUNTRY_TITLE); ?></h6>
                                                                <p><?PHP HTML::print(TEXT_CARD_SERVER_DETAILS_COUNTRY_DESC); ?></p>
                                                            </div>
                                                            <div class="mr-auto text-right">
                                                                <p class="text-info"><?PHP HTML::print(CACHE_VPN_COUNTRY); ?></p>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="preview-item border-bottom">
                                                        <div class="preview-thumbnail">
                                                            <div class="preview-icon bg-primary rounded">
                                                                <i class="mdi mdi-account-group"></i>
                                                            </div>
                                                        </div>
                                                        <div class="preview-item-content d-flex flex-grow">
                                                            <div class="flex-grow">
                                                                <h6 class="preview-subject"><?PHP HTML::print(TEXT_CARD_SERVER_DETAILS_CURRENT_SESSIONS_TITLE); ?></h6>
                                                                <p><?PHP HTML::print(TEXT_CARD_SERVER_DETAILS_CURRENT_SESSIONS_DESC); ?></p>
                                                            </div>
                                                            <div class="mr-auto text-right">
                                                                <p class="text-info"><?PHP HTML::print(str_ireplace('%s', CACHE_VPN_SESSIONS, TEXT_PLACEHOLDER_SESSIONS)); ?></p>
                                                            </div>
                                                        </div>
                                                    </div>


                                                    <div class="preview-item border-bottom">
                                                        <div class="preview-thumbnail">
                                                            <div class="preview-icon bg-primary rounded">
                                                                <i class="mdi mdi-account-network"></i>
                                                            </div>
                                                        </div>
                                                        <div class="preview-item-content d-flex flex-grow">
                                                            <div class="flex-grow">
                                                                <h6 class="preview-subject"><?PHP HTML::print(TEXT_CARD_SERVER_DETAILS_TOTAL_SESSIONS_TITLE); ?></h6>
                                                                <p><?PHP HTML::print(TEXT_CARD_SERVER_DETAILS_TOTAL_SESSIONS_DESC); ?></p>
                                                            </div>
                                                            <div class="mr-auto text-right">
                                                                <p class="text-info"><?PHP HTML::print(str_ireplace('%s', CACHE_VPN_TOTAL_SESSIONS, TEXT_PLACEHOLDER_SESSIONS)); ?></p>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="preview-item border-bottom">
                                                        <div class="preview-thumbnail">
                                                            <div class="preview-icon bg-primary rounded">
                                                                <i class="mdi mdi-signal-cellular-2"></i>
                                                            </div>
                                                        </div>
                                                        <div class="preview-item-content d-flex flex-grow">
                                                            <div class="flex-grow">
                                                                <h6 class="preview-subject"><?PHP HTML::print(TEXT_CARD_SERVER_DETAILS_PING_TITLE); ?></h6>
                                                                <p><?PHP HTML::print(TEXT_CARD_SERVER_DETAILS_PING_DESC); ?></p>
                                                            </div>
                                                            <div class="mr-auto text-right">
                                                                <p class="text-info"><?PHP HTML::print(str_ireplace('%s', CACHE_VPN_PING, TEXT_PLACEHOLDER_SPEED)); ?></p>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="preview-item">
                                                        <div class="preview-thumbnail">
                                                            <div class="preview-icon bg-primary rounded">
                                                                <i class="mdi mdi-cloud-tags"></i>
                                                            </div>
                                                        </div>
                                                        <div class="preview-item-content d-flex flex-grow">
                                                            <div class="flex-grow">
                                                                <h6 class="preview-subject"><?PHP HTML::print(TEXT_CARD_SERVER_DETAILS_ID_TITLE); ?></h6>
                                                                <p><?PHP HTML::print(TEXT_CARD_SERVER_DETAILS_ID_DESC); ?></p>
                                                            </div>
                                                            <div class="mr-auto text-right">
                                                                <p class="text-info"><?PHP HTML::print(CACHE_VPN_PUBLIC_ID); ?></p>
                                                            </div>
                                                        </div>
                                                    </div>


                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>

                            <div class="col-md-4 grid-margin stretch-card">
                                <div class="card animated slideInRight">
                                    <div class="card-body">

                                        <h4 class="card-title"><?PHP HTML::print(TEXT_CARD_CONNECT_TITLE); ?></h4>
                                        <p class="card-description"><?PHP HTML::print(TEXT_CARD_CONNECT_OPENVPN_DESC); ?></p>

                                        <div class="row mt-3">


                                            <button type="button" class="btn btn-block btn-lg btn-inverse-info">
                                                <i class="mdi mdi-cloud-download"></i> <?PHP HTML::print(TEXT_CARD_CONNECT_OPENVPN_DOWNLOAD_BUTTON); ?>
                                            </button>

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
    </body>
</html>
