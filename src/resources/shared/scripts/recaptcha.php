<?php

    use DynamicalWeb\DynamicalWeb;

    /**
     * Returns the rendering content for recaptcha
     *
     * @return string
     * @throws Exception
     */
    function re_render()
    {
        if(WEB_CLIENT_MODE_ENABLED == true)
        {
            return '';
        }

        $configuration = DynamicalWeb::getConfiguration('recaptcha');

        if($configuration['enabled'] == true)
        {
            return("<div class=\"g-recaptcha\" data-sitekey=\"" . $configuration['site_key'] . "\"></div>");
        }

        return '';
    }

    /**
     * @return string
     * @throws Exception
     */
    function re_import()
    {
        if(WEB_CLIENT_MODE_ENABLED == true)
        {
            return '';
        }

        $configuration = DynamicalWeb::getConfiguration('recaptcha');

        if($configuration['enabled'] == true)
        {
            /** @noinspection JSUnresolvedLibraryURL */
            return("<script src=\"https://www.google.com/recaptcha/api.js\" async defer></script>");
        }

        return '';
    }

    /**
     * Verifies the post request of the captcha request
     *
     * @return bool
     * @throws Exception
     */
    function verify_recaptcha(): bool
    {
        if(CLIENT_MODE_ENABLED == true)
        {
            return true;
        }

        $configuration = DynamicalWeb::getConfiguration('recaptcha');

        if($configuration['enabled'] == false)
        {
            return true;
        }

        // Check the captcha
        if (!isset($_POST['g-recaptcha-response']))
        {
            return false;
        }

        $opts = array('http' =>
            array(
                'method' => 'POST ',
                'header' => 'Content-type: application/x-www-form-urlencoded',
                'content' => http_build_query(array(
                    'secret' => (string)$configuration['secret_key'],
                    'response' => $_POST['g-recaptcha-response'],
                    'remoteip' => CLIENT_REMOTE_HOST
                ))
            )
        );

        $context = stream_context_create($opts);
        $response = file_get_contents('https://www.google.com/recaptcha/api/siteverify', false, $context);
        $result = json_decode($response);

        if(!$result->success)
        {
            return false;
        }
        else
        {
            return true;
        }
    }