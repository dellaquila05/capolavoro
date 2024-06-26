<?php
session_start();
ob_start();
require_once("../connessione.php");
function redirect()
{
    if (!isset($_SESSION['loggato']) || $_SESSION['loggato'] !== true) {
        header("location: ../public/login.php");
        die();
    }
}
redirect();
$idUtente = $_SESSION['idUtente'];

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




$utile = $_SESSION['utile'];
$Nsettimana = $_SESSION["n_settimana"];
?>


<!DOCTYPE html>
<html lang="it">

<head>
    <link rel="stylesheet" href="CSS.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" />
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    <title>HomeTech - Home</title>
</head>

<body>
    <div class="container">
        <nav class="navbar navbar-light" style="background-color: #ffefd5;">
            <div class="container-fluid">
                <a class="navbar-brand"><span class="material-symbols-outlined">
                        storefront
                    </span> HomeTech</a>


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

                                Ogni 52 settimane, paga le tasse e migliora la sicurezza con servizi come telecamere o allarmi. Acquista prodotti dal fornitore, soddisfa gli ordini e pianifica con attenzione. Sii strategico per trasformare il tuo impero in una storia di successo in HomeTech!
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
                <div style='text-align: center; font-family: Arial, sans-serif; font-size: 18px;'>Benvenuto <?php echo $_SESSION["nome"] ?> </div>

                <a href="../public/login.php"><button type="button" class="btn btn-outline-danger" onclick="<?php $_SESSION['loggato'] == false ?>"><span class="material-symbols-outlined">
                            logout
                        </span></button></a>
            </div>
        </nav>
        <br>
        <br><br>
        <div class="container1">
            <table class="table">
                <tbody>
                    <tr>
                        <td class="bg-custom text-center p-3"><a href="../../management/magazzino.php" class="text-decoration-none text-dark"><strong><mark>Magazzino</mark></strong> <br><img src="../../home/img/magazzino.png" alt=""></a></td>
                        <td class="bg-custom text-center p-3"><a href="../../management/fornitore.php" class="text-decoration-none text-dark"><strong><mark>Fornitore</mark></strong> <br><img src="../../home/img/fornitore.png" alt=""></a></td>
                        <td class="bg-custom text-center p-3"><a href="../../management/ordini.php" class="text-decoration-none text-dark"><strong><mark>Ordini</mark></strong> <br><img src="../../home/img/ordini.png" alt=""></a></td>
                    </tr>
                    <tr>
                        <td class="bg-custom text-center p-3"><a href="../../service/servizi.php" class="text-decoration-none text-dark"><img src="../../home/img/servizi.png" alt=""><strong><mark>Servizi</mark></strong></a></td>
                        <td class="bg-custom text-center p-3"><a href="../../service/resoconto.php" class="text-decoration-none text-dark"><img src="../../home/img/resoconto.png" alt=""><strong><mark>Resoconto</mark></strong></a></td>
                        <td class="bg-custom text-center p-3"><a href="../../service/finanze.php" class="text-decoration-none text-dark"><img src="../../home/img/finanze.png" alt=""><strong><mark>Finanze</mark></strong></a></td>
                    </tr>
                </tbody>
            </table>
        </div>


        <br><br>



        <form id="myForm" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <div class="row justify-content-center">
                <div class="col-auto">
                    <button type="submit" class="btn btn-outline-warning" name="submit">Avanti</button>
                </div>
            </div>
        </form>


        <?php
        $showModal = false; // Inizializziamo la variabile per controllare se mostrare il modale
        $gameOff = false;


        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $idUtente = $_SESSION['idUtente'];
            //eliminazione ordini precedenti
            $idMagazzino = $_SESSION['idMagazzino'];

            $sql_delete = "DELETE FROM ordine WHERE idUtente = $idUtente";
            $result_delete = $connessione->query($sql_delete);
            //generazione nuovi ordini
            $n_settimana = $_SESSION['n_settimana'];
            $numeroOrdini = mt_rand(intval($n_settimana / 10) + 1, intval($n_settimana / 5) + 1);
            for ($i = 0; $i < $numeroOrdini; $i++) {
                $sql_insert = "INSERT INTO ordine (idUtente) VALUES ($idUtente)";
                $connessione->query($sql_insert);
                $idUltimoOrdine = $connessione->insert_id;
                $numeroProdotti = mt_rand(1, $numeroOrdini + 1);
                $sql_select_2 = "SELECT COUNT(id) as numeroPr FROM prodotto";
                $result_select_2 = $connessione->query($sql_select_2);
                $numeroPr = $result_select_2->fetch_array()['numeroPr'];
                $arrayIdProdotti = [];
                $sql_select_3 = "SELECT id FROM prodotto WHERE ";
                for ($j = 0; $j < $numeroProdotti; $j++) {
                    $id = mt_rand(1, $numeroPr);
                    $sql_select_3 .= "id = " . $id . " OR ";
                    
                }
                $pos = strripos($sql_select_3, 'OR');
                    if ($pos !== false) {
                        $sql_select_3 = substr_replace($sql_select_3, "", $pos, strlen('OR'));
                    }
                $result_select_3 = $connessione->query($sql_select_3);
                while ($row3 = $result_select_3->fetch_assoc()) {
                    $id = $row3['id'];
                    array_push($arrayIdProdotti, $id);                   
                }
                $conteggioProdotti = array_count_values($arrayIdProdotti);
                $sql_insert_richiede = "INSERT INTO richiede (idOrdine, idProdotto, quantitàPr) VALUES";
                $values_richiede = "";
                foreach ($conteggioProdotti as $idProdotto => $quantitaOrdine) {
                    $values_richiede .= "($idUltimoOrdine, $idProdotto, $quantitaOrdine),";
                }
                // Rimuovi l'ultima virgola
                $values_richiede = rtrim($values_richiede, ",");
                //concatena le due stringhe 
                $sql_insert_richiede .= $values_richiede;
                $connessione->query($sql_insert_richiede);
            }


            $query = "INSERT INTO bilancio( valore, idUtente, Nsettimana) VALUES ($utile,$idUtente,$Nsettimana)";
            $result = $connessione->query($query);
            if ($result) {
                $query1 = "UPDATE utente SET n_settimana=n_settimana+1 WHERE id=$idUtente";
                $result1 = $connessione->query($query1);
                if ($result1) {
                    $_SESSION['n_settimana'] = $Nsettimana + 1;
                    $n_settimana = $_SESSION['n_settimana'];
                } else {
                    echo "Errore: " . $connessione->error;
                }
            } else {
                echo "Errore: " . $connessione->error;
            }


            $sql_select3 = "SELECT idProdotto, quantità FROM forniture WHERE idUtente = $idUtente AND settimana = $n_settimana";
            $result3 = $connessione->query($sql_select3);

            while ($row3 = $result3->fetch_assoc()) {
                $quant = $row3['quantità'];
                $idProd = $row3['idProdotto'];

                $sql_update = "UPDATE immagazzina SET quantitàPr = quantitàPr + $quant WHERE idMagazzino = $idMagazzino AND idProdotto = $idProd";
                $connessione->query($sql_update);
            }
            $randomNumber = 0;
            $nome_evento = [];
            $dettaglio = [];
            $idUtente = $_SESSION['idUtente'];
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
            /* function generaFurto()            {
                global $id;
                $probabilita = 7 / 52;
                require_once("../connessione.php");
                $query = "UPDATE immagazzina
                        SET quantitàPr = quantitàPr - 1
                        WHERE idProdotto IN (
                        SELECT idProdotto
                        FROM immagazzina
                        WHERE quantitàPr > 0
                        ORDER BY RANDOM()
                        LIMIT FLOOR(RAND() * 4) + 1) AND idMagazzino = $idMagazzino  ;";
                $result = $connessione->query($query);

                // Genero un numero casuale tra 0 e 52
                if (rand(0, 52) <= $probabilita * 52) {
                    $id[] = 3;
                }
            }*/

            if ($_SESSION['n_settimana'] % 4 == 0) {
                $query_totale = "SELECT SUM(prezzo) as Totale_Spese FROM costoFisso WHERE idUtente = $idUtente";
                $result_totale = $connessione->query($query_totale);
                if ($result_totale) {
                    while ($row = $result_totale->fetch_assoc()) {
                        $costo = $row['Totale_Spese'];
                        $query = " UPDATE utente SET utile=$utile-$costo WHERE  id = $idUtente ; ";
                        $result = $connessione->query($query);
                        if ($result) {
                            //ok
                            $_SESSION['utile'] = $utile - $row['Totale_Spese'];
                        } else {
                            echo "Errore: " . $connessione->error;
                        }
                    }
                } else {
                    echo "Errore: " . $connessione->error;
                }
            }
            generaRapina($resultRapina);
            if ($_SESSION['n_settimana'] % 52 == 0) {
                $id[] = 1;
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
            if ($_SESSION['utile'] < 1) {
                $id[] = 9;
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
            $sql_select = "SELECT dettaglio , nome , id 
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
                                $randomNumber = 1;
                                $nome_evento[] = $row['nome'];
                                $dettaglio[] =  $row['dettaglio'];
                                $ID = $row['id'];
                                $update1 = "UPDATE costoFisso SET prezzo = prezzo * 1.20 WHERE nome = 'Luce' AND idUtente = $idUtente";
                                $update2 = "UPDATE costoFisso SET prezzo = prezzo * 1.15 WHERE nome = 'Gas' AND idUtente = $idUtente";
                                $result1 = $connessione->query($update1);
                                $result2 = $connessione->query($update2);

                                break;
                            case 6:
                                // Codice per l'ID 6
                                $randomNumber = 1;
                                $nome_evento[] = $row['nome'];
                                $dettaglio[] =  $row['dettaglio'];
                                $ID = $row['id'];
                                $update1 = "UPDATE costoFisso SET prezzo = prezzo * 1.10 WHERE nome = 'Luce' AND idUtente = $idUtente";
                                $update2 = "UPDATE costoFisso SET prezzo = prezzo * 1.10 WHERE nome = 'Gas' AND idUtente = $idUtente";
                                $result1 = $connessione->query($update1);
                                $result2 = $connessione->query($update2);

                                break;
                            case 7:
                                // Codice per l'ID 7
                                $randomNumber = 1;
                                $nome_evento[] = $row['nome'];
                                $dettaglio[] =  $row['dettaglio'];
                                $ID = $row['id'];
                                $update1 = "UPDATE costoFisso SET prezzo = prezzo * 1.15 WHERE nome = 'Luce' AND idUtente = $idUtente";
                                $update2 = "UPDATE costoFisso SET prezzo = prezzo * 1.20 WHERE nome = 'Gas' AND idUtente = $idUtente";
                                $result1 = $connessione->query($update1);
                                $result2 = $connessione->query($update2);

                                break;
                            case 8:
                                // Codice per l'ID 8
                                $randomNumber = 1;
                                $nome_evento[] = $row['nome'];
                                $dettaglio[] =  $row['dettaglio'];
                                $ID = $row['id'];
                                $update1 = "UPDATE costoFisso SET prezzo = prezzo * 3 WHERE nome = 'Luce' AND idUtente = $idUtente";
                                $update2 = "UPDATE costoFisso SET prezzo = prezzo * 2.5 WHERE nome = 'Gas' AND idUtente = $idUtente";
                                $result1 = $connessione->query($update1);
                                $result2 = $connessione->query($update2);

                                break;
                            case 9:
                                // Codice per l'ID 2
                                $randomNumber = 1;
                                if ($_SESSION['n_settimana'] % 4 == 0) {
                                    $nome_evento[] = "Game Over";
                                    $dettaglio[] =  $row['dettaglio'];
                                    $_SESSION['loggato'] = false;
                                    $delete_ordine = "DELETE FROM ordine WHERE idUtente=$idUtente";
                                    $delete_result = $connessione->query($delete_ordine);
                                    if ($delete_result) {
                                        //ok
                                    } else {
                                        echo "Errore: " . $connessione->error;
                                    }

                                    $queryO = " DELETE FROM bilancio WHERE idUtente=$idUtente ; ";
                                    $resultO = $connessione->query($queryO);
                                    if ($resultO) {
                                        //ok
                                    } else {
                                        echo "Errore: " . $connessione->error;
                                    }

                                    $queryR = " DELETE FROM `costoFisso` WHERE nome='StipendioDip' AND idUtente=$idUtente ";
                                    $resultR = $connessione->query($queryR);
                                    if ($resultR) {
                                        //ok
                                    } else {
                                        echo "Errore: " . $connessione->error;
                                    }


                                    $queryF = " DELETE FROM forniture WHERE idUtente=$idUtente ";
                                    $resultF = $connessione->query($queryF);
                                    if ($resultF) {
                                        //ok
                                    } else {
                                        echo "Errore: " . $connessione->error;
                                    }



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

                                    $update5 = "UPDATE immagazzina SET quantitàPr = 0 WHERE  idMagazzino = $idMagazzino";
                                    $update6 = "UPDATE utente SET n_settimana = 1 , utile = 5000 WHERE  id = $idUtente";
                                    $result1 = $connessione->query($update1);
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
                                } else {
                                    $nome_evento[] = $row['nome'];
                                    $dettaglio[] = "Gentile Utente,Ci rivolgiamo a lei per comunicarle che attualmente il suo saldo contabile risulta essere in negativo, il che potrebbe mettere a rischio la solidità finanziaria della sua attività.
                                    Per garantire il benessere finanziario della sua azienda e prevenire qualsiasi difficoltà aggiuntiva, le consigliamo di valutare attentamente le strategie finanziarie disponibili per migliorare la sua situazione.
                                    Cordiali saluti.";
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
                        <?php if ($_SESSION['loggato'] !== true) {
                        ?><button type="button" class="btn btn-danger" onclick=' window.location.href="../public/login.php" '>Esci dal gioco</button> <?php
                                                                                                                                                    } else { ?>
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <?php } ?>
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
            //commit
        </script>
        <?php ob_end_flush(); ?>

    </div>
</body>

</html>