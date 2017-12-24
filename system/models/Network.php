<?php

namespace Models;

class Network {
    public $agency_network_id;
    public $agency_network_name;
    public function __construct($data = null) {
        if (is_array($data)) {
            if (isset($data['agency_network_id']))
                $this -> agency_network_id = $data['agency_network_id'];
            $this -> agency_network_name = $data['agency_network_name'];
        }
    }
    
    static function getRepository() {
        return new NetworksRepository();
    }
    
}

class NetworksRepository extends \Repository {
    protected $table = 'networks';
    protected $className = '\Models\Network';
    protected $keyField = 'agency_network_id';
    protected $arFields = Array('agency_network_name');
}
