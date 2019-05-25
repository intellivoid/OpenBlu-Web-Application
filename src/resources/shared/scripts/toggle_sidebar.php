<?php

    use sws\sws;

    if(isset($_GET['update']))
    {
        if($_GET['update'] == 'ui')
        {
            if(isset($_GET['action']))
            {
                if($_GET['action'] == 'toggle-sidebar')
                {
                    $sws = new sws();
                    $Cookie = $sws->WebManager()->getCookie('web_session');

                    if($Cookie->Data['cache']['ui']['sidebar_expanded'] == true)
                    {
                        $Cookie->Data['cache']['ui']['sidebar_expanded'] = false;
                    }
                    else
                    {
                        $Cookie->Data['cache']['ui']['sidebar_expanded'] = true;
                    }

                    $sws->CookieManager()->updateCookie($Cookie);
                    print(hash('sha256', time() . 'utc-do-not-change'));
                    exit();
                }
            }
        }
    }