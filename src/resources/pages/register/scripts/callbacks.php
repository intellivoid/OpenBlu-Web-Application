<?PHP

    if(isset($_GET['callback']))
    {
        switch((int)$_GET['callback'])
        {
            case 100:
                render_alert(TEXT_CALLBACK_100, 'warning', 'alert-circle');
                break;

            case 101:
                render_alert(TEXT_CALLBACK_101, 'danger', 'alert-circle');
                break;

            case 102:
                render_alert(TEXT_CALLBACK_102, 'danger', 'alert-circle');
                break;

            case 103:
                render_alert(TEXT_CALLBACK_103, 'danger', 'alert-circle');
                break;

            case 104:
                render_alert(TEXT_CALLBACK_104, 'danger', 'alert-circle');
                break;

            case 105:
                render_alert(TEXT_CALLBACK_105, 'danger', 'alert-circle');
                break;

            case 106:
                render_alert(TEXT_CALLBACK_106, 'danger', 'alert-circle');
                break;

            case 107:
                render_alert(TEXT_CALLBACK_107, 'success', 'check-circle');
                break;

            case 108:
                render_alert(TEXT_CALLBACK_108, 'warning', 'alert-circle');
                break;
        }
    }