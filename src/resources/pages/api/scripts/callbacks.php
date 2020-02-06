<?PHP

    if(isset($_GET['callback']))
    {
        switch((int)$_GET['callback'])
        {
            case 100:
                render_alert(TEXT_CALLBACK_100, 'danger', 'alert-circle');
                break;

            case 101:
                render_alert(TEXT_CALLBACK_101, 'danger', 'alert-circle');
                break;

            case 102:
                render_alert(TEXT_CALLBACK_102, 'danger', 'alert-circle');
                break;

            case 103:
                render_alert(TEXT_CALLBACK_103, 'success', 'check-circle-outline');
                break;

        }
    }