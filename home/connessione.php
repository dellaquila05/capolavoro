<?php
$path = '..\config.json';
$config_json = file_get_contents($path);
$config = json_decode($config_json, true);
$database_config = $config['database'];

$host = $database_config['host'];
$username = $database_config['username'];
$password = $database_config['password'];
$database = $database_config['database'];

$connessione = new mysqli($host, $username, $password, $database);
if ($connessione->connect_error) {
  die("Connessione fallita: " . $connessione->connect_error);
}
