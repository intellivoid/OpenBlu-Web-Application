<?PHP
    use DynamicalWeb\HTML;
?>
<nav class="sidebar sidebar-offcanvas" id="sidebar">
    <ul class="nav">
        <?PHP
            if(WEB_SESSION_ACTIVE == true)
            {
                ?>
                    <li class="nav-item account-dropdown">
                        <a class="nav-link" data-toggle="collapse" href="#account-dropdown" aria-expanded="false" aria-controls="account-dropdown">
                            <img class="img-sm rounded-circle" src="/default_avatar" alt="User Avatar">
                            <p class="mb-0 ml-3 text-light" style="overflow: hidden; white-space: nowrap; text-overflow: ellipsis;"><?PHP HTML::print(WEB_ACCOUNT_USERNAME); ?></p>
                            <?PHP
                                if(CLIENT_MODE_ENABLED == false)
                                {
                                    if(CACHE_BALANCE_AVAILABLE == true)
                                    {
                                        HTML::print("<div class=\"badge badge-success badge-pill mb-0 ml-3\">$" . CACHE_BALANCE_AMOUNT . "</div>", false);
                                    }
                                }
                            ?>
                            <i class="menu-arrow"></i>
                        </a>
                        <div class="collapse" id="account-dropdown">
                            <ul class="nav flex-column sub-menu pl-0">

                                <?PHP
                                    if(CLIENT_MODE_ENABLED == false)
                                    {
                                        ?>
                                        <li class="nav-item">
                                            <a class="nav-link pl-5" onclick="location.href='/add_balance';">
                                                <span class="menu-icon">
                                                    <i class="mdi mdi-bank"></i>
                                                </span>
                                                <span class="menu-title">Add to balance</span>
                                            </a>
                                        </li>
                                        <?PHP
                                    }
                                ?>

                                <li class="nav-item">
                                    <a class="nav-link pl-5" onclick="location.href='/logout';">
                                        <span class="menu-icon">
                                            <i class="mdi mdi-power"></i>
                                        </span>
                                        <span class="menu-title">Logout</span>
                                    </a>
                                </li>

                            </ul>
                        </div>
                    </li>
                <?PHP
            }
            else
            {
                ?>
                <li class="nav-item account-dropdown">
                    <a class="nav-link" data-toggle="collapse" href="#account-dropdown" aria-expanded="false" aria-controls="account-dropdown">
                        <p class="mb-0 ml-3 text-light" style="overflow: hidden; white-space: nowrap; text-overflow: ellipsis;">Not Logged In</p>
                        <i class="menu-arrow"></i>
                    </a>
                    <div class="collapse" id="account-dropdown">
                        <ul class="nav flex-column sub-menu pl-0">

                            <li class="nav-item">
                                <a class="nav-link pl-5" onclick="location.href='/login';">
                                        <span class="menu-icon">
                                            <i class="mdi mdi-login"></i>
                                        </span>
                                    <span class="menu-title">Login</span>
                                </a>
                            </li>

                            <li class="nav-item">
                                <a class="nav-link pl-5" onclick="location.href='/register';">
                                        <span class="menu-icon">
                                            <i class="mdi mdi-account-plus"></i>
                                        </span>
                                    <span class="menu-title">Register</span>
                                </a>
                            </li>

                        </ul>
                    </div>
                </li>
                <?PHP
            }
        ?>
        <li class="nav-item nav-category">
            <span class="nav-link">Navigation</span>
        </li>
        <li class="nav-item menu-items<?PHP if(APP_CURRENT_PAGE == 'index'){ HTML::print(' active'); } ?>">
            <a class="nav-link" href="/">
                <span class="menu-icon">
                  <i class="mdi mdi-home"></i>
                </span>
                <span class="menu-title">Home</span>
            </a>
        </li>
        <li class="nav-item menu-items<?PHP if(APP_CURRENT_PAGE == 'servers' || APP_CURRENT_PAGE == 'server'){ HTML::print(' active'); } ?>">
            <a class="nav-link" href="/servers">
                <span class="menu-icon">
                  <i class="mdi mdi-server-network"></i>
                </span>
                <span class="menu-title">VPN Servers</span>
            </a>
        </li>
        <?PHP
            if(CLIENT_MODE_ENABLED == false)
            {
                ?>
                <li class="nav-item menu-items<?PHP if(APP_CURRENT_PAGE == 'api' || APP_CURRENT_PAGE == 'confirm_purchase'){ HTML::print(' active'); } ?>">
                    <a class="nav-link" href="/api">
                <span class="menu-icon">
                  <i class="mdi mdi-console"></i>
                </span>
                        <span class="menu-title">API</span>
                    </a>
                </li>
                <li class="nav-item menu-items<?PHP if(APP_CURRENT_PAGE == 'guide'){ HTML::print(' active'); } ?>">
                    <a class="nav-link" href="/guide">
                <span class="menu-icon">
                  <i class="mdi mdi-help"></i>
                </span>
                        <span class="menu-title">How to connect</span>
                    </a>
                </li>
                <?PHP
            }
        ?>
        <li class="nav-item menu-items<?PHP if(APP_CURRENT_PAGE == 'support'){ HTML::print(' support'); } ?>">
            <a class="nav-link" href="/support">
                <span class="menu-icon">
                  <i class="mdi mdi-lifebuoy"></i>
                </span>
                <span class="menu-title">Support</span>
            </a>
        </li>
        <li class="nav-item menu-items<?PHP if(APP_CURRENT_PAGE == 'about'){ HTML::print(' active'); } ?>">
            <a class="nav-link" href="/about">
                <span class="menu-icon">
                  <i class="mdi mdi-information-outline"></i>
                </span>
                <span class="menu-title">About</span>
            </a>
        </li>
    </ul>
</nav>