<?php


class ResponseJson extends Response {
	private $data;

	function __construct($data) {
		$this->data = $data;
	}
	
    function reply(){
        header('Content-Type: application/json');
        echo json_encode($this->data);
    }
}
