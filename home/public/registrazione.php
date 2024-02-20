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
        $idMagazzino = $row['id'];
        $sql3 = "INSERT INTO utente(username,password,n_settimana,idMagazzino)VALUES('$nome','$hashed_password',' 1 ',' $idMagazzino ')";
        if ($connessione->query($sql3)) {
            $sql4 = "SELECT * FROM magazzino ORDER BY id DESC LIMIT 1";
            $result = $connessione->query($sql4);
            if (mysqli_num_rows($result)) {
                $row = $result->fetch_array();
                $idUtente = $row['id'];
                $sql5 = "INSERT INTO costoFisso(nome,prezzo,idUtente)VALUES('Gas', 50, '$idUtente'),('Luce', 450, '$idUtente'),('Affitto', 1700, '$idUtente');";
                if ($connessione->query($sql5)) {
                    $sql6 = "SELECT id FROM prodotto ORDER BY id";
                    $result = $connessione->query($sql6);
                    if (mysqli_num_rows($result)) {
                        while ($idProdotto = $result->fetch_array()) {
                            $sql7 = "INSERT INTO immagazzina(idMagazzino,idProdotto,quantitàPr) VALUES ('$idMagazzino', '$idProdotto', 0)";
                            if (!$connessione->query($sql7)) {
                                $interruttore = false;
                                EchoMessage("Errore nella insert in immagazzina" . $sql7 . " . " . $connessione->error, "./registrazione.html");
                                $connessione->close();
                            }
                        }
                        if ($interruttore) {
                            EchoMessage("Registrazione effettuata con successo", "../private/home.php");
                            $_SESSION['loggato'] = true;
                        }
                    } else {
                        EchoMessage("Errore nella select dai prodotti" . $sql6 . " . " . $connessione->error, "./registrazione.html");
                        $connessione->close();
                    }
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
