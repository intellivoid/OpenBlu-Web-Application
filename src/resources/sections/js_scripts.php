<script src="/assets/js/jquery.js"></script>
<script src="/assets/vendors/js/vendor.bundle.base.js"></script>
<script src="/assets/vendors/js/vendor.bundle.addons.js"></script>
<script src="/assets/js/app.js"></script>
<?PHP
    if(defined('WEB_SESSION_ACTIVE') == true)
    {
        if(WEB_SESSION_ACTIVE == true)
        {
            ?>
            <script src="/assets/js/jquery.letterpic.js"></script>
            <script>
                $("#user-avatar").letterpic({
                    fill: 'color',
                    colors: [ "#2e2f32" ]
                });
            </script>
            <?PHP
        }
    }

?>