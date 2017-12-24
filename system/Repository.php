<?php

abstract class Repository {
    private $connection;
    
    static function getConnection(){
    	try{
        	$connection = new \PDO('sqlite:data.db');
        	$connection->setAttribute(
            	\PDO::ATTR_ERRMODE, 
            	\PDO::ERRMODE_EXCEPTION
        	);
    	}
		catch(Exception $ex){
			return null;
		}

        return $connection;
    }
    
    static function execSQL($sql){
        $connection = self::getConnection();
        $stmt = $connection->query($sql);
        $stmt -> execute();
    }
    
	public function __construct(\PDO $connection = null) {
        $this -> connection = $connection;
        if ($this -> connection === null) {
            $this -> connection = self::getConnection();
        }
    }

    public function delete($id) {
        $kf = $this->keyField;
        $sql = 'DELETE FROM '.$this->table.' WHERE '.$kf.' = :'.$kf;
        $stmt = $this -> connection -> prepare($sql);
        $stmt -> bindParam(':'.$this->keyField, $id);
        return $stmt -> execute();
    }

    public function find($id) {
        $sql = '
            SELECT "'.$this->className.'", '.$this->table.'.* 
             FROM '.$this->table.'
             WHERE '.$this->keyField.' = :'.$this->keyField;

        $stmt = $this -> connection -> prepare($sql);
        $stmt -> bindParam(':'.$this->keyField, $id);
        $stmt -> execute();

        $stmt -> setFetchMode(\PDO::FETCH_CLASS, $this->className);
        
        return $stmt -> fetch();
    }

    public function findAll() {
        $stmt = $this -> connection -> prepare('
            SELECT * FROM '.$this->table.'
        ');
        $stmt -> execute();
        $stmt -> setFetchMode(\PDO::FETCH_CLASS, $this->className);
        
        return $stmt -> fetchAll();
    }

    public function save($entity, $mode = "normal") {
        $kf = $this->keyField;

        if($mode == "normal"){
            if(isset($entity->$kf) && intval($entity->$kf)) {
                return $this -> update($entity);
            }
        }
        
        $arTmpFields = Array();
        foreach($this->arFields AS $sField)
            $arTmpFields[] = ":$sField";
        
        $sFields = implode(", ", $this->arFields);
        $sValues = implode(", ", $arTmpFields);
        
        $stmt = $this -> connection -> prepare('
            INSERT INTO '.$this->table.' 
                ('.$sFields.') 
            VALUES 
                ('.$sValues.')
        ');
        
        foreach($this->arFields AS $sField)
            $stmt -> bindParam(":$sField", $entity -> $sField);
        
        $stmt -> execute();
        $id = $this -> connection -> lastInsertId();

        return self::find($id);
        //return $stmt -> execute();
    }

    public function update($entity) {
        $kf = $this->keyField;
        
        if (!isset($entity -> $kf)) {
            // We can't update a record unless it exists...
            throw new \LogicException('Cannot update entity that does not yet exist in the database.');
        }
        
        $sFieldsVals = Array();
        foreach($this->arFields AS $sField)
            $sFieldsVals[] = "$sField = :$sField";
        
        $sSql = '
            UPDATE '.$this->table.'
            SET '.implode(", ", $sFieldsVals).'
            WHERE '.$kf.' = :'.$kf.'
        ';
        
        $stmt = $this -> connection -> prepare($sSql);
        
        $stmt -> bindParam(":$kf", $entity->$kf);
        foreach($this->arFields AS $sField)
            $stmt -> bindParam(":$sField", $entity -> $sField);
        
        $stmt -> execute();
        
        return $this->find($entity->$kf);
        //return $stmt -> execute();
    }

    static function uglifyHumanDate($sDate) {
        $sSiteDateFormat = 'd.m.Y H:i:s';
        $parsed = date_parse_from_format($sSiteDateFormat, $sDate);
        
        $ts = mktime(
            $parsed['hour'], 
            $parsed['minute'], 
            $parsed['second'], 
            $parsed['month'], 
            $parsed['day'], 
            $parsed['year']
        );
        
        return date('Y-m-d H:i:s', $ts);
    }

    static function butifyDate($sDate) {
        $sSiteDateFormat = 'Y-m-d H:i:s';
        $parsed = date_parse_from_format($sSiteDateFormat, $sDate);
        
        $ts = mktime(
            $parsed['hour'], 
            $parsed['minute'], 
            $parsed['second'], 
            $parsed['month'], 
            $parsed['day'], 
            $parsed['year']
        );
        
        return date('d.m.Y H:i:s', $ts);
    }

}
