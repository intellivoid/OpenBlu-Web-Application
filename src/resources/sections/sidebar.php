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
                            <div class="badge badge-success badge-pill mb-0 ml-3">$0.00</div>
                            <i class="menu-arrow"></i>
                        </a>
                        <div class="collapse" id="account-dropdown">
                            <ul class="nav flex-column sub-menu pl-0">

                                <li class="nav-item">
                                    <a class="nav-link pl-5" onclick="location.href='/add_balance';">
                                        <span class="menu-icon">
                                            <i class="mdi mdi-bank"></i>
                                        </span>
                                        <span class="menu-title">Add to balance</span>
                                    </a>
                                </li>

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
        ?>
        <li class="nav-item nav-category">
            <span class="nav-link">Navigation</span>
        </li>
        <li class="nav-item menu-items">
            <a class="nav-link" href="/">
                <span class="menu-icon">
                  <i class="mdi mdi-home"></i>
                </span>
                <span class="menu-title">Home</span>
            </a>
        </li>
        <li class="nav-item menu-items">
            <a class="nav-link" href="/servers">
                <span class="menu-icon">
                  <i class="mdi mdi-server-network"></i>
                </span>
                <span class="menu-title">VPN Servers</span>
            </a>
        </li>
        <li class="nav-item menu-items">
            <a class="nav-link" href="/api">
                <span class="menu-icon">
                  <i class="mdi mdi-console"></i>
                </span>
                <span class="menu-title">API</span>
            </a>
        </li>
        <li class="nav-item menu-items">
            <a class="nav-link" href="/guide">
                <span class="menu-icon">
                  <i class="mdi mdi-help"></i>
                </span>
                <span class="menu-title">How to connect</span>
            </a>
        </li>
        <li class="nav-item menu-items">
            <a class="nav-link" href="/support">
                <span class="menu-icon">
                  <i class="mdi mdi-lifebuoy"></i>
                </span>
                <span class="menu-title">Support</span>
            </a>
        </li>
        <li class="nav-item menu-items">
            <a class="nav-link" href="/about">
                <span class="menu-icon">
                  <i class="mdi mdi-information-outline"></i>
                </span>
                <span class="menu-title">About</span>
            </a>
        </li>
    </ul>
</nav>