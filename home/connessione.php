<?php

  $host = "casaponissa.ddns.net";
  $username = "Elettrodomestici";
  $password = "Elettrodomestici";
  $database = "HomeTech";

  $connessione = new mysqli($host, $username, $password, $database);
if ($connessione->connect_error) {
    die("Connessione fallita: " . $connessione->connect_error);
}
?>