<?php

class Importer {
    private $arCols = Array();
    private $arRows = Array(); 
    
    function proced($sFilePath) {
        $this->arCols = Array();
        $this->arRows = Array();
        
        $row = 0;
        if (($handle = fopen($sFilePath, "r")) !== FALSE) {
            while (($data = fgetcsv($handle, 1000, "\t")) !== FALSE) {
                $num = count($data);
                
                if(!$row){
                    for ($c = 0; $c < $num; $c++)
                        $this->arCols[] = $data[$c];
                }
                else {
                    $arRow = Array();
                    for ($c = 0; $c < $num; $c++)
                        $arRow[$this->arCols[$c]] = $data[$c];
                    
                   $this->arRows[] = $arRow;
                }
                $row++;

            }
            fclose($handle);
        }
        
        return $this->arRows;
    }

}