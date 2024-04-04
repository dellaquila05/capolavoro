<?php
   require_once("../home/connessione.php");
   session_start();

   if (!isset($_SESSION['loggato']) || $_SESSION['loggato'] !== true) {
    header("location: /home/public/login.php");
}

$idUtente = $_SESSION['idUtente'];
$utile = $_SESSION['utile'];

?>
<!DOCTYPE html>
<html lang="en">
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
            height: auto;
        }
    </style>
</head>

<body>
    <nav class="navbar navbar-expand-lg bg-body-tertiary">
        <div class="container-fluid">
        <a class="navbar-brand" href="../home/private/home.php">HomeTech</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarText"
                aria-controls="navbarText" aria-expanded="false" aria-label="Toggle navigation">
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
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Chiudi</button>
                        </div>
                    </div>
                </div>
            </div>
            <div id="settimana"> Numero settimana:
                <?php echo $_SESSION["n_settimana"]; ?></div>
            <div id="capitale"><?php echo $_SESSION['utile']; ?>€</div>
        </div>
    </nav>

    <nav class="navbar navbar-dark bg-dark">
  <a class="navbar-brand mx-auto" href="#">FINANZE</a>
</nav>

    <br><br><br>

    <?php

$query = "SELECT nome, prezzo FROM costoFisso WHERE prezzo > 0 AND idUtente = $idUtente";          
$result = $connessione->query($query);
if ($result) { 
    echo "<div class='container'>";
    echo "<table class='table table-bordered text-center' style='width: 50%; margin: auto;'>";
    echo "<thead class='table-dark'>";
    echo "<tr>";
    echo "<th>Nome spesa</th>";
    echo "<th>Costo spesa mensile</th>";
    echo "</tr>";
    echo "</thead>";
    echo "<tbody>";
    
    while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . $row['nome'] . "</td>";
        echo "<td>" . $row['prezzo'] . "€</td>";
        echo "</tr>";
    }

    $query_totale = "SELECT SUM(prezzo) as Totale_Spese FROM costoFisso WHERE prezzo > 0 AND idUtente = $idUtente";
    $result_totale = $connessione->query($query_totale);
    if ($result_totale) { 
        while ($row = $result_totale->fetch_assoc()) {
            echo "<tr>";
            echo "<td><strong>Totale spesa</strong></td>";
            echo "<td><strong><mark>" . $row['Totale_Spese'] . "€</mark></strong></td>";
            echo "</tr>";
        }
    } else {
        echo "Errore: " . $connessione->error;
    }

    echo "</tbody>";
    echo "</table>";
    echo "</div>";
} else {
    echo "Errore: " . $connessione->error;
}
   
    ?> 


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

</body>
</html>

