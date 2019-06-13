<?php

    use DynamicalWeb\HTML;
    use OpenBlu\Objects\VPN;

    function renderPopularServers(array $popular_servers)
    {
        if(count($popular_servers) > 0)
        {
            $VPN = VPN::fromArray($popular_servers[0]);
            ?>
            <div class="preview-item<?PHP if(count($popular_servers) !== 1){ print(" border-bottom"); } ?>" onclick="location.href='/server?pub_id=<?PHP HTML::print($VPN->PublicID) ?>';">
                <div class="preview-thumbnail">
                    <div class="preview-icon">
                        <i class="flag-icon flag-icon-<?PHP HTML::print(strtolower($VPN->CountryShort)); ?>"></i>
                    </div>
                </div>
                <div class="preview-item-content d-flex flex-grow">
                    <div class="flex-grow">
                        <h6 class="preview-subject"><?PHP HTML::print($VPN->IP); ?></h6>
                        <p><?PHP HTML::print($VPN->Country) ?></p>
                    </div>
                    <div class="mr-auto text-right">
                        <p class="text-muted"><?PHP HTML::print(time_elapsed_string($VPN->LastUpdated)); ?></p>
                        <p><?PHP HTML::print(str_ireplace('%s', $VPN->Sessions, TEXT_CARD_POPULAR_SERVERS_VPN_SESSIONS)); ?></p>
                    </div>
                </div>
            </div>
            <?PHP
        }

        if(count($popular_servers) > 1)
        {
            $VPN = VPN::fromArray($popular_servers[1]);
            ?>
            <div class="preview-item<?PHP if(count($popular_servers) !== 2){ print(" border-bottom"); } ?>" onclick="location.href='/server?pub_id=<?PHP HTML::print($VPN->PublicID) ?>';">
                <div class="preview-thumbnail">
                    <div class="preview-icon">
                        <i class="flag-icon flag-icon-<?PHP HTML::print(strtolower($VPN->CountryShort)); ?>"></i>
                    </div>
                </div>
                <div class="preview-item-content d-flex flex-grow">
                    <div class="flex-grow">
                        <h6 class="preview-subject"><?PHP HTML::print($VPN->IP); ?></h6>
                        <p><?PHP HTML::print($VPN->Country) ?></p>
                    </div>
                    <div class="mr-auto text-right">
                        <p class="text-muted"><?PHP HTML::print(time_elapsed_string($VPN->LastUpdated)); ?></p>
                        <p><?PHP HTML::print(str_ireplace('%s', $VPN->Sessions, TEXT_CARD_POPULAR_SERVERS_VPN_SESSIONS)); ?></p>
                    </div>
                </div>
            </div>
            <?PHP
        }

        if(count($popular_servers) > 2)
        {
            $VPN = VPN::fromArray($popular_servers[2]);
            ?>
            <div class="preview-item<?PHP if(count($popular_servers) !== 3){ print(" border-bottom"); } ?>" onclick="location.href='/server?pub_id=<?PHP HTML::print($VPN->PublicID) ?>';">
                <div class="preview-thumbnail">
                    <div class="preview-icon">
                        <i class="flag-icon flag-icon-<?PHP HTML::print(strtolower($VPN->CountryShort)); ?>"></i>
                    </div>
                </div>
                <div class="preview-item-content d-flex flex-grow">
                    <div class="flex-grow">
                        <h6 class="preview-subject"><?PHP HTML::print($VPN->IP); ?></h6>
                        <p><?PHP HTML::print($VPN->Country) ?></p>
                    </div>
                    <div class="mr-auto text-right">
                        <p class="text-muted"><?PHP HTML::print(time_elapsed_string($VPN->LastUpdated)); ?></p>
                        <p><?PHP HTML::print(str_ireplace('%s', $VPN->Sessions, TEXT_CARD_POPULAR_SERVERS_VPN_SESSIONS)); ?></p>
                    </div>
                </div>
            </div>
            <?PHP
        }

        if(count($popular_servers) > 3)
        {
            $VPN = VPN::fromArray($popular_servers[3]);
            ?>
            <div class="preview-item<?PHP if(count($popular_servers) !CD ..== 4){ print(" border-bottom"); } ?>" onclick="location.href='/server?pub_id=<?PHP HTML::print($VPN->PublicID) ?>';">
                <div class="preview-thumbnail">
                    <div class="preview-icon">
                        <i class="flag-icon flag-icon-<?PHP HTML::print(strtolower($VPN->CountryShort)); ?>"></i>
                    </div>
                </div>
                <div class="preview-item-content d-flex flex-grow">
                    <div class="flex-grow">
                        <h6 class="preview-subject"><?PHP HTML::print($VPN->IP); ?></h6>
                        <p><?PHP HTML::print($VPN->Country) ?></p>
                    </div>
                    <div class="mr-auto text-right">
                        <p class="text-muted"><?PHP HTML::print(time_elapsed_string($VPN->LastUpdated)); ?></p>
                        <p><?PHP HTML::print(str_ireplace('%s', $VPN->Sessions, TEXT_CARD_POPULAR_SERVERS_VPN_SESSIONS)); ?></p>
                    </div>
                </div>
            </div>
            <?PHP
        }

        if(count($popular_servers) > 4)
        {
            $VPN = VPN::fromArray($popular_servers[4]);
            ?>
            <div class="preview-item" onclick="location.href='/server?pub_id=<?PHP HTML::print($VPN->PublicID) ?>';">
                <div class="preview-thumbnail">
                    <div class="preview-icon">
                        <i class="flag-icon flag-icon-<?PHP HTML::print(strtolower($VPN->CountryShort)); ?>"></i>
                    </div>
                </div>
                <div class="preview-item-content d-flex flex-grow">
                    <div class="flex-grow">
                        <h6 class="preview-subject"><?PHP HTML::print($VPN->IP); ?></h6>
                        <p><?PHP HTML::print($VPN->Country) ?></p>
                    </div>
                    <div class="mr-auto text-right">
                        <p class="text-muted"><?PHP HTML::print(time_elapsed_string($VPN->LastUpdated)); ?></p>
                        <p><?PHP HTML::print(str_ireplace('%s', $VPN->Sessions, TEXT_CARD_POPULAR_SERVERS_VPN_SESSIONS)); ?></p>
                    </div>
                </div>
            </div>
            <?PHP
        }
    }