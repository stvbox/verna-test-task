<?php

namespace Models;

class Agency {
    public $agency_id;
    public $agency_network_id;
    public $agency_name;

    public function __construct($data = null) {
        if (is_array($data)) {
            if (isset($data['agency_id']))
                $this -> agency_id = $data['agency_id'];
            $this -> agency_network_id = $data['agency_network_id'];
            $this -> agency_name = $data['agency_name'];
        }
    }

    static function getRepository() {
        return new AgencysRepository();
    }

}

class AgencysRepository extends \Repository {
    protected $table = 'agencys';
    protected $className = '\Models\Agency';
    protected $keyField = 'agency_id';
    protected $arFields = Array('agency_network_id', 'agency_name');
}
