<?php

function p($ob, $f = 1)
{
    print "<pre>";
    print_r($ob);
    print "</pre>";
    if ($f == 1) exit;
}

function display_error_forcefully($display_error_forcefully = 1) 
{
    //#$display_error_forcefully = 1;
    if($display_error_forcefully) {
        ini_set('display_errors', 1);
        error_reporting(-1);
    } else {
        error_reporting(0);
    }
}
?>