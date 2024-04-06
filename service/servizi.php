<?php
   require_once("../home/connessione.php");
   session_start();

   if (!isset($_SESSION['loggato']) || $_SESSION['loggato'] !== true) {
    header("location: /home/public/login.php");
}

$idUtente = $_SESSION['idUtente'];

$queryG = " SELECT utile,n_settimana FROM utente WHERE id = $idUtente ; ";          
$resultG = $connessione->query($queryG);
if($resultG){ 
    while( $row = $resultG->fetch_assoc()){
        $_SESSION['utile']=$row["utile"];
        $_SESSION['n_settimana']=$row["n_settimana"];
}}else {
    echo "Errore: " . $connessione->error;
}




$utile = $_SESSION['utile'];
$Nsettimana= $_SESSION["n_settimana"];


$queryT = " SELECT costoFisso.prezzo as telecamere FROM costoFisso WHERE nome = 'Telecamere' AND idUtente = $idUtente ; ";          
$resultT = $connessione->query($queryT);
if($resultT){ 
    while( $row = $resultT->fetch_assoc()){
   $costoTelecamere=$row["telecamere"];
}}else {
    echo "Errore: " . $connessione->error;
}

$queryG = " SELECT costoFisso.prezzo as guardia FROM costoFisso WHERE nome = 'Guardia' AND idUtente = $idUtente ; ";          
$resultG = $connessione->query($queryG);
if($resultG){ 
    while( $row = $resultG->fetch_assoc()){
   $costoGuardia=$row["guardia"];
}}else {
    echo "Errore: " . $connessione->error;
}


$queryA = " SELECT costoFisso.prezzo as allarme FROM costoFisso WHERE nome = 'Allarme' AND idUtente = $idUtente ; ";          
$resultA = $connessione->query($queryA);
if($resultA){ 
    while( $row = $resultA->fetch_assoc()){
   $costoAllarme=$row["allarme"];
}}else {
    echo "Errore: " . $connessione->error;
}


$queryM = " SELECT dimensione FROM magazzino WHERE id=$idUtente ; ";          
$resultM = $connessione->query($queryM);
if($resultM){ 
    while( $row = $resultM->fetch_assoc()){
   $dimensioneMagazzino=$row["dimensione"];
}}else {
    echo "Errore: " . $connessione->error;
}


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
            <div id="utile">Utile: <?php echo $_SESSION['utile']; ?>€</div>
        </div>
    </nav>

    <nav class="navbar navbar-dark bg-dark">
  <a class="navbar-brand mx-auto" href="#">SERVIZI</a>
</nav>

    <br><br><br>

    <div class="container mt-4">
        <table class="table">
            <tbody>
                <tr>
                    <td>
                        <button type="button" class="btn btn-secondary" data-bs-toggle="modal" data-bs-target="#exampleModa2">Aggiungi telecamera</button>

                        <div class="modal fade" id="exampleModa2" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h1 class="modal-title fs-5" id="exampleModalLabel">Aggiungi telecamera</h1>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        Aggiungi Telecamere al tuo spazio per soli €300 di installazione e €20,00 al mese. Riduci il rischio di furto del 14%. Sicurezza accessibile, tranquillità garantita.
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annulla</button>
                                        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
    <button type="submit" name="submitTelecamera" data-bs-dismiss="modal" class="btn btn-primary">Aggiungi telecamera</button>
</form>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </td>

                    <td>
                        <button type="button" class="btn btn-secondary" data-bs-toggle="modal" data-bs-target="#exampleModa3">Aumenta magazzino</button>

                        <div class="modal fade" id="exampleModa3" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h1 class="modal-title fs-5" id="exampleModalLabel">Aumenta magazzino</h1>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        Aumenta la capacità del tuo magazzino del 100% con il nostro servizio dedicato. Ottimizza lo spazio e migliora l'efficienza operativa. Possiede un costo di 1000€ per migliorarlo e aumenta di 200€ l’affitto, oltre a ciò assumi un dipendente che ti costa 1700€ al mese
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annulla</button>
                                        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                                        <button type="submit" name="submitMagazzino" class="btn btn-primary">Aggiungi</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td>
                        <button type="button" class="btn btn-secondary" data-bs-toggle="modal" data-bs-target="#exampleModa4">Aggiungi allarme</button>

                        <div class="modal fade" id="exampleModa4" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h1 class="modal-title fs-5" id="exampleModalLabel">Aggiungi allarme</h1>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        Aggiungi un Allarme al tuo ambiente con un'installazione di soli €199 e una fee mensile fissa di €14,99. Riduci il rischio di intrusioni del 29%. Sicurezza senza compromessi, per una tranquillità completa.
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annulla</button>
                                        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                                        <button type="submit" name="submitAllarme" class="btn btn-primary">Aggiungi</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </td>

                    <td>
                        <button type="button" class="btn btn-secondary" data-bs-toggle="modal" data-bs-target="#exampleModa5">Aggiungi guardia</button>

                        <div class="modal fade" id="exampleModa5" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h1 class="modal-title fs-5" id="exampleModalLabel">Aggiungi guardia</h1>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        Assicura la sicurezza del tuo magazzino con una guardia reale. Il costo mensile, che include stipendio e mantenimento, è solo €1.500. Riduci il rischio del 43%. Sicurezza garantita.
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annulla</button>
                                        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                                        <button type="submit" name="submitGuardia" class="btn btn-primary">Aggiungi</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>


    <?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if(isset($_SESSION['idUtente']) && isset($_SESSION['utile'])) {
    
    if (isset($_POST['submitTelecamera'])) {
        if($costoTelecamere==0){ 
            $utile=$utile-300;
            $_SESSION['utile'] = $utile;

            $query=" UPDATE utente SET utile=$utile WHERE  id = $idUtente ; ";
            $result = $connessione->query($query);
            if($result){ 
                $query1=" UPDATE costoFisso SET prezzo = 20 WHERE nome = 'Telecamere' AND idUtente = $idUtente ; ";
                $result1 = $connessione->query($query1);
                if($result1){ 
              echo "telecamera aggiunta";
                }else {
                    echo "Errore: " . $connessione->error;
                }
            }else {
                echo "Errore: " . $connessione->error;
            }

        }else{
            echo "telecamera Già presente"; 
        }
        }   
    

     elseif (isset($_POST['submitGuardia'])) {

        if($costoGuardia==0){ 
                $query1=" UPDATE costoFisso SET prezzo = 1500 WHERE nome = 'Guardia' AND idUtente = $idUtente ; ";
                $result1 = $connessione->query($query1);
                if($result1){ 
              echo "Guardia Assunta";
                }else {
                    echo "Errore: " . $connessione->error;
                }
        }else{
            echo "Guardia Già presente"; 
        }

        
    }

    elseif (isset($_POST['submitAllarme'])) {

        if($costoAllarme==0){ 
            $utile=$utile-199;
            $_SESSION['utile'] = $utile;

            $query=" UPDATE utente SET utile=$utile WHERE  id = $idUtente ; ";
            $result = $connessione->query($query);
            if($result){ 
                $query1=" UPDATE costoFisso SET prezzo = 14.99 WHERE nome = 'Allarme' AND idUtente = $idUtente ; ";
                $result1 = $connessione->query($query1);
                if($result1){ 
              echo "allarme installato";
                }else {
                    echo "Errore: " . $connessione->error;
                }
            }else {
                echo "Errore: " . $connessione->error;
            }

        }else{
            echo "allarme Già presente"; 
        }
        
    }

    elseif (isset($_POST['submitMagazzino'])) {

        if($dimensioneMagazzino<60){ 
            $utile=$utile-1000;
            $_SESSION['utile'] = $utile;

            $query=" UPDATE utente SET utile=$utile WHERE  id = $idUtente ; ";
            $result = $connessione->query($query);
            if($result){ 
                $query1=" UPDATE costoFisso SET prezzo = prezzo+200 WHERE nome = 'Affitto' AND idUtente = $idUtente ; ";
                $result1 = $connessione->query($query1);
                if($result1){ 
                    $query2=" INSERT INTO `costoFisso`(`nome`, `prezzo`, `idUtente`) VALUES ('StipendioDip',1700,$idUtente) ; ";
                    $result2 = $connessione->query($query2);
                    if($result2){ 
                        $query3=" UPDATE magazzino SET dimensione=dimensione+20 WHERE id= $idUtente ; ";
                        $result3 = $connessione->query($query3);
                        if($result3){ 
                      echo "Magazzino Aumentato";
                        }else {
                            echo "Errore: " . $connessione->error;
                        }
                    }else {
                        echo "Errore: " . $connessione->error;
                    }
                }else {
                    echo "Errore: " . $connessione->error;
                }
            }else {
                echo "Errore: " . $connessione->error;
            }

        }else{
            echo "limite raggiunto"; 
        }
        
    }
}else{
    header("location: /home/public/login.php");
}
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

