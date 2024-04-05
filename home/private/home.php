<?php
session_start();
require_once("../connessione.php");

if (!isset($_SESSION['loggato']) || $_SESSION['loggato'] !== true) {
    header("location: ../public/login.php");
}

$idUtente = $_SESSION['idUtente'];
$utile = $_SESSION['utile'];
$Nsettimana= $_SESSION["n_settimana"];
?>


<!DOCTYPE html>
<html lang="it">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    <title>Home</title>
    <style>
        /* Stile generale della pagina */
        html {
            height: 100%;
            /* Imposta altezza al 100% della finestra del browser */
        }

        body {
            height: 100%;
            background-color: #f8f9fa;
            /* Colore di sfondo */
            font-family: Arial, sans-serif;
            /* Tipo di carattere */
            margin: 0;
            padding: 0;
            overflow: hidden;

        }

        /* Navbar */
        .navbar {
            width: 100%;
            /* Estendi la larghezza su tutto lo schermo */
            background-color: #343a40;
            /* Colore di sfondo */
        }

        /* Contenitore principale */
        .container {
            width: 100%;
            min-height: calc(100vh - 56px);
            /* Altezza massima meno l'altezza della navbar */
            padding: 20px;
            background-color: #fff;
            /* Colore di sfondo del contenitore */
            border-radius: 10px;
            /* Bordi arrotondati */
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            /* Ombra */
        }

        /* Tabella */
        table {
            width: 100%;
            height: 100%;
            border-collapse: collapse;
        }

        table img {
            display: block;
            margin: 0 auto;
            width: 100px;
            height: auto;
            border-radius: 10px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        table td {
            text-align: center;
            vertical-align: middle;
            padding: 20px;
            /* Spazio interno alle celle */
        }

        /* Nome dell'immagine */
        .nome-immagine {
            font-size: 14px;
            margin-top: 10px;
            color: #555;
            /* Colore del testo */
        }

        /* Bottone "Avanti" */
        .btn-avanti {
            position: fixed;
            bottom: 20px;
            right: 20px;
            background-color: #007bff;
            /* Colore di sfondo */
            color: #fff;
            /* Colore del testo */
            border: none;
            padding: 10px 20px;
            /* Spazio interno */
            border-radius: 5px;
            /* Bordi arrotondati */
            cursor: pointer;
            transition: background-color 0.3s;
            /* Transizione al passaggio del mouse */
        }

        .btn-avanti:hover {
            background-color: #0056b3;
            /* Cambia colore al passaggio del mouse */
        }

        /* Modale */
        .modal-content {
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
    </style>
</head>

<body>
    <div class="container">
        <nav class="navbar navbar-expand-lg bg-body-tertiary">
            <div class="container-fluid">
                <a class="navbar-brand">HomeTech</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarText" aria-controls="navbarText" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <button type="button" class="btn" data-bs-toggle="modal" data-bs-target="#exampleModal">
                    <span class="material-symbols-outlined">
                        info
                    </span>
                </button>

                <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h1 class="modal-title fs-5" id="exampleModalLabel">HomeTech</h1>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                Benvenuto in HomeTech, il simulatore di gestione aziendale degli elettrodomestici!

                                Inizia con un budget di 2000€ e gestisci il tuo impero settimana dopo settimana. Evita la bancarotta coprendo i costi fissi ogni 4 settimane. Affronta eventi imprevisti come guerre e furti, che influenzano le tue finanze.

                            Ogni 48 settimane, paga le tasse e migliora la sicurezza con servizi come telecamere o allarmi. Acquista prodotti dal fornitore, soddisfa gli ordini e pianifica con attenzione. Sii strategico per trasformare il tuo impero in una storia di successo in HomeTech!
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div>
            <p id="settimana">
                Numero settimana:
                <?php echo $_SESSION["n_settimana"]; ?>
            </p>
            <p id="utile">
                Utile:
                <?php echo $_SESSION["utile"]; ?>
                €
            </p>
           <a href="/home/public/login.php"><button type="button" class="btn btn-outline-dark" onclick="<?php $_SESSION['loggato'] == false ?>">Log Out</button></a>
        </div>
    </nav>
    <br><br><br>
    <div class="container mt-4">
        <table class="table">
            <tbody>
                <tr>
                    <td><a href="../../management/magazzino.php">Magazzino <br><img src="../../home/img/magazzino.png" alt=""><br></a></td>
                    <td><a href="../../management/fornitore.php">Fornitore <br><img src="../../home/img/fornitore.png" alt=""><br></a></td>
                    <td><a href="../../management/ordini.php">Ordini <br><img src="../../home/img/ordini.avif" alt=""><br></a></td>
                </tr>
                <tr>
                    <td><a href="../../service/servizi.php"><img src="../../home/img/servizi.png" alt=""><br>Servizi</a></td>
                    <td><a href="../../service/resoconto.php"><img src="../../home/img/resoconto.png" alt=""><br>Resoconto</a></td>
                    <td><a href="../../service/finanze.php"><img src="../../home/img/finanze.png" alt=""><br>Finanze</a></td>
                </tr>
            </tbody>
        </table>
        <br><br>

        <div class="container1">
    <div class="row justify-content-end">
        <form id="myForm" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <div class="col-2 text-end"> <!-- Utilizzo la classe 'text-end' per allineare il contenuto a destra -->
                <button type="submit" class="btn btn-primary" name="submit">Avanti</button>
            </div>
        </form>
    </div>
</div>


    <?php
    $showModal = false; // Inizializziamo la variabile per controllare se mostrare il modale
    if ($_SERVER["REQUEST_METHOD"] == "POST") {


        
        $query = "INSERT INTO bilancio( valore, idUtente, Nsettimana) VALUES ($utile,$idUtente,$Nsettimana)";
        $result = $connessione->query($query);
        if ($result) { 
                $query1 = "UPDATE utente SET n_settimana=n_settimana+1 WHERE id=$idUtente";
                $result1 = $connessione->query($query1);
                if ($result1) { 
                    $_SESSION['n_settimana'] = $Nsettimana+1;
                } else {
                    echo "Errore: " . $connessione->error;
                }
        } else {
            echo "Errore: " . $connessione->error;
        }

        $randomNumber = 0;
        $nome_evento = [];
        $dettaglio = [];
        $idUtente = $_SESSION['idUtente'];
        $idMagazzino = $_SESSION['idMagazzino'];
        $id = [];
        $sql_selectrapa = 'SELECT nome,prezzo FROM `costoFisso` WHERE nome="Telecamere" OR nome ="Allarme" OR nome="Guardia"';
        $resultRapina = $connessione->query($sql_selectrapa);
        $telecamere = 0;
        $allarme = 0;
        $guardia = 0;
        function generaRapina($resultRapina)
        {
            global $id;
            if (mysqli_num_rows($resultRapina)) {
                while ($row = $resultRapina->fetch_assoc()) {
                    // Assegnazione dei prezzi alle variabili
                    switch ($row['nome']) {
                        case 'Telecamere':
                            $telecamere = $row['prezzo'];
                            break;
                        case 'Allarme':
                            $allarme = $row['prezzo'];
                            break;
                        case 'Guardia':
                            $guardia = $row['prezzo'];
                            break;
                    }
                }
            }
                                Ogni 48 settimane, paga le tasse e migliora la sicurezza con servizi come telecamere o allarmi. Acquista prodotti dal fornitore, soddisfa gli ordini e pianifica con attenzione. Sii strategico per trasformare il tuo impero in una storia di successo in HomeTech!
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            </div>
                        </div>
                    </div>
                </div>
                <p id="settimana">
                    Numero settimana:
                    <?php echo $_SESSION["n_settimana"]; ?>
                </p>
                <p id="utile">
                    Utile:
                    <?php echo $_SESSION["utile"]; ?>
                    €
                </p>
            </div>
            <div class="row justify-content-end">
                <form id="myForm" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                    <div class="col-2 text-end"> <!-- Utilizzo la classe 'text-end' per allineare il contenuto a destra -->
                        <button type="submit" class="btn btn-primary" name="submit">Avanti</button>
                    </div>
                </form>
            </div>
        </nav>
        <br><br><br>
        <div class="container mt-4">
            <table class="table">
                <tbody>
                    <tr>
                        <td><a href="../../management/magazzino.php">Magazzino <br><img src="../../home/img/magazzino.png" alt=""><br></a></td>
                        <td><a href="../../management/fornitore.php">Fornitore <br><img src="../../home/img/fornitore.png" alt=""><br></a></td>
                        <td><a href="../../management/ordini.php">Ordini <br><img src="../../home/img/ordini.avif" alt=""><br></a></td>
                    </tr>
                    <tr>
                        <td><a href="../../service/servizi.php"><img src="../../home/img/servizi.png" alt=""><br>Servizi</a></td>
                        <td><a href="../../service/resoconto.php"><img src="../../home/img/resoconto.png" alt=""><br>Resoconto</a></td>
                        <td><a href="../../service/finanze.php"><img src="../../home/img/finanze.png" alt=""><br>Finanze</a></td>
                    </tr>
                </tbody>
            </table>
            <br><br>
        </div>
        <?php
        $showModal = false; // Inizializziamo la variabile per controllare se mostrare il modale

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $randomNumber = 0;
            $nome_evento = [];
            $dettaglio = [];
            $idUtente = $_SESSION['idUtente'];
            $idMagazzino = $_SESSION['idMagazzino'];
            $id = [];
            $sql_selectrapa = 'SELECT nome,prezzo FROM `costoFisso` WHERE nome="Telecamere" OR nome ="Allarme" OR nome="Guardia"';
            $resultRapina = $connessione->query($sql_selectrapa);
            $telecamere = 0;
            $allarme = 0;
            $guardia = 0;
            function generaRapina($resultRapina)
            {
                global $id;
                if (mysqli_num_rows($resultRapina)) {
                    while ($row = $resultRapina->fetch_assoc()) {
                        // Assegnazione dei prezzi alle variabili
                        switch ($row['nome']) {
                            case 'Telecamere':
                                $telecamere = $row['prezzo'];
                                break;
                            case 'Allarme':
                                $allarme = $row['prezzo'];
                                break;
                            case 'Guardia':
                                $guardia = $row['prezzo'];
                                break;
                        }
                    }
                }

                // Inizializzo la probabilità di rapina a 7/52
                $probabilita = 7 / 52;
                // Altrimenti, calcolo la probabilità di rapina in base agli altri casi
                if ($telecamere > 0) {
                    $probabilita -= 1 / 52;
                }
                if ($allarme > 0) {
                    $probabilita -= 2 / 52;
                }
                if ($guardia > 0) {
                    $probabilita -= 3 / 52;
                }
                // Genero un numero casuale tra 0 e 52
                if (rand(0, 52) <= $probabilita * 52) {
                    $id[] = 3;
                }
            }

            generaRapina($resultRapina);
            if ($_SESSION['n_settimana'] % 52 == 0) {
                $id[] = 1;
            }
            if ($_SESSION['utile'] < 1) {
                $id[] = 2;
            }
            if ($idUtente == 100) {
                $id[] = 4;
            }
            if ($_SESSION['n_settimana'] == 15) {
                $id[] = 5;
            }
            if ($_SESSION['n_settimana'] == 35) {
                $id[] = 6;
            }
            if ($_SESSION['n_settimana'] == 58) {
                $id[] = 7;
            }
            if ($_SESSION['n_settimana'] == 88) {
                $id[] = 8;
            }
            $stringa = "";
            if (!empty($id)) {
                $stringa = "WHERE ";
                for ($i = 0; $i < count($id); $i++) {
                    $stringa = $stringa . "id = " . $id[$i] . " OR ";
                }
            }
            $pos = strripos($stringa, 'OR');
            if ($pos !== false) {
                $stringa = substr_replace($stringa, "", $pos, strlen('OR'));
            }
            $sql_select = "SELECT dettaglio , nome , id , stato
                    FROM evento " . $stringa;

            $result = $connessione->query($sql_select);
            if (mysqli_num_rows($result)) {
                while ($row = $result->fetch_assoc()) {
                    $current_id = $row['id'];
                    if (in_array($current_id, $id)) {
                        switch ($current_id) {
                            case 1:
                                // Codice per l'ID 1
                                $randomNumber = 1;
                                $nome_evento[] = $row['nome'];
                                $dettaglio[] =  $row['dettaglio'];
                                $update1 = "UPDATE utente SET utile = utile * 0.6  WHERE id = $idUtente";
                                $result1 = $connessione->query($update1);
                                $query1 = "SELECT utile , n_settimana FROM utente WHERE id = $idUtente";
                                $result22 = $connessione->query($query1);
                                if (mysqli_num_rows($result22)) {
                                    while ($row22 = $result22->fetch_assoc()) {
                                        $_SESSION['utile'] = $row22['utile'];
                                        $_SESSION['n_settimana'] = $row22['n_settimana'];
                                    }
                                }
                                break;
                            case 2:
                                // Codice per l'ID 2
                                $randomNumber = 1;
                                if ($_SESSION['n_settimana'] % 4 == 0) {
                                    $nome_evento[] = "Game Over";
                                    $dettaglio[] =  $row['dettaglio'];
                                    $update1 = "UPDATE costoFisso
                                SET prezzo = CASE 
                                                WHEN nome = 'Luce' THEN 450
                                                WHEN nome = 'Gas' THEN 50
                                                WHEN nome = 'Affitto' THEN 1700
                                                WHEN nome = 'Allarme' THEN 0
                                                WHEN nome = 'Telecamere' THEN 0
                                                WHEN nome = 'Guardia' THEN 0
                                                ELSE prezzo 
                                            END
                                WHERE nome IN ('Luce', 'Gas', 'Affitto', 'Allarme', 'Telecamere', 'Guardia') AND idUtente = $idUtente";

                                    $sql_select2 = "SELECT m.dimensione
                                                    FROM magazzino m 
                                                    JOIN utente u ON u.idMagazzino = m.id
                                                    WHERE u.id = $idUtente
                                                   ";
                                    $update3 = "UPDATE evento SET stato = 0 WHERE  stato = 1";
                                    $sql_select4 = "SELECT quantitàPr FROM immagazzina WHERE idMagazzino = $idMagazzino";
                                    $update5 = "UPDATE immagazzina SET quantitàPr = 0 WHERE  idMagazzino = $idMagazzino";
                                    $update6 = "UPDATE utente SET n_settimana = 1 , utile = 2000 WHERE  id = $idUtente";
                                    $result1 = $connessione->query($update1);
                                    $result2 = $connessione->query($sql_select2);
                                    $result3 = $connessione->query($update3);
                                    $result4 = $connessione->query($sql_select4);
                                    $result5 = $connessione->query($update5);
                                    $result6 = $connessione->query($update6);
                                    $query1 = "SELECT utile , n_settimana FROM utente WHERE id = $idUtente";
                                    $result22 = $connessione->query($query1);
                                    if (mysqli_num_rows($result22)) {
                                        while ($row22 = $result22->fetch_assoc()) {
                                            $_SESSION['utile'] = $row22['utile'];
                                            $_SESSION['n_settimana'] = $row22['n_settimana'];
                                        }
                                    }
                                    if (mysqli_num_rows($result4)) {
                                        while ($row = $result4->fetch_assoc()) {
                                            $somma += $row['quantitàPr'];
                                        }
                                        $_SESSION['prodottiMaga'] = $somma;
                                    }
                                    if (mysqli_num_rows($result2)) {
                                        while ($row = $result2->fetch_assoc()) {
                                            $dimensione = $row['dimensione'];
                                        }
                                        $_SESSION['dimensioneMaga'] = $dimensione;
                                    }
                                } else {
                                    $nome_evento[] = $row['nome'];
                                    $dettaglio[] = "Gentile Utente,Ci rivolgiamo a lei per comunicarle che attualmente il suo saldo contabile risulta essere in negativo, il che potrebbe mettere a rischio la solidità finanziaria della sua attività.
                                Per garantire il benessere finanziario della sua azienda e prevenire qualsiasi difficoltà aggiuntiva, le consigliamo di valutare attentamente le strategie finanziarie disponibili per migliorare la sua situazione.
                                Cordiali saluti.";
                                }
                                break;
                            case 3:
                                // Codice per l'ID 3
                                $randomNumber = 1;
                                $nome_evento[] = $row['nome'];
                                $dettaglio[] =  $row['dettaglio'];
                                $update1 = "UPDATE utente SET utile = utile * 0.8  WHERE id = $idUtente";
                                $result1 = $connessione->query($update1);
                                $query1 = "SELECT utile , n_settimana FROM utente WHERE id = $idUtente";
                                $result22 = $connessione->query($query1);
                                if (mysqli_num_rows($result22)) {
                                    while ($row22 = $result22->fetch_assoc()) {
                                        $_SESSION['utile'] = $row22['utile'];
                                        $_SESSION['n_settimana'] = $row22['n_settimana'];
                                    }
                                }
                                break;
                            case 4:
                                // Codice per l'ID 4
                                // Non specificato nel tuo caso, quindi lasciato vuoto
                                break;
                            case 5:
                                // Codice per l'ID 5
                                if ($row['stato'] == 0) {
                                    $randomNumber = 1;
                                    $nome_evento[] = $row['nome'];
                                    $dettaglio[] =  $row['dettaglio'];
                                    $ID = $row['id'];
                                    $update1 = "UPDATE costoFisso SET prezzo = prezzo * 1.20 WHERE nome = 'Luce' AND idUtente = $idUtente";
                                    $update2 = "UPDATE costoFisso SET prezzo = prezzo * 1.15 WHERE nome = 'Gas' AND idUtente = $idUtente";
                                    $update3 = "UPDATE evento SET stato = 1 WHERE id = $ID AND stato = 0";
                                    $result1 = $connessione->query($update1);
                                    $result2 = $connessione->query($update2);
                                    $result3 = $connessione->query($update3);
                                }
                                break;
                            case 6:
                                // Codice per l'ID 6
                                if ($row['stato'] == 0) {
                                    $randomNumber = 1;
                                    $nome_evento[] = $row['nome'];
                                    $dettaglio[] =  $row['dettaglio'];
                                    $ID = $row['id'];
                                    $update1 = "UPDATE costoFisso SET prezzo = prezzo * 1.10 WHERE nome = 'Luce' AND idUtente = $idUtente";
                                    $update2 = "UPDATE costoFisso SET prezzo = prezzo * 1.10 WHERE nome = 'Gas' AND idUtente = $idUtente";
                                    $update3 = "UPDATE evento SET stato = 1 WHERE id = $ID AND stato = 0";
                                    $result1 = $connessione->query($update1);
                                    $result2 = $connessione->query($update2);
                                    $result3 = $connessione->query($update3);
                                }
                                break;
                            case 7:
                                // Codice per l'ID 7
                                if ($row['stato'] == 0) {
                                    $randomNumber = 1;
                                    $nome_evento = $row['nome'];
                                    $ID = $row['id'];
                                    $update1 = "UPDATE costoFisso SET prezzo = prezzo * 1.15 WHERE nome = 'Luce' AND idUtente = $idUtente";
                                    $update2 = "UPDATE costoFisso SET prezzo = prezzo * 1.20 WHERE nome = 'Gas' AND idUtente = $idUtente";
                                    $update3 = "UPDATE evento SET stato = 1 WHERE id = $ID AND stato = 0";
                                    $result1 = $connessione->query($update1);
                                    $result2 = $connessione->query($update2);
                                    $result3 = $connessione->query($update3);
                                }
                                break;
                            case 8:
                                // Codice per l'ID 8
                                if ($row['stato'] == 0) {
                                    $randomNumber = 1;
                                    $nome_evento = $row['nome'];
                                    $dettaglio[] =  $row['dettaglio'];
                                    $ID = $row['id'];
                                    $update1 = "UPDATE costoFisso SET prezzo = prezzo * 3 WHERE nome = 'Luce' AND idUtente = $idUtente";
                                    $update2 = "UPDATE costoFisso SET prezzo = prezzo * 2.5 WHERE nome = 'Gas' AND idUtente = $idUtente";
                                    $update3 = "UPDATE evento SET stato = 1 WHERE id = $ID AND stato = 0";
                                    $result1 = $connessione->query($update1);
                                    $result2 = $connessione->query($update2);
                                    $result3 = $connessione->query($update3);
                                }
                                break;
                        }
                    }
                }
                $result->free();
            } else {
                $connessione->close();
            }
            if ($randomNumber == 1) {

            $showModal = true;
        }        
    }
    ?> 
    
                $showModal = true;
            }
        }
        ?>


        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <?php $currentIdx = 0; 
// Verifica se le variabili sono definite e non vuote prima di utilizzarle con json_encode
$nome_evento_json = isset($nome_evento) ? json_encode($nome_evento) : "[]";
$dettaglio_json = isset($dettaglio) ? json_encode($dettaglio) : "[]";
?>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                let currentIdx = <?php echo $currentIdx; ?>;
                let nome_evento = <?php echo $nome_evento_json; ?>;
let dettaglio = <?php echo $dettaglio_json; ?>;
                let arrayLength = nome_evento.length;
                let modal = document.getElementById('exampleModal1');
                let modalTitle = modal.querySelector('.modal-title');
                let modalBody = modal.querySelector('.modal-body');
                let previousPageBtn = document.getElementById('previousPageBtn');
                let nextPageBtn = document.getElementById('nextPageBtn');

                modal.addEventListener('show.bs.modal', function(event) {
                    updateModalContent(currentIdx);
                });

                nextPageBtn.addEventListener('click', function() {
                    currentIdx = (currentIdx + 1) % arrayLength;
                    updateModalContent(currentIdx);
                });

                previousPageBtn.addEventListener('click', function() {
                    currentIdx = (currentIdx - 1 + arrayLength) % arrayLength;
                    updateModalContent(currentIdx);
                });

                function updateModalContent(idx) {
                    modalTitle.textContent = nome_evento[idx];
                    modalBody.textContent = dettaglio[idx];
                    if (idx === 0) {
                        previousPageBtn.style.display = 'none';
                    } else {
                        previousPageBtn.style.display = 'block';
                    }
                    if (idx === arrayLength - 1) {
                        nextPageBtn.style.display = 'none';
                    } else {
                        nextPageBtn.style.display = 'block';
                    }
                }
            });
        </script>

        <!-- Modale -->
        <div class="modal fade" id="exampleModal1" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title"></h5>
                    </div>
                    <div class="modal-body"></div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" id="previousPageBtn">Previous Page</button>
                        <button type="button" class="btn btn-primary" id="nextPageBtn">Next Page</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>


        <script>
            // Funzione per aggiornare il contenuto dei paragrafi
            function aggiornaContenuto() {
                // Aggiorna il contenuto dei paragrafi recuperando i dati PHP
                document.getElementById("settimana").innerHTML = "Numero settimana: <?php echo $_SESSION['n_settimana']; ?>";
                document.getElementById("utile").innerHTML = "Utile: <?php echo $_SESSION['utile']; ?> €";
            }

            // Esegui la funzione aggiornaContenuto ogni due secondi
            setInterval(aggiornaContenuto, 2000);
        </script>

        <!-- Bootstrap Bundle with Popper -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
        <script>
            $(document).ready(function() {
                let showModal = <?php echo $showModal ? 'true' : 'false'; ?>;

                if (showModal) {
                    $('#exampleModal1').modal('show');
                }
            });
        </script>

    </div>

</body>

</html>