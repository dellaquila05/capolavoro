<?php
session_start();
require_once("../home/connessione.php");

if (!isset($_SESSION['loggato']) || $_SESSION['loggato'] !== true) {
    header("location: ../home/public/login.php");
}

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
    <link rel="stylesheet" href="../home/private/CSS.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" />
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    <title>HomeTech - Ordini</title>
</head>

<body>
    <div class="container">
        <?php
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            if (isset($_POST["soddisfa"])) {
                $soddisfa = $_POST["soddisfa"];
                $sqlJoin2 = "SELECT richiede.quantitàPr AS quantità,
            prodotto.id AS id_prodotto,
            prodotto.costoVendita AS prezzo
            FROM richiede
            JOIN prodotto ON richiede.idProdotto = prodotto.id
            WHERE richiede.idOrdine = $soddisfa";
                $result = $connessione->query($sqlJoin2);
                if (mysqli_num_rows($result)) {
                    $idMagazzino = $_SESSION['idMagazzino'];
                    $idUtente = $_SESSION['idUtente'];
                    $prezzoVendita = 0;
                    while ($row = $result->fetch_assoc()) {
                        $idProdotto = $row['id_prodotto'];
                        $prezzo = $row['prezzo'];
                        $quantita = $row['quantità'];
                        $prezzoVendita += $prezzo * $quantita;
                        $sql_update = "UPDATE immagazzina SET quantitàPr = quantitàPr - $quantita WHERE idMagazzino = $idMagazzino AND idProdotto = $idProdotto";
                        $result_update = $connessione->query($sql_update);
                    }
                    $_SESSION['utile'] += $prezzoVendita;
                    $sql_update2 = "UPDATE utente SET utile = utile + $prezzoVendita WHERE id = $idUtente";
                    $connessione->query($sql_update2);
                    $sql_delete = "DELETE FROM ordine WHERE id = $soddisfa";
                    $connessione->query($sql_delete);
                }
            } else if (isset($_POST["rifiuta"])) {
                $rifiuta = $_POST["rifiuta"];
                $sql_delete = "DELETE FROM ordine WHERE id = $rifiuta";
                $resultDelete = $connessione->query($sql_delete);
            }
        }
        ?>
        <nav class="navbar navbar-light" style="background-color: #ffefd5;">
            <div class="container-fluid">
                <a href="../home/private/home.php" class="navbar-brand"><span class="material-symbols-outlined">
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
                <a href="../home/public/login.php"><button type="button" class="btn btn-outline-danger" onclick="<?php $_SESSION['loggato'] == false ?>"><span class="material-symbols-outlined">
                            logout
                        </span></button></a>
            </div>
        </nav>
        <nav class="navbar navbar-dark bg-dark">
            <a class="navbar-brand mx-auto" href="#"><strong>ORDINI</strong> </a>
        </nav>
        <div class="">
            <?php
            if (isset($_SESSION['idUtente'])) {
                $idUtente = $_SESSION['idUtente'];
            } else {
                //id utente non salvato in sessione
            }
            $sqlJoin1 = "SELECT ordine.id, 
        SUM(richiede.quantitàPr) AS somma_quantità, 
        SUM(richiede.quantitàPr * prodotto.costoVendita) AS totale_costo
        FROM ordine 
        JOIN richiede ON ordine.id = richiede.idOrdine
        JOIN prodotto ON richiede.idProdotto = prodotto.id
        WHERE ordine.idUtente = $idUtente
        GROUP BY ordine.id";
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
                    $arrayOrdini = [];
                    $contatore = 0;
                    while ($row = $result->fetch_assoc()) {
                        $contatore++;
                        $idOrdine = $row['id'];
                        array_push($arrayOrdini, $idOrdine);
                        $somma_quantita = $row['somma_quantità'];
                        $totale_costo = $row['totale_costo'];
                        echo "<tr>";
                        echo "<td>$idOrdine</td>";
                        echo "<td>$somma_quantita</td>";
                        echo "<td>$totale_costo €</td>";
                        //Button trigger modal
                        echo "<td><button type='button' class='btn btn-primary rounded-pill p-1 m-1' data-bs-toggle='modal' data-bs-target='#modal$contatore'>Visualizza</button></td>";
                        echo "</tr>";
                    }
                    ?>
                </table>
                <?php
                for ($i = 1; $i <= $contatore; $i++) {
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
                                            $idCorrente = $arrayOrdini[$i - 1];
                                            $sqlJoin2 = "SELECT richiede.quantitàPr AS quantità,
                                            prodotto.id AS id_prodotto,
                                            prodotto.costoVendita AS prezzo,
                                            prodotto.nome AS nome,
                                            SUM(richiede.quantitàPr * prodotto.costoVendita) AS totale_costo
                                            FROM richiede
                                            JOIN prodotto ON richiede.idProdotto = prodotto.id
                                            WHERE richiede.idOrdine = $idCorrente
                                            GROUP BY richiede.quantitàPr, prodotto.id, prodotto.costoVendita, prodotto.nome;";
                                            $result = $connessione->query($sqlJoin2);
                                            if (mysqli_num_rows($result)) {
                                                $idMagazzino = $_SESSION['idMagazzino'];
                                                $interruttore = true;
                                                $totale_costo = 0;
                                                while ($row = $result->fetch_assoc()) {
                                                    $idProdotto = $row['id_prodotto'];
                                                    $nome = $row['nome'];
                                                    $prezzo = $row['prezzo'];
                                                    $quantita = $row['quantità'];
                                                    $totale_costo += $row['totale_costo'];
                                                    echo "<tr>";
                                                    echo "<td>$idProdotto</td>";
                                                    $sql_select = "SELECT quantitàPr FROM immagazzina WHERE idMagazzino = $idMagazzino AND idProdotto = $idProdotto";
                                                    $result2 = $connessione->query($sql_select);
                                                    if (mysqli_num_rows($result2)) {
                                                        $quantitaMagazzino = $result2->fetch_array()["quantitàPr"];
                                                        if ($quantita > $quantitaMagazzino) {
                                                            echo "<td class='table-danger'>$nome</td>";
                                                            $interruttore = false;
                                                        } else {
                                                            echo "<td class='table-success'>$nome</td>";
                                                        }
                                                    }
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
                                                                <button type="submit" name="rifiuta" value="<?php echo $idCorrente ?>" class="btn btn-danger mx-5">Rifiuta</button>
                                                                <?php
                                                                if ($interruttore) {
                                                                ?>
                                                                    <button type="submit" name="soddisfa" value="<?php echo $idCorrente ?>" class="btn btn-primary mx-5">Soddisfa</button>
                                                                <?php
                                                                } else {
                                                                    echo "<button type=\"submit\" name=\"soddisfa\" value=" . $idCorrente . " class=\"btn btn-primary mx-5\" disabled>Soddisfa</button>";
                                                                }
                                                                ?>
                                                            </div>
                                                        </form>
                                                    </td>
                                                </tr>
                                            <?php
                                            } else {
                                                echo "errore nella join";
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
            } else {
                ?>
                <svg xmlns="http://www.w3.org/2000/svg" class="d-none">
                    <symbol id="exclamation-triangle-fill" viewBox="0 0 16 16">
                        <path d="M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767L8.982 1.566zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5zm.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2z" />
                    </symbol>
                </svg>

                <div class="alert alert-warning m-5" role="alert">
                    <h4 class="alert-heading text-center">Attenzione!</h4>
                    <div class="d-flex justify-content-center align-items-center mx-auto">
                        <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Warning:">
                            <use xlink:href="#exclamation-triangle-fill" />
                        </svg>
                        <div class="text-center">
                            Non ci sono ordini disponibili, avanzare di una settimana per ottenerne di nuovi
                        </div>
                        <svg class="bi flex-shrink-0 me-2 ms-1" width="24" height="24" role="img" aria-label="Warning:">
                            <use xlink:href="#exclamation-triangle-fill" />
                        </svg>
                    </div>
                </div>
        </div>

    <?php
            }

    ?>
    </div>
</body>

</html>