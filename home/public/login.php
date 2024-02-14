<?php
session_start();

require_once("../connessione.php");
$nome = $connessione->real_escape_string($_POST['nomeUtente']);
$password = $connessione->real_escape_string($_POST['password']);

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $sql_select = "SELECT * FROM utenti WHERE username = '$nome'";
    $result = $connessione->query($sql_select);
    if (mysqli_num_rows($result)) {
        $row = $result->fetch_array();
        if (password_verify($password, $row['password'])) {
            $_SESSION['loggato'] = true;
            
            header("location: area-privata.php");
        } else {
            echo "La password non è corretta";
        }
    } else {
        echo "Non ci sono account con questo username";
    }
}

if (!isset($_SESSION['loggato']) || $_SESSION['loggato'] !== true) {
   header("location: login.html");
} else {

}
?>