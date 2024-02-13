<?php

  $host = "sql11.freemysqlhosting.net";
  $username = "sql11683814";
  $password = "mERSDpttT3";
  $database = "sql11683814";

  $connessione = new mysqli($host, $username, $password, $database);
if ($connessione->connect_error) {
    die("Connessione fallita: " . $connessione->connect_error);
}
?>