<?php
session_start();
if (!isset($_SESSION['loggato']) || $_SESSION['loggato'] !== true) {
    header("location: ../home/public/login.php");
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
    <title>Ordini</title>
</head>

<body>
    <nav class="navbar navbar-expand-lg bg-body-tertiary">
        <div class="container-fluid">
            <a class="navbar-brand" href="./home.html">HomeTech</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarText" aria-controls="navbarText" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <button type="button" class="btn" data-bs-toggle="modal" data-bs-target="#info">
                <span class="material-symbols-outlined">
                    info
                </span>
            </button>

            <div class="modal fade" id="info" tabindex="-1" aria-labelledby="infoLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="infoLabel">HomeTech</h1>
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
    <div class="">
        <?php
        if (isset($_SESSION['idUtente'])) {
            require_once("../home/connessione.php");
            $idUtente = $_SESSION['idUtente'];
            $sqlJoin1 = "SELECT ordine.id, 
            SUM(richiede.quantitàPr) AS somma_quantità, 
            SUM(richiede.quantitàPr * prodotto.costoVendita) AS totale_costo
            FROM ordine 
            JOIN richiede ON ordine.id = richiede.idOrdine
            JOIN prodotto ON richiede.idProdotto = prodotto.id
            WHERE ordine.idUtente = $idUtente
            GROUP BY ordine.id;";
            $result = $connessione->query($sqlJoin1);
            if (mysqli_num_rows($result)) {
        ?>
                <table class="table table-light table-bordered table-hover text-center">
                    <tr>
                        <th>Codice ordine</th>
                        <th>N° prodotti</th>
                        <th>Totale</th>
                        <th></th>
                    </tr>
                    <?php
                    $contatore = 0;
                    while ($row = $result->fetch_assoc()) {
                        $contatore++;
                        $idOrdine = $row['id'];
                        $somma_quantita = $row['somma_quantità'];
                        $totale_costo = $row['totale_costo'];
                        echo "<tr>";
                        echo "<td>$idOrdine</td>";
                        echo "<td>$somma_quantita</td>";
                        echo "<td>$totale_costo €</td>";
                        //Button trigger modal
                        echo "<td><button type='button' class='btn btn-primary rounded-pill p-1 m-1' data-bs-toggle='modal' data-bs-target='#modal$idOrdine'>Visualizza</button></td>";
                        echo "</tr>";
                    }
                    ?>
                </table>
                <?php
                for ($i = 0; $i <= $contatore; $i++) {
                ?>
                    <!-- Modal -->
                    <div class="modal fade" id="modal<?php echo $i ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h1 class="modal-title fs-5" id="exampleModalLabel">Ordine <?php echo $i ?></h1>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <style>
                                        .custom-border {
                                            border: 1px solid black;
                                        }
                                    </style>
                                    <table class="table table-bordered custom-border text-center">
                                        <thead>
                                            <tr>
                                                <th>Codice prodotto</th>
                                                <th>Nome prodotto</th>
                                                <th>Quantità</th>
                                                <th>Prezzo unità</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $sqlJoin2 = "SELECT richiede.quantitàPr AS quantità,
                                            prodotto.id AS id_prodotto,
                                            prodotto.costoVendita AS prezzo,
                                            prodotto.nome AS nome
                                            FROM richiede
                                            JOIN prodotto ON richiede.idProdotto = prodotto.id
                                            WHERE richiede.idOrdine = $i";
                                            $result = $connessione->query($sqlJoin2);
                                            if (mysqli_num_rows($result)) {
                                                while ($row = $result->fetch_assoc()) {
                                                    $idProdotto = $row['id_prodotto'];
                                                    $nome = $row['nome'];
                                                    $prezzo = $row['prezzo'];
                                                    $quantita = $row['quantità'];
                                                    echo "<tr>";
                                                    echo "<td>$idProdotto</td>";
                                                    echo "<td class='table-success'>$nome</td>";
                                                    echo "<td>$quantita</td>";
                                                    echo "<td>$prezzo €</td>";
                                                    echo "</tr>";
                                                }
                                            ?>
                                                <tr>
                                                    <td colspan="3">Totale:</td>
                                                    <td><?php echo "$totale_costo €" ?></td>
                                                </tr>
                                                <tr>
                                                    <td colspan="4">N.B. Se l'articolo è rosso la quantità non è disponibile</td>
                                                </tr>
                                                <tr>
                                                    <td colspan="4" class="text-center">
                                                        <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
                                                            <div class="d-flex justify-content-between">
                                                                <button type="submit" name="rifiuta" class="btn btn-danger mx-5">Rifiuta</button>
                                                                <button type="submit" name="soddisfa" class="btn btn-primary mx-5">Soddisfa</button>
                                                            </div>
                                                        </form>
                                                    </td>
                                                </tr>
                                            <?php
                                            }
                                            ?>
                                        </tbody>
                                    </table>
                                </div>






                            </div>
                        </div>
                    </div>
        <?php
                }
            }
        }
        ?>
    </div>
</body>

</html>

<!-- 
    1 - generare randomicamente il numero dei prodotti di cui sarà composto l'ordine (min = 0, max = numero settimana x 2)
    2 - select di tutti i prodotti
    3 - con un ciclo che andrà da 0 a il numero random generato prima seleziono i prodotti dall'array
    4 - calcolo il totale dell'ordine
    5 - salvo nel db l'ordine
-->