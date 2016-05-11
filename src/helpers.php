<?php

if (! function_exists('formatDate')) {
    function formatDate($date, $format = 'F jS, Y')
    {
        return date($format, strtotime($date));
    }
}

if (! function_exists('set_active')) {
    function set_active($routeNames, $active = 'is-active')
    {
        return in_array(\Route::currentRouteName(), $routeNames) ? $active : '';
    }
}

if (! function_exists('auto_p')) {
    function auto_p($string)
    {
        return '<p>'.str_replace("\n", "</p>\n<p>", $string)."</p>\n";
    }
}
