<?php

namespace Models;

class Bill {
    public $agency_id;
    public $user_id;
    public $date;
    public $amount;

    public function __construct($data = null) {
        if (is_array($data)) {
            if (isset($data['id']))
                $this -> id = $data['id'];

            $this -> agency_id = $data['agency_id'];
            $this -> user_id = $data['user_id'];
            $this -> date = $data['date'];
            $this -> amount = $data['amount'];
        }
    }
    
    static function getRepository() {
        return new BillsRepository();
    }

}

class BillsRepository extends \Repository {
    protected $table = 'bills';
    protected $className = '\Models\Bill';
    protected $keyField = 'id';
    protected $arFields = Array('agency_id', 'user_id', 'date', 'amount');
}
