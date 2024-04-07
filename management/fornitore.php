<?php
session_start();
require_once("../home/connessione.php");

$idUtente = $_SESSION['idUtente'];

$queryT = " SELECT utile,n_settimana FROM utente WHERE id = $idUtente ; ";          
$resultT = $connessione->query($queryT);
if($resultT){ 
    while( $row = $resultT->fetch_assoc()){
        $_SESSION['utile']=$row["utile"];
        $_SESSION['n_settimana']=$row["n_settimana"];
}}else {
    echo "Errore: " . $connessione->error;
}

$utile = $_SESSION['utile'];
$Nsettimana= $_SESSION["n_settimana"];
$idProdotto = [];
$quantitaPr = [];

$sett = $_SESSION["n_settimana"];
$idUtente = $_SESSION['idUtente'];
?>
<!DOCTYPE html>
<html lang="it">

<head>
<link rel="stylesheet" href="/home/private/CSS.css">
<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" />
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous" />
    <title>Fornitore</title>
</head>

<body>
<div class="container">
<nav class="navbar navbar-light" style="background-color: #ffefd5;">
            <div class="container-fluid">
                <a  href="/home/private/home.php" class="navbar-brand"><span class="material-symbols-outlined">
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
           <a href="/home/public/login.php"><button type="button" class="btn btn-outline-danger" onclick="<?php $_SESSION['loggato'] == false ?>"><span class="material-symbols-outlined">
logout
</span></button></a>
        </div>
    </nav>
    <nav class="navbar navbar-dark bg-dark">
  <a class="navbar-brand mx-auto" href="#"><strong>FORNITORE</strong> </a>
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
        if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['button'])) {
        
            // Esegui la query per l'inserimento nel database solo se il modulo è stato inviato
            if (!empty($idProdotto) && !empty($quantitaPr)) {
                require_once("../home/connessione.php"); // Assicurati di includere il file di connessione al database qui
        
                for ($i = 0; $i < count($idProdotto); $i++) {
                    $query_insert = "INSERT INTO forniture (idUtente, idProdotto, quantità, settimana) VALUES ('$idUtente', '{$idProdotto[$i]}', '{$quantitaPr[$i]}', '$sett')";
                    $connessione->query($query_insert);
                }
            }
        }
        if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit'])) {
            $showModal = true;
        ?><div class="modal fade" id="exampleModal" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="exampleModalLabel">Carrello acquisti dal Fornitore</h1>
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
                                $interruttore = true;

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
                                            <td colspan="4">N.B. Se l'articolo è rosso la quantità non è disponibile</td>
                                        </tr>


                                        <tr>
                                            <td colspan="4" class="text-center">
                                            <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">

                                                    <div class="d-flex justify-content-between">
                                                        <?php
                                                        if ($interruttore) {
                                                        ?>
                                                            <button type="submit"  name="button" class="btn btn-primary mx-5">Concludi spesa</button>
                                                        <?php
                                                        } else {
                                                            echo "<button type=\"submit\" name=\"soddisfa\" class=\"btn btn-primary mx-5\" disabled>Concludi Spesa</button>";
                                                        }
                                                        ?>
                                                    </div>
                                                    </form>
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
    function concludiSpesa() {
        <?php
        if (!empty($idProdotto) && !empty($quantitaPr)) {
            for ($i = 0; $i < count($idProdotto); $i++) {
                $query_insert = "INSERT INTO forniture (idUtente, idProdotto, quantità, settimana) VALUES ('$idUtente', '{$idProdotto[$i]}', '{$quantitaPr[$i]}', '$sett')";
                $connessione->query($query_insert);
            }
        }
        ?>
    }
</script>
    <script>
    $(document).ready(function() {
    
        let showModal = <?php echo $showModal ? 'true' : 'false'; ?>;

        if (showModal) {
            $('#exampleModal').modal('show');
        }

        // Aggiungi un gestore per il clic sul pulsante di chiusura del modale
        $('#chiusura').click(function() {
            $('#exampleModal').modal('hide'); // Chiudi il modale
        });
    });
</script>
<?php } ?>
</div>
</body>

</html>