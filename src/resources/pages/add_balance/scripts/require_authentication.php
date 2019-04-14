<?php

    if(WEB_SESSION_ACTIVE == false)
    {
        header('Location: /login?redirect=add_balance');
        exit();
    }