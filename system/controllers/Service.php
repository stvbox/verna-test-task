<?php
namespace Controllers;

use Models\Network,
    Models\Agency,
    Models\Bill;

class Service {
	static function importcsv() {
		ob_start();

		$imp = new \Importer();
		
		try {
		    \Repository::execSQL("DELETE FROM networks");
            \Repository::execSQL("DELETE FROM agencys");
            \Repository::execSQL("DELETE FROM bills");
            $sqlDelSt = "DELETE FROM sqlite_sequence WHERE name IN ('networks', 'agencys', 'bills')";
            \Repository::execSQL($sqlDelSt);

			$data = $imp->proced("data/agency_network.txt");
            pr($data);
			foreach($data AS $arRow)
				Network::getRepository()->save(new Network($arRow), "create");

			$data = $imp->proced("data/agency.txt");
            pr($data);
			foreach($data AS $arRow)
    			Agency::getRepository()->save(new Agency($arRow), "create");

			$data = $imp->proced("data/billing.txt");
            pr($data);
			foreach($data AS $arRow)
				Bill::getRepository()->save(new Bill($arRow), "create");

		}
		catch(PDOException $ex){
			echo "<pre>";
			print_r($ex);
			echo "</pre>";			
		}
		catch(Exception $ex){
			echo "<pre>";
			print_r($ex);
			echo "</pre>";
		}
		
		$result = ob_get_contents();
		ob_end_clean();
		
		return new \Response($result);
		
	}
    
}
