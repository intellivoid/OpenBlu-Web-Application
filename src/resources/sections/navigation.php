<?PHP
    use DynamicalWeb\DynamicalWeb;
    use DynamicalWeb\HTML;

?>
<nav class="navbar col-lg-12 col-12 p-0 fixed-top d-flex flex-row">
    <div class="text-center navbar-brand-wrapper d-flex align-items-center justify-content-center">
        <a class="navbar-brand brand-logo" onclick="location.href='<?PHP DynamicalWeb::getRoute('index', array(), true); ?>'">
            <img src="/assets/images/banner.png" alt="logo"/>
        </a>
        <a class="navbar-brand brand-logo-mini" onclick="location.href='<?PHP DynamicalWeb::getRoute('index', array(), true); ?>'">
            <img src="/assets/images/logo.png" alt="logo"/>
        </a>
    </div>
    <div class="navbar-menu-wrapper d-flex align-items-stretch">
        <button class="navbar-toggler navbar-toggler align-self-center" id="toggle-sidebar" type="button">
            <span class="mdi mdi-format-list-bulleted"></span>
        </button>
        <ul class="navbar-nav navbar-nav-right">

            <li class="nav-item dropdown">
                <a class="nav-link count-indicator dropdown-toggle" id="translationDropdown" href="#" data-toggle="dropdown" aria-expanded="false">
                    <i class="mdi mdi-translate"></i>
                </a>
                <div class="dropdown-menu dropdown-menu-right navbar-dropdown preview-list" aria-labelledby="translationDropdown">
                    <h6 class="p-3 mb-0"><?PHP HTML::print(TEXT_LANGUAGES_DROPDOWN); ?></h6>
                    <div class="dropdown-divider"></div>

                    <a class="dropdown-item preview-item" href="<?PHP DynamicalWeb::getRoute('change_language', array('language' => 'en', 'cache' => hash('sha256', time())), true); ?>">
                        <div class="preview-thumbnail">
                            <i class="flag-icon flag-icon-gb"></i>
                        </div>
                        <div class="preview-item-content">
                            <p class="preview-subject mb-1">English</p>
                        </div>
                    </a>
                    <div class="dropdown-divider"></div>

                    <a class="dropdown-item preview-item" href="<?PHP DynamicalWeb::getRoute('change_language', array('language' => 'zh', 'cache' => hash('sha256', time())), true); ?>">
                        <div class="preview-thumbnail">
                            <i class="flag-icon flag-icon-cn"></i>
                        </div>
                        <div class="preview-item-content">
                            <p class="preview-subject mb-1">中文</p>
                        </div>
                    </a>
                    <div class="dropdown-divider"></div>

                    <a class="dropdown-item preview-item" href="<?PHP DynamicalWeb::getRoute('change_language', array('language' => 'es', 'cache' => hash('sha256', time())), true); ?>">
                        <div class="preview-thumbnail">
                            <!-- TODO: add a taco icon before i entirely rage out of this chilean hermano druggy guy owo -->
                            <i class="flag-icon flag-icon-cl"></i>
                        </div>
                        <div class="preview-item-content">
                            <p class="preview-subject mb-1">Español</p>
                        </div>
                    </a>
                    <div class="dropdown-divider"></div>

                    <p class="p-3 mb-0 text-center" onclick="window.open('https://github.com/intellivoid/Translations');"><?PHP HTML::print(TEXT_ADD_TRANSLATION); ?></p>
                </div>
            </li>

        </ul>
        <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" type="button" id="toggle-mini-sidebar">
            <span class="mdi mdi-format-list-bulleted"></span>
        </button>
    </div>
</nav>
