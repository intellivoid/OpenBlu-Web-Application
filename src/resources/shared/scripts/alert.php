<?php

    function render_alert(string $text, string $type, string $icon)
    {
        \DynamicalWeb\HTML::print("<div class=\"alert alert-fill-$type\" role=\"alert\">", false);
        \DynamicalWeb\HTML::print("<i class=\"mdi mdi-$icon\"></i>$text</div>", false);
    }