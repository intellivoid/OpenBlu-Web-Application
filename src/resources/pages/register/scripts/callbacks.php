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
        }
    }