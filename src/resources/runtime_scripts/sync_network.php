<?php

    use DynamicalWeb\DynamicalWeb;
    use DynamicalWeb\Runtime;
    use OpenBlu\OpenBlu;

    if(isset($_GET['action']))
    {
        if($_GET['action'] == 'sync')
        {
            Runtime::import('OpenBlu');

            // Gets the selected VPN
            if(isset(DynamicalWeb::$globalObjects['openblu']) == false)
            {
                /** @var OpenBlu $OpenBlu */
                $OpenBlu = DynamicalWeb::setMemoryObject('openblu', new OpenBlu());
            }
            else
            {
                /** @var OpenBlu $OpenBlu */
                $OpenBlu = DynamicalWeb::getMemoryObject('openblu');
            }

            $OpenBlu->getRecordManager()->sync("http://www.vpngate.net/api/iphone", true);

            exit(0);
        }
    }