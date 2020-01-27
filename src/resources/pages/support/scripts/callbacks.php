<?PHP

    use DynamicalWeb\Runtime;
    use Support\Abstracts\SupportTicketSearchMethod;
    use Support\Support;

    Runtime::import('Support');

    if(isset($_GET['callback']))
    {
        switch((int)$_GET['callback'])
        {
            case 100:
                render_alert(TEXT_CALLBACK_100, 'danger', 'alert-circle');
                break;

            case 101:
                render_alert(TEXT_CALLBACK_101, 'warning', 'alert-circle');
                break;

            case 102:
                render_alert(TEXT_CALLBACK_102, 'warning', 'alert-circle');
                break;

            case 103:
                render_alert(TEXT_CALLBACK_103, 'warning', 'alert-circle');
                break;

            case 104:
                render_alert(TEXT_CALLBACK_104, 'danger', 'alert-circle');
                break;

            case 105:
                if(isset($_GET['ticket_number']) == false)
                {
                    break;
                }

                if(strlen($_GET['ticket_number']) > 200)
                {
                    break;
                }

                $Support = new Support();

                try
                {
                    $Support->getTicketManager()->getSupportTicket(SupportTicketSearchMethod::byTicketNumber, $_GET['ticket_number']);
                }
                catch(Exception $exception)
                {
                    break;
                }

                $TicketNumber = htmlspecialchars($_GET['ticket_number'], ENT_QUOTES, 'UTF-8');
                render_alert(str_ireplace('%s', $TicketNumber, TEXT_CALLBACK_105), 'success', 'check-circle-outline');

                break;
        }
    }