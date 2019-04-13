<nav class="navbar col-lg-12 col-12 p-0 fixed-top d-flex flex-row">
    <div class="text-center navbar-brand-wrapper d-flex align-items-center justify-content-center">
        <a class="navbar-brand brand-logo" onclick="location.href='/'">
            <img src="/assets/images/banner.png" alt="logo"/>
        </a>
        <a class="navbar-brand brand-logo-mini" onclick="location.href='/'">
            <img src="/assets/images/logo.png" alt="logo"/>
        </a>
    </div>
    <div class="navbar-menu-wrapper d-flex align-items-stretch">
        <button class="navbar-toggler navbar-toggler align-self-center" type="button" data-toggle="minimize">
            <span class="mdi mdi-format-list-bulleted"></span>
        </button>
        <ul class="navbar-nav navbar-nav-right">

        </ul>
        <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" type="button" data-toggle="offcanvas">
            <span class="mdi mdi-format-line-spacing"></span>
        </button>

        <?PHP
        if(WEB_SESSION_ACTIVE == false)
        {
            ?>
            <ul class="navbar-nav navbar-nav-right">

                <li class="nav-item d-none d-lg-block">
                    <button onclick="location.href='/login'" type="button" class="btn btn-inverse-info btn-fw">Login to OpenBlu</button>

                </li>
            </ul>
            <?PHP
        }
        ?>

    </div>
</nav>