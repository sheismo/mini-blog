<?php
    class Categories {
        protected $conn;

        public function __construct ($conn) {
            $this->conn = $conn;
        }

        public function getAllCategories () {
            $query = 'SELECT * FROM category';
            return $this->conn->getAllRecords($query);
        }

        public function getCategory ($categoryId) {
            $query = 'SELECT category_name FROM category WHERE id='.$categoryId;
            return $this->conn->getRecord($query);
        }
    }
?>