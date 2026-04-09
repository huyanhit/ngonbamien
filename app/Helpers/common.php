<?php
if (!function_exists('format_phone')) {
    function format_phone($phone) {
        $ac = substr($phone, 0, 4); 
        $prefix = substr($phone, 4, 3);
        $suffix = substr($phone, 6); 
        
        return "{$ac} {$prefix} {$suffix}";
    }
}