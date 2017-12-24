<?php


class ResponseHtml extends Response {
	private $template;
	private $page;
    private $arResult;

	/*function __construct($page) {
		$this->__construct($page, null);
	}*/
		
	function __construct($page, $tempalte = null, $arResult = Array()) {
		$this->page = $page;
		$this->template = $tempalte;
        $this->arResult = $arResult;
	}
	
	function renderPage() {
	    $arResult = $this->arResult;
        
		if($this->template){
			ob_start();
			require 'templates/'.$this->template.'.php';
			$htmlTeplate = ob_get_clean();
		}
		else{
			$htmlTeplate = "#WORK_AREA#";
		}
		
		$fragmentPath = 'fragments/'.$this->page.'.php';
		if(!is_file(__DIR__."/".$fragmentPath))
			$fragmentPath = 'fragments/404.php';
		
		ob_start();
		require $fragmentPath;
		$htmlFragment = ob_get_clean();		
		
		$htmlPage = str_replace("#WORK_AREA#", $htmlFragment, $htmlTeplate);
		return $htmlPage;
	}
	
    function reply(){
    	$html = $this->renderPage();
		echo $html;
    }
}
