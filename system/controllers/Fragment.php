<?php
namespace Controllers;

class Fragment {
    static function index() {
        return new \ResponseHtml('about');
    }
    static function menu() {
        return new \ResponseHtml('menu');
    }
	
    static function crud() {
        $arResult = Array();
        
        $repo = \Models\Agency::getRepository();
        $arAgencys = $repo->findAll();
        $arResult["AGENCYS"] = Array();
        foreach($arAgencys AS $oAgency) {
            $arResult["AGENCYS"][] = Array(
                "agency_id" => $oAgency->agency_id,
                "agency_name" => $oAgency->agency_name
            );
        }
        
        return new \ResponseHtml('bilslist', null, $arResult);
    }
    
    static function bilstable() {
        $arResult = Array();
        
        $arResult["REQ"] = $_REQUEST;
        
        list($frdt, $todt) = explode("-", $_REQUEST["range"]);
        if(!trim($frdt)) $frdt = "01.01.1970";
        if(!trim($todt)) $todt = "01.01.2100";

        $frdt = self::uglifyHumanDate($frdt);
        $todt = self::uglifyHumanDate($todt);

        $sSql = "SELECT * FROM agencys a
                LEFT JOIN networks n ON n.agency_network_id = a.agency_network_id
                LEFT JOIN bills b ON b.agency_id = a.agency_id
            WHERE date BETWEEN :frdt AND :todt
            ORDER BY a.agency_name";
        $connection = \Repository::getConnection();
        $stmt = $connection->prepare($sSql);
        $stmt -> bindParam(':frdt', $frdt);
        $stmt -> bindParam(':todt', $todt);
        $stmt -> execute();

        $result = $stmt->fetchAll();

        $arResult["RES"] = $result;
        $arResult["SQL"] = $sSql;
        $arResult["DBG"] = Array($frdt, $todt);

        return new \ResponseHtml('reptable', null, $arResult);
    }
    
	static function reptable() {
	    $arResult = Array();
        
        $arResult["REQ"] = $_REQUEST;
        
        $frdt = "01-01-1970";
        $todt = "01-01-2100";
        if(trim($_REQUEST["range"]))
            list($frdt, $todt) = explode("-", $_REQUEST["range"]);

        $frdt = \Repository::uglifyHumanDate($frdt);
        $todt = \Repository::uglifyHumanDate($todt);

        $sSql = "SELECT *, SUM(amount) AS sum FROM agencys a
                LEFT JOIN networks n ON n.agency_network_id = a.agency_network_id
                LEFT JOIN (SELECT * FROM bills WHERE date BETWEEN :frdt AND :todt) b ON b.agency_id = a.agency_id
            GROUP BY a.agency_id
            ORDER BY a.agency_name";
        $connection = \Repository::getConnection();
        $stmt = $connection->prepare($sSql);
        
        $stmt -> bindParam(':frdt', $frdt);
        $stmt -> bindParam(':todt', $todt);
        
        $stmt -> execute();

        $result = $stmt->fetchAll();

        $arResult["RES"] = $result;
        $arResult["SQL"] = $sSql;
        $arResult["DBG"] = Array($frdt, $todt);

		return new \ResponseHtml('reptable', null, $arResult);
	}
    
	
	public static function __callStatic($name, array $params) {
		return new \ResponseHtml($name);
	}
	
	
}
