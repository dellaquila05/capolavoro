<?php
session_start();
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
            <div id="settimana">N settimana</div>
            <div id="capitale">2000$</div>
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
        $randomNumber = 1;
        require_once("../connessione.php");
        $sql_select = "SELECT dettaglio , nome
                    FROM evento 
                    WHERE id = $id";
        $result = $connessione->query($sql_select);
        if (mysqli_num_rows($result)) {
            while ($row = $result->fetch_assoc()) {
               
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

    <!-- Modal -->
    <div class="modal fade" id="exampleModal1" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel1">Modal Title</h5>
                </div>
                <div class="modal-body">
                    <?php $testo;
                    ?> </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Chiudi</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap Bundle with Popper -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
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