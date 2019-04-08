<?php

    use DynamicalWeb\HTML;

    /**
     * Renders an Alert
     *
     * @param string $text
     * @param string $type
     * @param string $icon
     */
    function render_alert(string $text, string $type, string $icon)
    {
        HTML::print("<div class=\"alert alert-fill-$type animated flipInX\" role=\"alert\">", false);
        HTML::print("<i class=\"mdi mdi-$icon\"></i>$text</div>", false);
    }