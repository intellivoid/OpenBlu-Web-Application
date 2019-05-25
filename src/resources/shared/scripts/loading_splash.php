<?PHP
    /** @noinspection PhpUnhandledExceptionInspection */

    use DynamicalWeb\HTML;
?>

<!DOCTYPE html>
    <html lang="en">
    <head>
        <?PHP HTML::importSection('header'); ?>
        <title>OpenBlu</title>
        <style>
            /* Absolute Center Spinner */
            .loading {
                position: fixed;
                z-index: 999;
                height: 2em;
                width: 2em;
                margin: auto;
                top: 0;
                left: 0;
                bottom: 0;
                right: 0;
            }
        </style>
    </head>

    <body>

        <div class="container-scroller">
            <div class="container-fluid page-body-wrapper full-page-wrapper bg-dark">
                <div class="content d-flex align-items-center text-center" >
                    <div class="flex-grow">
                        <div class="loading">
                            <div class="bar-loader">
                                <span></span>
                                <span></span>
                                <span></span>
                                <span></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <?PHP HTML::importSection('js_scripts'); ?>

    </body>
</html>