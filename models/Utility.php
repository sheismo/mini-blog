<?php

class Utility extends Connection {

    protected $conn;
    public function __construct($conn) {
        $this->conn = $conn;
    }

    public function hashPassword($passwordString) : String {
        return password_hash($passwordString, PASSWORD_BCRYPT);
    }
    
    public function checkPassword($password, $savedPassword) {
        return password_verify($password, $savedPassword);
    }
    
    public function uniqueReference($length = 16) {
        
    }
    
    public function validateEmail($email) {
        return filter_var($email, FILTER_VALIDATE_EMAIL);
    }
    
    public function validateReformPhoneNumber($phoneNumber) {
        $unwantedElement = array(' ', '+', '-');
        $phoneNumber = str_replace($unwantedElement, "", $phoneNumber);

        if(substr($phoneNumber, 0, 3) == '234') {
            return '0'.substr($phoneNumber, 3);
        }
        return $phoneNumber;
    }

    public function niceDateFormat($date, $format="date_time") {

        if ($format == "date_time") {
            $format = "D j, M Y h:ia";
        } else {
            $format = "D j, M Y";
        }

        $timestamp = strtotime($date);
        $niceFormat = date($format, $timestamp);

        return $niceFormat;
    }

}
?>