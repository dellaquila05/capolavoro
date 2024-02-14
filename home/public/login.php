<?php
session_start();

require_once("../connessione.php");
$nome = $connessione->real_escape_string($_POST['nomeUtente']);
$password = $connessione->real_escape_string($_POST['password']);

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $sql_select = "SELECT * FROM utente WHERE username = '$nome'";
    $result = $connessione->query($sql_select);
    if (mysqli_num_rows($result)) {
        $row = $result->fetch_array();
        if (password_verify($password, $row['password'])) {
            $_SESSION['loggato'] = true;
            header("location: ../private/home.html");
        } else {
            EchoMessage("La password non è corretta", "./login.html");
            $connessione->close();
        }
    } else {
        
        EchoMessage("Non ci sono account con questo username", "./login.html");
        $connessione->close();
    }
}

function EchoMessage($msg, $redirect)
{
    echo '<script type="text/javascript">
	alert("' . $msg . '")
	window.location.href = "' . $redirect . '"
	</script>';
}
