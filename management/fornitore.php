<?php 
session_start();
?>
<!DOCTYPE html>
<html lang="it">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous" />
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js"
        integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+" crossorigin="anonymous">
        </script>
    <title>Magazzino</title>
</head>

<body>
    <nav class="navbar navbar-expand-lg bg-body-tertiary">
        <div class="container-fluid">
            <a class="navbar-brand" href="./management.html">HomeTech</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarText"
                aria-controls="navbarText" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarText">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link" href="">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                class="bi bi-info-circle" viewBox="0 0 16 16">
                                <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14m0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16" />
                                <path
                                    d="m8.93 6.588-2.29.287-.082.38.45.083c.294.07.352.176.288.469l-.738 3.468c-.194.897.105 1.319.808 1.319.545 0 1.178-.252 1.465-.598l.088-.416c-.2.176-.492.246-.686.246-.275 0-.375-.193-.304-.533zM9 4.5a1 1 0 1 1-2 0 1 1 0 0 1 2 0" />
                            </svg>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Features</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Pricing</a>
                    </li>
                </ul>
                <span class="navbar-text">
                    Numero settimana:
                    <div id="nsett">
                    </div>
                </span>
            </div>
        </div>
    </nav>

    <div class="align-items-center">
        <table class="table table-light table-bordered table-hover " id="magazzino">
            <tr>
                <th>
                    Nome prodotto
                </th>
                <th>
                    Prezzo d'acquisto in €
                </th>
                <th>
                    Prezzo di vendita in € 
                </th>
                <th>
                    Quantità prodotto da acquistare
                </th>
            </tr>
            <?php
require_once("../home/connessione.php");

if(!isset($_SESSION['loggato']) || $_SESSION['loggato'] = true){
    $sql_select = "SELECT nome , costoAcquisto , costoVendita FROM prodotto ";
    $result = $connessione->query($sql_select);
    $id = 0 ; 
    if (mysqli_num_rows($result)) {
        while ($row = $result->fetch_assoc()) {
            $id++;
            echo "<tr>";
            foreach ($row as $b) {
                echo "
                <td>".$b." </td>";
            }
            echo "<td></tr>";
        }
        $result->free(); // Liberare la memoria associata al risultato

    } else {
        $connessione->close();
    }
}
?>
        </table>
        <div class="d-flex flex-column justify-content-center align-items-center">
        <div  id="spazio">Spazio dispondibile in magazzino:</div>
        <button id="acquista" type="button" class="btn btn-primary">Acquista</button>
    </div>
    </div>
    
    
    
</body>

</html>


