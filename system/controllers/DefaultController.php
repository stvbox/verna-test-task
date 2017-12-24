<?php
namespace Controllers;

class DefaultController {
    static function index(){
        return new \ResponseHtml("index", "main");
    }
} 