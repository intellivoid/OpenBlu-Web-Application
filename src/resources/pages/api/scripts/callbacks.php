<?PHP

    if(isset($_GET['callback']))
    {
        switch((int)$_GET['callback'])
        {
            case 100:
                render_alert(TEXT_CALLBACK_100, 'danger', 'alert-circle');
                break;

            case 101:
                render_alert("The subscription plan was not found", 'danger', 'alert-circle');
                break;

            case 102:
                render_alert("The subscription plan is not available", 'danger', 'alert-circle');
                break;

            case 103:
                render_alert("A new access key has been generated successfully", 'success', 'check-circle-outline');
                break;

        }
    }