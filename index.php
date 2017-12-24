<?php

function pr($val){
    echo "<pre>";
    print_r($val);
    echo "</pre>";        
}

include 'system/autoloader.php';
$answer = Router::start();

$answer->reply();

?>