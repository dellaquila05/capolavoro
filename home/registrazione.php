<?php

require_once("connessione.php");
$nome = $connessione->real_escape_string($_POST['nomeUtente']);
$password = $connessione->real_escape_string($_POST['password']);

$hashed_password = password_hash($password, PASSWORD_DEFAULT);

$sql = "INSERT INTO magazzino(dimensione)VALUES(20)";

if ($connessione->query($sql)) {
    echo "Registrazione effettuata con successo";
} else {
    echo "Errore durante registrazione utente $sql. " . $connessione->error;
}
/** 
 * 
 * PRIMA DI CREARE LA TABELLA UTENTE VA CREATA LA TABELLA MAGAZZINO
 * 
 * $sql = "INSERT INTO utente(username,password,n_settimana,idMagazzino)VALUES(" . $nome . "," . $hashed_password . ",1,idMagazzino)";
 * if ($connessione->query($sql)) {
 *     echo "Registrazione effettuata con successo";
 * } else {
 *     echo "Errore durante registrazione utente $sql. " . $connessione->error;
 * }
 */
