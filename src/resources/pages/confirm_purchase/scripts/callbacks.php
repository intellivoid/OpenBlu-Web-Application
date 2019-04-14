<?PHP

    if(isset($_GET['callback']))
    {
        switch((int)$_GET['callback'])
        {
            case 100:
                render_alert('Invalid Promotion Code', 'warning', 'alert-circle');
                break;
        }
    }