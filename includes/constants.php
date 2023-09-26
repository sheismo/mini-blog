<?php

ob_start();
session_start();

// DB Constants
define("HOST", "localhost");
define("dbUser", "root");
define("dbPassword", "");
define("dbName", "blog_site");

// database connection
require "database.php";
$conn = new Connection(HOST, dbUser, dbPassword, dbName);


// SERVER & URL
define("ROOT", $_SERVER['DOCUMENT_ROOT']);
define("HTTP_REFERER", isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : "");
define("SCHEME", $_SERVER['REQUEST_SCHEME']);
define("SERVER", $_SERVER['SERVER_NAME']);

define("BASE_PATH", "/project/");
define("BASE_URL", SCHEME."://".SERVER.BASE_PATH);
define("USER_PATH", 'user/');
define("BASE_URL_USER", BASE_URL.USER_PATH);

// Folders constant
// define("CONTROLLER_DIR", "controllers/");
define("MODEL_DIR", ROOT.BASE_PATH."/models/");
define("UPLOAD_DIR", ROOT.BASE_PATH."/assets/postimages/");

require_once "responseHandler.php";
require_once "fileupload.php";
require MODEL_DIR."Utility.php";

$utility = new Utility($conn);
?>