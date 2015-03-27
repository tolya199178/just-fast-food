<?php

error_reporting(E_ALL);
echo $disabled_functions = ini_get('disable_functions');


if(function_exists('exec')) {
    echo "exec is enabled";
}
//echo __FILE__;
//exec('mysql');