<?PHP

use COASniffle\Abstracts\AvatarResourceName;
use COASniffle\COASniffle;
use COASniffle\Handlers\COA;
use DynamicalWeb\DynamicalWeb;
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
                            <img id="user-avatar" class="letterpic" src="<?PHP HTML::print(COA::getAvatarUrl(AvatarResourceName::Normal, WEB_ACCOUNT_PUBID), false); ?>" title="<?PHP HTML::print(WEB_ACCOUNT_USERNAME); ?>" width="42" height="42" style="margin-right: 5px; border-radius: 30px;">
                            <p class="mb-0 ml-3 text-light" style="overflow: hidden; white-space: nowrap; text-overflow: ellipsis;"><?PHP HTML::print(WEB_ACCOUNT_USERNAME); ?></p>
                            <i class="menu-arrow"></i>
                        </a>
                        <div class="collapse" id="account-dropdown">
                            <ul class="nav flex-column sub-menu pl-0">
                                <li class="nav-item">
                                    <a class="nav-link pl-5" onclick="location.href='<?PHP DynamicalWeb::getRoute('logout', array(), true); ?>';">
                                        <span class="menu-icon"><i class="mdi mdi-power"></i></span>
                                        <span class="menu-title"><?PHP HTML::print(TEXT_SIDEBAR_LOGOUT); ?></span>
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
                        <p class="mb-0 ml-3 text-light" style="overflow: hidden; white-space: nowrap; text-overflow: ellipsis;"><?PHP HTML::print(TEXT_SIDEBAR_NOT_LOGGED_IN); ?></p>
                        <i class="menu-arrow"></i>
                    </a>
                    <div class="collapse" id="account-dropdown">
                        <ul class="nav flex-column sub-menu pl-0">
                            <?PHP
                                /** @var COASniffle $COASniffle */
                                $COASniffle = DynamicalWeb::getMemoryObject('coasniffle');
                                $Protocol = strtolower(substr($_SERVER["SERVER_PROTOCOL"],0,strpos( $_SERVER["SERVER_PROTOCOL"],'/'))).'://';
                                $RedirectURL = $Protocol . $_SERVER['HTTP_HOST'] . DynamicalWeb::getRoute('index');
                                $AuthenticationURL = $COASniffle->getCOA()->getAuthenticationURL($RedirectURL);
                            ?>
                            <li class="nav-item">
                                <a class="nav-link pl-5" onclick="location.href='<?PHP HTML::print($AuthenticationURL, false); ?>';"> <!-- TODO: Add COA Authentication URL here -->
                                    <span class="menu-icon"><i class="mdi mdi-login"></i></span>
                                    <span class="menu-title"><?PHP HTML::print(TEXT_SIDEBAR_LOGIN); ?></span>
                                </a>
                            </li>

                        </ul>
                    </div>
                </li>
                <?PHP
            }
        ?>
        <li class="nav-item nav-category">
            <span class="nav-link"><?PHP HTML::print(TEXT_SIDEBAR_NAV_HEADER); ?></span>
        </li>
        <li class="nav-item menu-items<?PHP if(APP_CURRENT_PAGE == 'index'){ HTML::print(' active'); } ?>">
            <a class="nav-link" href="<?PHP DynamicalWeb::getRoute('index', array(), true); ?>">
                <span class="menu-icon"><i class="mdi mdi-home"></i></span>
                <span class="menu-title"><?PHP HTML::print(TEXT_SIDEBAR_NAV_HOME); ?></span>
            </a>
        </li>
        <li class="nav-item menu-items<?PHP if(APP_CURRENT_PAGE == 'servers' || APP_CURRENT_PAGE == 'server'){ HTML::print(' active'); } ?>">
            <a class="nav-link" href="<?PHP DynamicalWeb::getRoute('servers', array(), true); ?>">
                <span class="menu-icon"><i class="mdi mdi-server-network"></i></span>
                <span class="menu-title"><?PHP HTML::print(TEXT_SIDEBAR_NAV_SERVERS); ?></span>
            </a>
        </li>
        <li class="nav-item menu-items<?PHP if(APP_CURRENT_PAGE == 'api'){ HTML::print(' active'); } ?>">
            <a class="nav-link" href="<?PHP DynamicalWeb::getRoute('api', array(), true); ?>">
                <span class="menu-icon"><i class="mdi mdi-console"></i></span>
                <span class="menu-title"><?PHP HTML::print(TEXT_SIDEBAR_NAV_API); ?></span>
            </a>
        </li>
        <li class="nav-item menu-items<?PHP if(APP_CURRENT_PAGE == 'support'){ HTML::print(' active'); } ?>">
            <a class="nav-link" href="<?PHP DynamicalWeb::getRoute('support', array(), true); ?>">
                <span class="menu-icon"><i class="mdi mdi-lifebuoy"></i></span>
                <span class="menu-title"><?PHP HTML::print(TEXT_SIDEBAR_NAV_SUPPORT); ?></span>
            </a>
        </li>
        <li class="nav-item menu-items<?PHP if(APP_CURRENT_PAGE == 'about'){ HTML::print(' active'); } ?>">
            <a class="nav-link" href="<?PHP DynamicalWeb::getRoute('about', array(), true); ?>">
                <span class="menu-icon"><i class="mdi mdi-information-outline"></i></span>
                <span class="menu-title"><?PHP HTML::print(TEXT_SIDEBAR_NAV_ABOUT); ?></span>
            </a>
        </li>
    </ul>
</nav>