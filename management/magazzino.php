<?php
session_start();
require_once("../home/connessione.php");

$idMagazzino = $_SESSION['idMagazzino'];
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

$sql_select2 = "SELECT m.dimensione
FROM magazzino m 
JOIN utente u ON u.idMagazzino = m.id
WHERE u.id = $idUtente
";
$sql_select4 = "SELECT quantitàPr FROM immagazzina WHERE idMagazzino = $idMagazzino";

$result2 = $connessione->query($sql_select2);
 $result4 = $connessione->query($sql_select4);
$somma=0;
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





?>
<!DOCTYPE html>
<html lang="it">

<head>
<link rel="stylesheet" href="../home/private/CSS.css">
<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" />
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous" />
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js" integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+" crossorigin="anonymous">
    </script>
    <title>HomeTech - Magazzino</title>
</head>

<body>
<div class="container">
<nav class="navbar navbar-light" style="background-color: #ffefd5;">
            <div class="container-fluid">
                <a  href="../home/private/home.php" class="navbar-brand"><span class="material-symbols-outlined">
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
  <a class="navbar-brand mx-auto" href="#"><strong>MAGAZZINO</strong> </a>
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
                    Quantità prodotto
                </th>
            </tr>
            <?php
            $somma=0;

            if (!isset($_SESSION['loggato']) || $_SESSION['loggato'] = true) {
                if (isset($_SESSION['idMagazzino']) && isset($_SESSION['idUtente'])) {
                    $idMagazzino = $_SESSION['idMagazzino'];
                    $sql_select = "SELECT p.nome, p.costoAcquisto, p.costoVendita, i.quantitàPr
                    FROM prodotto p 
                    JOIN immagazzina i ON p.id = i.idProdotto
                    WHERE i.idMagazzino = $idMagazzino";
                    $result = $connessione->query($sql_select);
                    if (mysqli_num_rows($result)) {
                        while ($row = $result->fetch_assoc()) {
                            echo "<tr>";
                            echo "
                <td>" . $row['nome'] . " </td>
                <td>" . $row['costoAcquisto'] . " </td>
                <td>" . $row['costoVendita'] . " </td>                
                 <td>" . $row['quantitàPr'] . " </td>";
                            echo "</tr>";
                        }
                        $result->free(); // Liberare la memoria associata al risultato
                    } else {
                        $connessione->close();
                    }
                }
            }
            ?>
        </table>
        <div class="d-flex flex-column justify-content-center align-items-center" id="spazio">
            Articoli in magazzino: <?php 
             $somma = $_SESSION['prodottiMaga'];
             $dimensione = $_SESSION['dimensioneMaga'];
 echo ($somma."/".$dimensione);
              
             ?></div>

    </div>
</div>
</body>

</html>