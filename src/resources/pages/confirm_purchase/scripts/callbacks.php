<?PHP

    if(isset($_GET['callback']))
    {
        switch((int)$_GET['callback'])
        {
            case 100:
                render_alert('Invalid Promotion Code', 'warning', 'alert-circle');
                break;

            case 101:
                render_alert('You have insufficient funds in your account to start this subscription', 'danger', 'alert-circle');
                break;

            case 102:
                render_alert('You are not allowed to make any purchases, please contact support.', 'warning', 'alert-circle');
                break;

            case 103:
                render_alert('A subscription is already active, this transaction cannot be completed', 'warning', 'alert-circle');
                break;
        }
    }