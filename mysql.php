<?php
    require_once("config.php"); //Stores our MySQL connection info such as IP & password.

    if (!isset($_SESSION)) {
        session_start();
    }

    $dbInfo = "mysql:host=".$dbHost.";dbname=".$dbName;

    try {
        $db = new PDO($dbInfo,$dbUser,$dbPwd);
    } catch(Exception $ex) {
    }
?>