<?PHP \DynamicalWeb\HTML::importScript('check_auth'); ?>
<?PHP \DynamicalWeb\DynamicalWeb::loadLibrary('OpenBlu', 'OpenBlu', 'OpenBlu.php'); ?>
<?PHP $OpenBlu = new \OpenBlu\OpenBlu(); ?>
<!DOCTYPE html>
<html lang="<?PHP \DynamicalWeb\HTML::print(APP_LANGUAGE_ISO_639); ?>">
    <head>
        <?PHP \DynamicalWeb\HTML::importSection('header'); ?>
        <title>OpenBlu</title>
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
                                <div class="card">
                                    <div class="card-body">
                                        <h4 class="card-title mb-0">Total Servers</h4>
                                        <div class="d-flex justify-content-between align-items-center">
                                            <div class="d-inline-block pt-3">
                                                <div class="d-flex">
                                                    <h2 class="mb-0"><?PHP \DynamicalWeb\HTML::print($OpenBlu->getVPNManager()->totalServers()); ?></h2>
                                                </div>
                                                <i class="mdi mdi-clock text-muted"></i>
                                                <small class="text-gray">Updated 2 minutes ago.</small>
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
                                <div class="card">
                                    <div class="card-body">
                                        <h4 class="card-title mb-0">Current Users</h4>
                                        <div class="d-flex justify-content-between align-items-center">
                                            <div class="d-inline-block pt-3">
                                                <div class="d-flex">
                                                    <h2 class="mb-0">12,129</h2>
                                                    <div class="d-flex align-items-center ml-2">
                                                        <i class="mdi mdi-clock text-muted"></i>
                                                        <small class=" ml-1 mb-0">Updated: 05:42pm</small>
                                                    </div>
                                                </div>
                                                <small class="text-gray">The total amount of users connected using OpenBlu</small>
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
                                <div class="card">
                                    <div class="card-body">
                                        <h4 class="card-title">Support OpenBlu </h4>
                                        <p class="card-description">Like the free service and want it to last for the future?</p>

                                        <hr/>
                                        <div class="row">
                                            <div class="col-12">
                                                <h5>Donate to Intellivoid via PayPal</h5>
                                                <p>
                                                    We accept donations via PayPal, if you are interested (not obligated)
                                                    you can donate to support us by giving us the money to buy a cup
                                                    of coffee
                                                </p>
                                                <a class="btn btn-primary btn-rounded btn-lg btn-fw">
                                                    <i class="mdi mdi-paypal"></i>Donate with PayPal
                                                </a>
                                            </div>
                                        </div>

                                        <hr/>
                                        <div class="row">
                                            <div class="col-12">
                                                <h5>Purchase API Access</h5>
                                                <p>
                                                    If you want to use OpenBlu in your software, projects or servers you
                                                    can easily access all available servers using the OpenBlu API. You
                                                    can start off with a free tier (limited requests) and decide if it
                                                    works for you.
                                                </p>
                                                <a class="btn btn-danger btn-rounded btn-lg btn-fw">
                                                    <i class="mdi mdi-console"></i>API Plans
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-4 grid-margin stretch-card">
                                <div class="card">
                                    <div class="card-body">
                                        <h4 class="card-title">Analytics</h4>

                                        <div class="row mt-3">
                                            <div class="col-12 bg-gray-dark d-flex flex-row py-3 px-4 rounded">
                                                <div class="align-self-top">
                                                    <h6 class="mb-1">Total Current Sessions</h6>
                                                </div>
                                                <div class="align-self-center flex-grow text-right">
                                                    <h6 class="font-weight-bold mb-0">23,123</h6>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row mt-3">
                                            <div class="col-12 bg-gray-dark d-flex flex-row py-3 px-4 rounded">
                                                <div class="align-self-top">
                                                    <h6 class="mb-1">Total VPN Servers</h6>
                                                </div>
                                                <div class="align-self-center flex-grow text-right">
                                                    <h6 class="font-weight-bold mb-0">515</h6>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row mt-3">
                                            <div class="col-12 bg-gray-dark d-flex flex-row py-3 px-4 rounded">
                                                <div class="align-self-top">
                                                    <h6 class="mb-1">Last updated</h6>
                                                </div>
                                                <div class="align-self-center flex-grow text-right">
                                                    <h6 class="font-weight-bold mb-0">Dec 31, 2018</h6>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                            <div class="col-md-8 grid-margin stretch-card">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="d-flex flex-row">
                                            <div class="align-self-top">
                                                <h4 class="card-title">Open Projects</h4>
                                                <p>Your data status</p>
                                            </div>
                                            <div class="align-self-center flex-grow text-right">
                                                <p class="text-muted">View History</p>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-12">
                                                <div class="preview-list">
                                                    <div class="preview-item border-bottom">
                                                        <div class="preview-thumbnail">
                                                            <div class="preview-icon bg-primary rounded">
                                                                <i class="mdi mdi-file-document"></i>
                                                            </div>
                                                        </div>
                                                        <div class="preview-item-content d-flex flex-grow">
                                                            <div class="flex-grow">
                                                                <h6 class="preview-subject">New Document</h6>
                                                                <p>Broadcast web app mockup</p>
                                                            </div>
                                                            <div class="mr-auto text-right">
                                                                <p class="text-muted">15 minutes ago</p>
                                                                <p>30 tasks, 5 issues </p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="preview-item border-bottom">
                                                        <div class="preview-thumbnail">
                                                            <div class="preview-icon bg-success rounded">
                                                                <i class="mdi mdi-cloud-upload"></i>
                                                            </div>
                                                        </div>
                                                        <div class="preview-item-content d-flex flex-grow">
                                                            <div class="flex-grow">
                                                                <h6 class="preview-subject">New Design</h6>
                                                                <p>Upload new design</p>
                                                            </div>
                                                            <div class="mr-auto text-right">
                                                                <p class="text-muted">1 hour ago</p>
                                                                <p>23 tasks, 5 issues </p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="preview-item border-bottom">
                                                        <div class="preview-thumbnail">
                                                            <div class="preview-icon bg-info rounded">
                                                                <i class="mdi mdi-clock"></i>
                                                            </div>
                                                        </div>
                                                        <div class="preview-item-content d-flex flex-grow">
                                                            <div class="flex-grow">
                                                                <h6 class="preview-subject">Project meeting</h6>
                                                                <p>New project discussion</p>
                                                            </div>
                                                            <div class="mr-auto text-right">
                                                                <p class="text-muted">35 minutes ago</p>
                                                                <p>15 tasks, 2 issues </p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="preview-item border-bottom">
                                                        <div class="preview-thumbnail">
                                                            <div class="preview-icon bg-warning rounded">
                                                                <i class="mdi mdi-email"></i>
                                                            </div>
                                                        </div>
                                                        <div class="preview-item-content d-flex flex-grow">
                                                            <div class="flex-grow">
                                                                <h6 class="preview-subject">Broadcast Mail</h6>
                                                                <p>Sent release details to team</p>
                                                            </div>
                                                            <div class="mr-auto text-right">
                                                                <p class="text-muted">55 minutes ago</p>
                                                                <p>35 tasks, 7 issues </p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="preview-item">
                                                        <div class="preview-thumbnail">
                                                            <div class="preview-icon bg-danger rounded">
                                                                <i class="mdi mdi-chart-pie"></i>
                                                            </div>
                                                        </div>
                                                        <div class="preview-item-content d-flex flex-grow">
                                                            <div class="flex-grow">
                                                                <h6 class="preview-subject">Planning</h6>
                                                                <p>New application planning</p>
                                                            </div>
                                                            <div class="mr-auto text-right">
                                                                <p class="text-muted">50 minutes ago</p>
                                                                <p>27 tasks, 4 issues </p>
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

                    </div>
                </div>
            </div>

            <?PHP \DynamicalWeb\HTML::importSection('footer'); ?>
        </div>

        <?PHP \DynamicalWeb\HTML::importSection('js_scripts'); ?>

    </body>
</html>
