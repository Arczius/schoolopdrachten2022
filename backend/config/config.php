<?php

$serverName = "127.0.0.1";
$databaseName = "character";
$username = "root";
$password = "mysql";

try {
    $db = new PDO("mysql:host=$serverName;dbname=$databaseName", $username, $password);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}
catch(PDOException $e){
    echo "<p style='font-size: 2rem; font-family: monospace;'>" .$e->getMessage() . "</p>";
}