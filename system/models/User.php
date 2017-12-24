<?php
namespace Models;

use \Models;

class User implements \Model {
    public $id;
    public $username;
    public $firstname;
    public $lastname;
    public $email;
    public function __construct($data = null) {
        if (is_array($data)) {
            if (isset($data['id']))
                $this -> id = $data['id'];

            $this -> username = $data['username'];
            $this -> firstname = $data['firstname'];
            $this -> lastname = $data['lastname'];
            $this -> email = $data['email'];
        }
    }

    public function getFullname() {
        echo $this -> firstname . ' ' . $this -> lastname;
    }

    static function getRepo() {
        return new UserRepository();
    }

}

class UserRepository extends \Repository {
    protected $table = 'users';
    protected $className = 'User';
    protected $keyField = 'id';
    protected $arFields = Array('username', 'firstname', 'lastname', 'email');
}
