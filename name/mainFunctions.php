<?php

/**
 * 
 * Основные функции
 * 
 */


function db() {
    $dblocation = "127.0.0.1"; //$dbhost = "localhost";
    $dbname = "labservis";
    $dbuser = "root";
    $dbpassword = "1234";

    $db = new mysqli($dblocation, $dbuser, $dbpassword, $dbname);
    
    $db->set_charset('utf8');

    if ($db->connect_errno) {
      die('MySQL access denied.');
    }
    
    if(!mysqli_select_db($db, $dbname)) {
        die("The database {$dbname} could not be accessed.");
    }
    
    return $db;
}

function createRsTwigArray($rs) {
    if (!$rs) {
        return FALSE;
    }

    $rsTwig = array();
    while ($row = $rs->fetch_assoc()) {
        $rsTwig[] = $row;
    }
    
    return $rsTwig;
}