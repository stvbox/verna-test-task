<?php

class Response {
	private $test = "";
	
	function __construct($test) {
		$this->test = $test;
	}
	
    function reply(){
        echo $this->test;
    }
}
