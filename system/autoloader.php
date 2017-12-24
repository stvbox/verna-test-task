<?php
namespace autoloader;

$paths = Array();


spl_autoload_register(function ($class_name) {
    $arSegs = explode("\\", $class_name);
    //echo " ----------------------- ";
    //echo $arSegs[0];
    //echo " ----------------------- ";
    
    if($arSegs[0] == "Models"){
        //pr("models/".$arSegs[1].'.php');
        include "models/".$arSegs[1].'.php';
    }
    elseif($arSegs[0] == "Controllers"){
        //pr("controllers/".$arSegs[1].'.php');
        include "controllers/".$arSegs[1].'.php';
    }
    else{
        //pr($class_name . '.php');
        include $class_name . '.php';
    }
    
});


