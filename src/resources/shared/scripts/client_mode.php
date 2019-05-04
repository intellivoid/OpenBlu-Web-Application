<?php

    function jsonResponse(array $data, int $status_code = 200)
    {
        header('Content-Type: application/json');
        header('Status: ' . $status_code);
        print(json_encode($data));
        exit();
    }

    function checkParameter(string $name): string
    {
        if(isset($_GET[$name]) == false)
        {
            jsonResponse(
                array(
                    'operation_success' => false,
                    'error_code' => 'MISSING_PARAMETER',
                    'parameter_name' => $name
                ),
                400
            );
        }

        return $_GET[$name];
    }

    function registerClient()
    {
        $client = checkParameter('client');
        $clientVersion = checkParameter('client_version');
        $osName = checkParameter('os_name');
        $clientUid = checkParameter('client_uid');


    }