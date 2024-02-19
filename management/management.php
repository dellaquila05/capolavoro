<?php 
session_start();
require_once("../connessione.php");

if(!isset($_SESSION['loggato']) || $_SESSION['loggato'] = true){
    $sql_select = "SELECT * FROM prodotto ";
    $result = $connessione->query($sql_select);
    if (mysqli_num_rows($result)) {
        $row = $result->fetch_array();
        foreach ($row['id'] as $b){
            
        }
    } else {
        $connessione->close();
    }

}

