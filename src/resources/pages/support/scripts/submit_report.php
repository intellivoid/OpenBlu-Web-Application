<?php

    use DynamicalWeb\Actions;
    use DynamicalWeb\DynamicalWeb;
    use DynamicalWeb\Runtime;
    use Support\Support;
    use Support\Utilities\Validation;

    Runtime::import('Support');

    if($_SERVER['REQUEST_METHOD'] == 'POST')
    {
        if(isset($_POST['email']) == false)
        {
            Actions::redirect(DynamicalWeb::getRoute(
                'support', array('callback' => '100')
            ));
        }

        if(isset($_POST['subject']) == false)
        {
            Actions::redirect(DynamicalWeb::getRoute(
                'support', array('callback' => '100')
            ));
        }

        if(isset($_POST['message']) == false)
        {
            Actions::redirect(DynamicalWeb::getRoute(
                'support', array('callback' => '100')
            ));
        }

        submit_report();

    }

    function submit_report()
    {
        if(Validation::email($_POST['email']) == false)
        {
            Actions::redirect(DynamicalWeb::getRoute(
                'support', array('callback' => '101')
            ));
        }

        if(Validation::subject($_POST['subject']) == false)
        {
            Actions::redirect(DynamicalWeb::getRoute(
                'support', array('callback' => '102')
            ));
        }

        if(Validation::message($_POST['message']) == false)
        {
            Actions::redirect(DynamicalWeb::getRoute(
                'support', array('callback' => '103')
            ));
        }

        $IntellivoidSupport = new Support();

        try
        {
            $SupportTicket = $IntellivoidSupport->getTicketManager()->submitTicket(
                'OpenBlu', $_POST['subject'], $_POST['message'], $_POST['email']
            );
        }
        catch(Exception $exception)
        {
            Actions::redirect(DynamicalWeb::getRoute(
                'support', array('callback' => '104')
            ));
        }

        Actions::redirect(DynamicalWeb::getRoute(
            'support', array('callback' => '105', 'ticket_number' => $SupportTicket->TicketNumber)
        ));
    }