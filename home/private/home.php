<?php
session_start();
require_once("../connessione.php");

if (!isset($_SESSION['loggato']) || $_SESSION['loggato'] !== true) {
    header("location: ../public/login.php");
}
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
        table img {
            width: 40%;
            /* Imposta la larghezza al 100% della larghezza del contenitore */
            height: auto;
            /* Imposta l'altezza automaticamente per mantenere l'aspetto originale */
        }
    </style>
</head>

<body>
    <nav class="navbar navbar-expand-lg bg-body-tertiary">
        <div class="container-fluid">
            <a class="navbar-brand" href="./home.html">HomeTech</a>
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
        if ($_SESSION['n_settimana'] == 1) {
            $id[] = 1;
        }
        if (/*$_SESSION['utile'] < 0) {
            $id[] = 2;
        }
        if (/*gestione rapina*/$idUtente == 100) {
            $id[] = 3;
        }
        if (/*gestione furto*/$idUtente == 100) {
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
        $stringa = "WHERE ";
        for ($i = 0; $i < count($id); $i++) {
            $stringa = $stringa . "id = " . $id[$i] . " OR ";
        }
        $pos = strripos($stringa, 'OR');
        if ($pos !== false) {
            $stringa = substr_replace($stringa, '', $pos, strlen('OR'));
        }
        $sql_select = "SELECT dettaglio , nome , id , stato
                    FROM evento " . $stringa;
        $result = $connessione->query($sql_select);
        if (mysqli_num_rows($result)) {
            while ($row = $result->fetch_assoc()) {
                if ($row['id'] == 1) {
                    $randomNumber = 1;
                    $nome_evento[] = $row['nome'];
                    $dettaglio[] =  $row['dettaglio'];
                    $update1 = "UPDATE utente SET utile = utile * 0.6  WHERE id = $idUtente";
                    $result1 = $connessione->query($update1);
                    
                }
                if ($row['id'] == 2) {
                    $randomNumber = 1;
                    $nome_evento[] = $row['nome'];
                    if ($_SESSION['n_settimana'] % 4 == 0) {
                        $dettaglio[] =  $row['dettaglio'];
                        $id = $row['id'];
                        $update1 = "UPDATE costoFisso SET prezzo = 450 WHERE nome = 'Luce' AND idUtente = $idUtente";
                        $update2 = "UPDATE costoFisso SET prezzo = 50 WHERE nome = 'Gas' AND idUtente = $idUtente";
                        $update4 = "UPDATE costoFisso SET prezzo = 1700 WHERE nome = 'Affitto' AND idUtente = $idUtente";
                        $update3 = "UPDATE evento SET stato = 0 WHERE  stato = 1";
                        $update5 = "UPDATE immagazzina SET quantitàPr = 0 WHERE  idMagazzino = $idMagazzino";
                        $update6 = "UPDATE utente SET n_settimana = 1 , utile = 2000 WHERE  id = $idUtente";
                        $update7 = "UPDATE costoFisso SET prezzo = 0 WHERE nome = 'Allarme' AND idUtente = $idUtente";
                        $update8 = "UPDATE costoFisso SET prezzo = 0 WHERE nome = 'Telecamere' AND idUtente = $idUtente";
                        $update9 = "UPDATE costoFisso SET prezzo = 0 WHERE nome = 'Guardia' AND idUtente = $idUtente";
                        $result1 = $connessione->query($update1);
                        $result2 = $connessione->query($update2);
                        $result3 = $connessione->query($update3);
                        $result4 = $connessione->query($update4);
                        $result5 = $connessione->query($update5);
                        $result6 = $connessione->query($update6);
                        $result7 = $connessione->query($update7);
                        $result8 = $connessione->query($update8);
                        $result9 = $connessione->query($update9);
                    } else {
                        $dettaglio[] = "Gentile Utente,Ci rivolgiamo a lei per comunicarle che attualmente il suo saldo contabile risulta essere in negativo, il che potrebbe mettere a rischio la solidità finanziaria della sua attività.
                     Per garantire il benessere finanziario della sua azienda e prevenire qualsiasi difficoltà aggiuntiva, le consigliamo di valutare attentamente le strategie finanziarie disponibili per migliorare la sua situazione.
                     Cordiali saluti.";
                    }
                }
                if ($row['id'] == 3) {
                    $randomNumber = 1;
                    $nome_evento[] = $row['nome'];
                    $dettaglio[] =  $row['dettaglio'];
                    $id = $row['id'];
                    $update1 = "UPDATE utente SET utile = utile * 0.2  WHERE id = $idUtente";
                    $result1 = $connessione->query($update1);
                }
                if ($row['id'] == 4) { //metodo furto
                    /* $randomNumber = 1;
                    $nome_evento = $row['nome'];
                    $dettaglio =  $row['dettaglio'];
                    $id=$row['id'];
                    */
                }
                if ($row['id'] == 5  && $row['stato'] == 0) {
                    $randomNumber = 1;
                    $nome_evento[] = $row['nome'];
                    $dettaglio[] =  $row['dettaglio'];
                    $id = $row['id'];
                    $update1 = "UPDATE costoFisso SET prezzo = prezzo * 1.20 WHERE nome = 'Luce' AND idUtente = $idUtente";
                    $update2 = "UPDATE costoFisso SET prezzo = prezzo * 1.15 WHERE nome = 'Gas' AND idUtente = $idUtente";
                    $update3 = "UPDATE evento SET stato = 1 WHERE id = $id AND stato = 0";
                    $result1 = $connessione->query($update1);
                    $result2 = $connessione->query($update2);
                    $result3 = $connessione->query($update3);
                }
                if ($row['id'] == 6 &&  $row['stato'] == 0) {
                    $randomNumber = 1;
                    $nome_evento[] = $row['nome'];
                    $dettaglio[] =  $row['dettaglio'];
                    $id = $row['id'];
                    $update1 = "UPDATE costoFisso SET prezzo = prezzo * 1.10 WHERE nome = 'Luce' AND idUtente = $idUtente";
                    $update2 = "UPDATE costoFisso SET prezzo = prezzo * 1.10 WHERE nome = 'Gas' AND idUtente = $idUtente";
                    $update3 = "UPDATE evento SET stato = 1 WHERE id = $id AND stato = 0";
                    $result1 = $connessione->query($update1);
                    $result2 = $connessione->query($update2);
                    $result3 = $connessione->query($update3);
                }
                if ($row['id'] == 7 &&  $row['stato'] == 0) {
                    $randomNumber = 1;
                    $nome_evento = $row['nome'];
                    //  $dettaglio =  $row['dettaglio'];
                    $id = $row['id'];
                    $update1 = "UPDATE costoFisso SET prezzo = prezzo * 1.15 WHERE nome = 'Luce' AND idUtente = $idUtente";
                    $update2 = "UPDATE costoFisso SET prezzo = prezzo * 1.20 WHERE nome = 'Gas' AND idUtente = $idUtente";
                    $update3 = "UPDATE evento SET stato = 1 WHERE id = $id AND stato = 0";
                    $result1 = $connessione->query($update1);
                    $result2 = $connessione->query($update2);
                    $result3 = $connessione->query($update3);
                }
                if ($row['id'] == 8 && $row['stato'] == 0) {
                    $randomNumber = 1;
                    $nome_evento = $row['nome'];
                    $dettaglio[] =  $row['dettaglio'];
                    $id = $row['id'];
                    $update1 = "UPDATE costoFisso SET prezzo = prezzo * 3 WHERE nome = 'Luce' AND idUtente = $idUtente";
                    $update2 = "UPDATE costoFisso SET prezzo = prezzo * 2.5 WHERE nome = 'Gas' AND idUtente = $idUtente";
                    $update3 = "UPDATE evento SET stato = 1 WHERE id = $id AND stato = 0";
                    $result1 = $connessione->query($update1);
                    $result2 = $connessione->query($update2);
                    $result3 = $connessione->query($update3);
                }
            }
            $result->free(); // Liberare la memoria associata al risultato
        } else {
            $connessione->close();
        }
        if ($randomNumber == 1) {
            $showModal = true;
        }
    }
    ?> <div class="container">
        <div class="row justify-content-end">
            <form id="myForm" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                <div class="col-2">
                    <button type="submit" class="btn btn-primary" name="submit">Avanti</button>
                </div>
            </form>
        </div>
    </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<?php $currentIdx = 0; ?>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        let currentIdx = <?php echo $currentIdx; ?>;
        let nome_evento = <?php echo json_encode($nome_evento); ?>;
        let dettaglio = <?php echo json_encode($dettaglio); ?>;
        let arrayLength = nome_evento.length;
        let modal = document.getElementById('exampleModal1');
        let modalTitle = modal.querySelector('.modal-title');
        let modalBody = modal.querySelector('.modal-body');
        let previousPageBtn = document.getElementById('previousPageBtn');
        let nextPageBtn = document.getElementById('nextPageBtn');

        modal.addEventListener('show.bs.modal', function (event) {
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
</body>

</html>