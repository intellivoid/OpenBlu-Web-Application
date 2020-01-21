<?php

    /**
     * Creates headers
     *
     * @param array $headers
     */
    function create_headers(array $headers)
    {
        print("<thead><tr>");
        foreach($headers as $header)
        {
            print("<th>$header</th>");
        }
        print("</tr></thead>");
    }

    /**
     * Renders a row
     *
     * @param array $data
     */
    function create_row(array $data)
    {
        print("<tr class=\"invisible animated\">");
        foreach($data as $col)
        {
            print("<td>$col</td>");
        }
        print("</tr>");
    }

    /**
     * Creates a navigation bar
     *
     * @param int $total
     */
    function create_navigation(int $total)
    {
        $current_page = 1;
        $current_ilt = 1;

        if(isset($_GET['page']))
        {
            $current_page = (int)$_GET['page'];
        }

        print("<nav><ul class=\"pagination flex-wrap\">");

        if($current_page == 1)
        {
            print("<li class=\"page-item disabled\"><a class=\"page-link\"><i class=\"mdi mdi-chevron-left\"></i></a></li>");
        }
        else
        {
            $previous_page = $current_page - 1;
            $location = \DynamicalWeb\DynamicalWeb::getRoute('servers', array('page' => $previous_page));
            print("<li class=\"page-item\"><a class=\"page-link\" onclick=\"location.href='$location'\"><i class=\"mdi mdi-chevron-left\"></i></a></li>");
        }

        while(true)
        {
            if($current_ilt > $total)
            {
                break;
            }

            if($current_ilt == $current_page)
            {
                print("<li class=\"page-item active disabled\"><a class=\"page-link\">$current_ilt</a></li>");
            }
            else
            {
                $location = \DynamicalWeb\DynamicalWeb::getRoute('servers', array('page' => $current_ilt));
                print("<li class=\"page-item\"><a onclick=\"location.href='$location'\" class=\"page-link\">$current_ilt</a></li>");
            }

            $current_ilt += 1;
        }

        if($current_page > $total - 1)
        {
            print("<li class=\"page-item disabled\"><a class=\"page-link\"><i class=\"mdi mdi-chevron-right\"></i></a></li>");
        }
        else
        {
            if($current_page == $total)
            {
                print("<li class=\"page-item disabled\"><a class=\"page-link\"><i class=\"mdi mdi-chevron-right\"></i></a></li>");
            }
            else
            {
                $next_page = $current_page + 1;
                $location = \DynamicalWeb\DynamicalWeb::getRoute('servers', array('page' => $next_page));
                print("<li class=\"page-item\"><a onclick=\"location.href='$location'\" class=\"page-link\"><i class=\"mdi mdi-chevron-right\"></i></a></li>");
            }
        }

        print("</ul></nav>");
    }

    function render_table(array $results)
    {
        ?>
        <div class="table-responsive">
            <table class="table">
                <?PHP
                $headers = [
                    TEXT_TABLE_COUNTRY,
                    TEXT_TABLE_IP,
                    TEXT_TABLE_PING,
                    TEXT_TABLE_CURRENT_SESSIONS,
                    TEXT_TABLE_TOTAL_SESSIONS,
                    TEXT_TABLE_LAST_UPDATED,
                    TEXT_TABLE_ACTIONS
                ];
                create_headers($headers);
                ?>
                <tbody>
                <?PHP
                    $current_page = 1;

                    if(isset($_GET['page']))
                    {
                        $current_page = (int)$_GET['page'];
                    }

                    foreach($results['results'] as $VPN)
                    {
                        $VPNObject = \OpenBlu\Objects\VPN::fromArray($VPN);
                        $ActionView = '<a href="' . \DynamicalWeb\DynamicalWeb::getRoute('server', array('pub_id' => $VPNObject->PublicID)) . '" class="btn btn-sm btn-inverse-primary"><i class="mdi mdi-information" style="margin-right: 0;"></i></a>';
                        $ActionDownload = '<button onclick="process_download(\'' . $VPNObject->PublicID . '\');" class="btn btn-sm btn-inverse-success"><i class="mdi mdi-download" style="margin-right: 0;"></i></button>';

                        $RowData = [
                            '<i class="flag-icon flag-icon-' . strtolower($VPNObject->CountryShort) . ' mr-3"></i> ' . $VPNObject->Country,
                            $VPNObject->IP,
                            str_ireplace('%s', $VPNObject->Ping, TEXT_ROW_PING),
                            number_format($VPNObject->Sessions),
                            number_format($VPNObject->TotalSessions),
                            time_elapsed_string($VPNObject->LastUpdated),
                            $ActionView . ' ' . $ActionDownload
                        ];
                        create_row($RowData);
                    }
                ?>
                </tbody>
            </table>
        </div>
        <br/>
        <?PHP
        create_navigation($results['total_pages']);
    }