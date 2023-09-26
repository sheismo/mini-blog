<?php
require_once "../includes/constants.php";

session_destroy();

header('location: '.BASE_URL."login.php");
?>