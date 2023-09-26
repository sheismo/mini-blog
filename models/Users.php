<?php
require_once MODEL_DIR."Utility.php";
class Users {
    protected $conn;
    public function __construct($conn) {
        $this->conn = $conn;
    }

    public function userInfo($userId) : array {
        $query = "Select * from users where id=$userId";
        $user = self::retrieveUser ($query);
        $user['initial'] = self::reformName($user['name']);
        return $user;
    }

    public function retrieveUser ($query) {
        return $this->conn->getRecord($query);
    }

    public function countUsers ($query) {
        return $this->conn->countRecord($query);
    }
    
    public function createUser ($query) {
        return $this->conn->insertRecord($query);
    }

    private function reformName($name) {
        $explodeName = explode(" ", $name);

        $surname = $explodeName[0];
        $firstname = isset($explodeName[1]) ? substr($explodeName[1], 0, 1) : "";
        $lastname = isset($explodeName[2]) ? substr($explodeName[2], 0, 1) : "";

        $formName = $surname." ".$firstname.". ".$lastname;
        if ($lastname) {
            $formName = $formName.".";
        }
        return $formName;
    }
}
?>