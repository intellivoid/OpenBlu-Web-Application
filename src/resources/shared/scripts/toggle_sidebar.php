<?php

    use DynamicalWeb\DynamicalWeb;
    use sws\Objects\Cookie;

    if(isset($_GET['update']))
    {
        if($_GET['update'] == 'ui')
        {
            if(isset($_GET['action']))
            {
                if($_GET['action'] == 'toggle-sidebar')
                {
                    /** @var Cookie $Cookie */
                    $Cookie = DynamicalWeb::getMemoryObject('(cookie)web_session');

                    if($Cookie->Data['cache']['ui']['sidebar_expanded'] == true)
                    {
                        $Cookie->Data['cache']['ui']['sidebar_expanded'] = false;
                    }
                    else
                    {
                        $Cookie->Data['cache']['ui']['sidebar_expanded'] = true;
                    }

                    $sws = DynamicalWeb::getMemoryObject('sws');
                    $sws->CookieManager()->updateCookie($Cookie);
                    print(hash('sha256', time() . 'utc-do-not-change'));
                    exit();
                }
            }
        }
    }