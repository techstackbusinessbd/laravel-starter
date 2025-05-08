<?php

use Illuminate\Support\Str;



if (!function_exists('generate_slug')) {
    function generate_slug($string) {
        return Str::slug($string);
    }
}
