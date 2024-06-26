<?php
session_start();
require_once("../home/connessione.php");

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $idUtente = $_POST['idUtente'];
    $idProdotto = $_POST['idProdotto'];
    $quantitaPr = $_POST['quantitaPr'];
    $sett = $_POST['sett'];
    $tot = $_POST['totale'];

    $query = " UPDATE utente SET utile= utile- $tot WHERE  id = $idUtente ; ";
    $connessione->query($query);
    $queryT = " SELECT utile,n_settimana FROM utente WHERE id = $idUtente ; ";
    $resultT = $connessione->query($queryT);
    if ($resultT) {
        while ($row = $resultT->fetch_assoc()) {
            $_SESSION['utile'] = $row["utile"];
            $_SESSION['n_settimana'] = $row["n_settimana"];
        }
    } else {
        echo "Errore: " . $connessione->error;
    }
    // Esegui l'inserimento nel database
    for ($i = 0; $i < count($idProdotto); $i++) {
        $query_insert = "INSERT INTO forniture (idUtente, idProdotto, quantità, settimana) 
                         VALUES ('$idUtente', '{$idProdotto[$i]}', '{$quantitaPr[$i]}', '$sett')";
        if (!$connessione->query($query_insert)) {
            echo "Errore durante l'inserimento nel database: " . $connessione->error;
            exit; // Interrompi l'esecuzione in caso di errore
        }
    }

    echo "Inserimento nel database avvenuto con successo.";
} else {
    echo "Metodo non consentito.";
}
