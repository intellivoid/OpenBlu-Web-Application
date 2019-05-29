<?PHP

    if(isset($_GET['callback']))
    {
        switch((int)$_GET['callback'])
        {
            case 100:
                render_alert('Your plan has been canceled', 'success', 'check-circle');
                break;
        }
    }