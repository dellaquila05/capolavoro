<?php
session_start();
require_once("../connessione.php");
$nome = $connessione->real_escape_string($_POST['nomeUtente']);
$password = $connessione->real_escape_string($_POST['password']);

$hashed_password = password_hash($password, PASSWORD_DEFAULT);

$sql = "INSERT INTO magazzino(dimensione)VALUES(20)";

if ($connessione->query($sql)) {
    $sql = "SELECT * FROM magazzino ORDER BY id DESC LIMIT 1";
    $result = $connessione->query($sql);
    if (mysqli_num_rows($result)) {
        $row = $result->fetch_array();
        $val = $row['id'];
        $sql = "INSERT INTO utente(username,password,n_settimana,idMagazzino)VALUES(' $nome','$hashed_password',' 1 ',' $val ')";
        if ($connessione->query($sql)) {
            EchoMessage("Registrazione effettuata con successo", "login.php");
            $_SESSION['loggato'] = true;
        } else {
            EchoMessage("Errore durante la registrazione dell'utente" . $sql . " . " . $connessione->error, "registrazione.html");
            $connessione->close();
        }
    } else {
        EchoMessage("Errore durante la select dal magazzino" . $sql . " . " . $connessione->error, "registrazione.html");
        $connessione->close();
    }
} else {
    EchoMessage("Errore durante la creazione del magazzino" . $sql . " . " . $connessione->error, "registrazione.html");
    $connessione->close();
}

function EchoMessage($msg, $redirect)
{
    echo '<script type="text/javascript">
	alert("' . $msg . '")
	window.location.href = "' . $redirect . '"
	</script>';
}
