<?php
session_start();
require_once("../connessione.php");
$nome = $connessione->real_escape_string($_POST['nomeUtente']);
$password = $connessione->real_escape_string($_POST['password']);

$hashed_password = password_hash($password, PASSWORD_DEFAULT);

$sql1 = "INSERT INTO magazzino(dimensione)VALUES(20)";

if ($connessione->query($sql1)) {
    $sql2 = "SELECT * FROM magazzino ORDER BY id DESC LIMIT 1";
    $result = $connessione->query($sql2);
    if (mysqli_num_rows($result)) {
        $row = $result->fetch_array();
        $val = $row['id'];
        $sql3 = "INSERT INTO utente(username,password,n_settimana,idMagazzino)VALUES('$nome','$hashed_password',' 1 ',' $val ')";
        if ($connessione->query($sql3)) {
            $sql4 = "SELECT * FROM magazzino ORDER BY id DESC LIMIT 1";
            $result = $connessione->query($sql4);
            if (mysqli_num_rows($result)) {
                $row = $result->fetch_array();
                $val = $row['id'];
                $sql5 = "INSERT INTO costoFisso(nome,prezzo,idUtente)VALUES('Gas', 50, '$val'),('Luce', 450, '$val'),('Affitto', 1700, '$val');";
                if ($connessione->query($sql5)) {
                    EchoMessage("Registrazione effettuata con successo", "../private/home.php");
                    $_SESSION['loggato'] = true;
                } else {
                    EchoMessage("Errore con i costi fissi" . $sql5 . " . " . $connessione->error, "./registrazione.html");
                    $connessione->close();
                }
            } else {
                EchoMessage("Errore nella select dal utente" . $sql4 . " . " . $connessione->error, "./registrazione.html");
                $connessione->close();
            }
        } else {
            EchoMessage("Errore durante la registrazione dell'utente" . $sql3 . " . " . $connessione->error, "./registrazione.html");
            $connessione->close();
        }
    } else {
        EchoMessage("Errore durante la select dal magazzino" . $sql2 . " . " . $connessione->error, "./registrazione.html");
        $connessione->close();
    }
} else {
    EchoMessage("Errore durante la creazione del magazzino" . $sql1 . " . " . $connessione->error, "./registrazione.html");
    $connessione->close();
}

function EchoMessage($msg, $redirect)
{
    echo '<script type="text/javascript">
	alert("' . $msg . '")
	window.location.href = "' . $redirect . '"
	</script>';
}
