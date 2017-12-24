<?php
namespace Controllers;

/*use Models\Network,
    Models\Agency as Agency,
    Models\Bill;*/

class Rest {
    
    static function bills(){
        
        if($_SERVER["REQUEST_METHOD"] == "GET") {
            $result = Array();

            $sSql = "SELECT *,
                    b.agency_id AS aid,
                    b.id AS bill_id
                FROM bills b
                    LEFT JOIN agencys a ON b.agency_id = a.agency_id
                    LEFT JOIN networks n ON n.agency_network_id = a.agency_network_id
                    ORDER BY a.agency_name";
            $connection = \Repository::getConnection();
            $stmt = $connection->prepare($sSql);
            $stmt -> execute();

            $arAllItems = $stmt->fetchAll();
            foreach($arAllItems AS $arSrcItem){
                $arItem = Array(
                    "id" => $arSrcItem["bill_id"],
                    "agency_id" => $arSrcItem["agency_id"],
                    "agency_name" => $arSrcItem["agency_name"],
                    "agency_network_id" => $arSrcItem["agency_network_id"],
                    "agency_network_name" => $arSrcItem["agency_network_name"],
                    "user_id" => $arSrcItem["user_id"],
                    "date" => \Repository::butifyDate($arSrcItem["date"]),
                    "amount" => $arSrcItem["amount"]
                );
                $result["ITEMS"][] = $arItem;
            }

            return new \ResponseJson($result);
        }
        elseif($_SERVER["REQUEST_METHOD"] == "POST"){
            $result = Array();
            
            $data = $_REQUEST["item"];
            
            $data['date'] = \Repository::uglifyHumanDate($data['date']);
            
            $repo = \Models\Bill::getRepository();
            $result['item'] = $repo->save(new \Models\Bill($data));
            
            $agRep = \Models\Agency::getRepository();
            $agItem = $agRep->find($result['item']->agency_id);
            $result['item']->agency_name = $agItem->agency_name;

            return new \ResponseJson($result);
        }
        elseif($_SERVER["REQUEST_METHOD"] == "DELETE"){
            $result = Array();
            $data = $_REQUEST;
            $repo = \Models\Bill::getRepository();
            $result['res'] = $repo->delete($data['id']);
            return new \ResponseJson($result);
        }
    }
    
}