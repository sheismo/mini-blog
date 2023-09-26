<?php
    class Connection {
        protected $conn;
        
        function __construct($dbHost, $dbUser, $dbPassword, $dbName) {
            try {
                $this->conn = new PDO('mysql:host='.$dbHost.';dbname='.$dbName, $dbUser, $dbPassword);
                // echo "Successfully connected to database"; 
            } catch(Exception $e) {
                echo "Connection failed ".$e->getMessage();
                exit;
            }
        }

        public function getRecord($query) {
            $stmt = $this->conn->prepare($query);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC);
        }

        // public function getSingleRecord($table, $field = "*", $condition = "") {
        //     $stmt = $this->conn->prepare("Select $field from $table where 1 ".$condition);
        //     $stmt->execute();
        //     return $stmt->fetch(PDO::FETCH_ASSOC);
        // }

        public function getAllRecords($query) {
            $stmt = $this->conn->prepare($query);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
        
        public function countRecord($query) {
            $stmt = $this->conn->prepare($query);
            $stmt->execute();
            $result = $stmt->rowCount();
            return $result;
        }

        // public function deleteTable($tableName) {
        //     $stmt = $this->conn->prepare('DROP TABLE '.$tableName);
        //     $stmt->execute();
        //     return $stmt->fetch(PDO::FETCH_ASSOC);
        // }

        // public function deleteEntry($tableName, $condition) {
        //     $stmt = $this->conn->prepare('DELETE FROM '.$tableName.' WHERE '.$condition);
        //     return $stmt->execute();
        // }


        public function insertRecord($query) {
            try {
                $stmt = $this->conn->prepare($query);
                $stmt->execute();
                return $stmt->rowCount();
            } catch (Exception $e) {
                echo "Error " . $e->getMessage();
            }
        }

        public function deleteRecord ($query) {
            $stmt = $this->conn->prepare($query);
            $stmt->execute();
            return $stmt->rowCount();
        }

        public function updateRecord($query) {
            $stmt = $this->conn->prepare($query);
            $stmt->execute();
            return $stmt->rowCount();
        }
    }

 ?> 