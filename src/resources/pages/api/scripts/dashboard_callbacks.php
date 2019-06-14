<?PHP

    if(isset($_GET['callback']))
    {
        switch((int)$_GET['callback'])
        {
            case 101:
                render_alert(TEXT_CALLBACK_101, 'success', 'check-circle');
                break;

            case 102:
                render_alert(TEXT_CALLBACK_102, 'danger', 'check-circle');
                break;

            case 103:
                render_alert(TEXT_CALLBACK_103, 'danger', 'check-circle');
                break;

            case 104:
                render_alert(TEXT_CALLBACK_104, 'danger', 'check-circle');
                break;
        }
    }