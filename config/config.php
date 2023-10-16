<?php

use Dotenv\Dotenv;

//site name
define('SITE_NAME', 'your-site-name');

//App Root
define('APP_ROOT', dirname(dirname(__FILE__)));
define('URL_ROOT', '/');
define('URL_SUBFOLDER', '');

$dotenv = Dotenv::createImmutable(__DIR__ . '../../');
$dotenv->load();

$servername = $_ENV['DB_SERVER'];
$username = $_ENV['DB_USERNAME'];
$password = $_ENV['DB_PASSWORD'];
$dbname = $_ENV['DB_NAME'];

try {
    // create new connection to DB, PDO = PHP Data Object
    $con = new PDO("mysql:host=mysql;dbname=$dbname", $username, $password);
    $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
}
catch (PDOException $e){
    exit("Connection failed: " . $e -> getMessage());
}

