<?php

class Router {

    static function start() {
        @list($foo, $controller, $function) = explode("/", $_SERVER["REQUEST_URI"]);
        $controller = $controller?$controller:"DefaultController";
        $function = $function?$function:"index";

        $controller = 'Controllers\\'.ucfirst($controller);
		
		if(!@class_exists($controller))
			$controller = "Controllers\\DefaultController";
		
		return $controller::$function();
    }

    function reply(){

    }
    
}
