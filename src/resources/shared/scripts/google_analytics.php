<?php

    use DynamicalWeb\DynamicalWeb;

    $Configuration = DynamicalWeb::getConfiguration('analytics');
    if($Configuration['enabled'] == true)
    {
        ?>
        <!-- Global site tag (gtag.js) - Google Analytics -->
        <script async src="<?PHP print($Configuration['endpoint']); ?>?id=<?PHP print(urlencode($Configuration['tracking_id'])); ?>"></script>
        <script>
            window.dataLayer = window.dataLayer || [];
            function gtag(){dataLayer.push(arguments);}
            gtag('js', new Date());
            gtag('config', '<?PHP print($Configuration['tracking_id']); ?>');
        </script>
        <?PHP
    }