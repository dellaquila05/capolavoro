<?php
session_start();
require_once("../home/connessione.php");

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
$idProdotto = [];
$quantitaPr = [];
$interruttore = true;
$sett = $_SESSION["n_settimana"] + 1;
$idUtente = $_SESSION['idUtente'];
?>
<!DOCTYPE html>
<html lang="it">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous" />
    <title>Fornitore</title>
</head>

<body>
    <nav class="navbar navbar-expand-lg bg-body-tertiary">
        <div class="container-fluid">
            <a class="navbar-brand" href="../home/private/home.php">HomeTech</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarText" aria-controls="navbarText" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarText">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link" href="">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-info-circle" viewBox="0 0 16 16">
                                <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14m0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16" />
                                <path d="m8.93 6.588-2.29.287-.082.38.45.083c.294.07.352.176.288.469l-.738 3.468c-.194.897.105 1.319.808 1.319.545 0 1.178-.252 1.465-.598l.088-.416c-.2.176-.492.246-.686.246-.275 0-.375-.193-.304-.533zM9 4.5a1 1 0 1 1-2 0 1 1 0 0 1 2 0" />
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
                    <div id="settimana">
                        Numero settimana:
                        <?php echo $_SESSION["n_settimana"]; ?>
                    </div>
                </span>
                <span class="navbar-text">
                    <div id="utile">
                        Utile:
                        <?php echo $_SESSION["utile"]; ?>
                        €
                    </div>
                </span>
            </div>
        </div>
    </nav>

    <div class="align-items-center">
        <form id="myForm" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <table class="table table-light table-bordered table-hover " id="magazzino">
                <tr>
                    <th>Nome prodotto</th>
                    <th>Prezzo d'acquisto in €</th>
                    <th>Prezzo di vendita in €</th>
                    <th>Quantità prodotto da acquistare</th>
                </tr>
                <?php

                if (isset($_SESSION['loggato']) && $_SESSION['loggato'] == true) {
                    $sql_select = "SELECT nome, costoAcquisto, costoVendita FROM prodotto";
                    $result = $connessione->query($sql_select);
                    $id = 0;
                    if (mysqli_num_rows($result) > 0) {
                        while ($row = $result->fetch_assoc()) {
                            $id++;
                            echo "<tr>";
                            foreach ($row as $b) {
                                echo "<td>" . $b . " </td>";
                            }
                            echo "<td><input name='input_" . $id . "' type='number' min='0' value='0'></td></tr>";
                        }
                        echo "</table>";
                        $result->free(); // Liberare la memoria associata al risultato
                    } else {
                        $connessione->close();
                    }
                }
                ?>
            </table>
            <div class="d-flex flex-column justify-content-center align-items-center">
                <div class="d-flex flex-column justify-content-center align-items-center" id="spazio">
                    Articoli in magazzino: <?php
                                            $disponibilità = 0;
                                            if (isset($_SESSION['idMagazzino'])) {
                                                $somma = $_SESSION['prodottiMaga'];
                                                $dimensione = $_SESSION['dimensioneMaga'];
                                                $disponibilità = $dimensione - $somma;
                                                echo ($somma . "/" . $dimensione);
                                            }
                                            ?>
                </div>
                <div class="col-2">
                    <button type="submit" class="btn btn-primary" name="submit">Acquista</button>
                </div>
            </div>
        </form>
        <?php

        if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit'])) {
            $spesaConclusa = false;
            $showModal = true;
        ?><div class="modal fade" id="exampleModal" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="exampleModalLabel">Carrello acquisti dal Fornitore</h1>
                            <button type="button" id="close" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>

                        </div>
                        <div class="modal-body">
                            <table class='table '>
                                <?php
                                $sql_select = "SELECT id,nome, costoAcquisto, costoVendita FROM prodotto ";
                                $result = $connessione->query($sql_select);
                                $id = 0;
                                $quantita_prodotti = [];
                                $totale_costo = 0;
                                $totale_quantita = 0;
                                $totaleCostoProdotto = 0;

                                foreach ($_POST as $input_id => $value) {
                                    if (strpos($input_id, 'input_') !== false && $value > 0) {
                                        $numero_id = str_replace('input_', '', $input_id);
                                        $quantita_prodotti[$numero_id] = $value; // Associare l'ID del prodotto alla sua quantità selezionata
                                    }
                                }
                                if (mysqli_num_rows($result) > 0) {
                                    if (!empty($quantita_prodotti)) {
                                        echo '<thead>
                                            <tr>
                                                <th>Codice</th>
                                                <th>Nome prodotto</th>
                                                <th>Quantità prodotto</th>
                                                <th>Prezzo singolo prodotto</th>
                                            </tr>
                                        </thead>
                                        <tbody>';
                                        while ($row = $result->fetch_assoc()) {
                                            if (isset($quantita_prodotti[$row['id']])) {
                                                echo "<tr>";
                                                echo "<td>" . $row['id'] . "</td>"; // Codice
                                                echo "<td>" . $row['nome'] . "</td>"; // Nome prodotto
                                                echo "<td>" . $quantita_prodotti[$row['id']] . "</td>"; // Quantità prodotto
                                                echo "<td>" . $row['costoAcquisto'] . "€</td>"; // Prezzo singolo prodotto
                                                echo "</tr>";
                                                $totaleCostoProdotto = $quantita_prodotti[$row['id']] * $row['costoAcquisto'];
                                                $totale_costo += $totaleCostoProdotto;
                                                $totale_quantita += $quantita_prodotti[$row['id']];
                                                if ($quantita_prodotti[$row['id']] > 0) {
                                                    $idProdotto[] = $row['id'];
                                                    $quantitaPr[] = $quantita_prodotti[$row['id']];
                                                }
                                            }
                                        }
                                        $sql_select1 = "SELECT settimana  FROM forniture where idUtente = $idUtente ";
                                        $result = $connessione->query($sql_select1);
                                        while ($row = $result->fetch_assoc()) {
                                            if ($row['settimana'] == $sett) {
                                                $interruttore = false;
                                            }
                                        }

                                ?> <tr>
                                            <?php if ($_SESSION["utile"] < $totale_costo) {
                                                echo '<td colspan="3">Totale Acquisto:</td>';
                                                echo "<td class='table-danger'>$totale_costo €</td>";
                                                $interruttore = false;
                                            } else {
                                                echo '<td colspan="3">Totale Costo:</td>';
                                                echo "<td class='table-success'>$totale_costo €</td>";
                                            } ?>
                                        </tr>
                                        <tr><?php if ($disponibilità < $totale_quantita) {
                                                echo '<td colspan="3">Totale Quantità:</td>';
                                                echo "<td class='table-danger'>$totale_quantita</td>";
                                                $interruttore = false;
                                            } else {
                                                echo '<td colspan="3">Totale Quantità:</td>';
                                                echo "<td class='table-success'>$totale_quantita</td>";
                                            } ?>
                                        </tr>
                                        <tr>
                                            <td colspan="4">N.B. Se l'articolo è rosso la quantità non è disponibile ed è possibile effettuare un solo ordine a settimana.</td>
                                        </tr>


                                        <tr>
                                            <td colspan="4" class="text-center">
                                                <div class="d-flex justify-content-between">
                                                    <?php
                                                    if ($interruttore) {
                                                    ?>
                                                        <button type="button" id="concludiSpesaBtn" class="btn btn-primary mx-5">Concludi spesa</button>
                                                    <?php
                                                    } else {
                                                        echo "<button type=\"submit\" name=\"soddisfa\" class=\"btn btn-primary mx-5\" disabled>Concludi Spesa</button>";
                                                    }
                                                    ?>
                                                </div>
                                            </td>
                                        </tr>
                                <?php
                                    } else {
                                        echo "<tr>";
                                        echo "<td colspan='4'>Nessun prodotto selezionato.</td>";
                                        echo "</tr>";
                                    }
                                }
                                ?>



                                </tbody>
                            </table>
                        </div>

                    </div>
                </div>
            </div>


    </div>


    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <script>
        $(document).ready(function() {

            let showModal = <?php echo $showModal ? 'true' : 'false'; ?>;

            if (showModal) {
                $('#exampleModal').modal('show');
                $(document).ready(function() {
                    $('#concludiSpesaBtn').click(function(e) {
                        e.preventDefault(); // Impedisci il comportamento predefinito del pulsante

                        // Ottieni i dati da inviare
                        let idProdotto = <?php echo json_encode($idProdotto); ?>;
                        let quantitaPr = <?php echo json_encode($quantitaPr); ?>;
                        let sett = <?php echo json_encode($sett); ?>;
                        let settNumero = parseInt(sett);
                        let idUtente = <?php echo json_encode($idUtente); ?>;
                        let tot = <?php echo json_encode($totale_costo); ?>;

                        // Esegui la richiesta AJAX
                        $.ajax({
                            url: 'inserimento.php',
                            method: 'POST',
                            data: {
                                idProdotto: idProdotto,
                                quantitaPr: quantitaPr,
                                sett: settNumero,
                                idUtente: idUtente,
                                totale: tot

                            },
                            success: function(response) {
                                // Gestisci la risposta dal server
                                console.log(response); // Stampa la risposta a console per debug
                            },
                            error: function(xhr, status, error) {
                                // Gestisci gli errori di invio
                                console.error('Errore durante l\'invio dei dati:', error);
                            }
                        });
                    });
                });

            }

            // Aggiungi un gestore per il clic sul pulsante di chiusura del modale
            $('#concludiSpesaBtn').click(function() {
                $('#exampleModal').modal('hide'); // Chiudi il modale
            });
            $('#close').click(function() {
                $('#exampleModal').modal('hide'); // Chiudi il modale
            });
        });
    </script>
<?php


        } ?>

</body>

</html>