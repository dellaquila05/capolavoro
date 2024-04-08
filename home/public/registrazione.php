<?php
session_start();
require_once('../connessione.php');
$connessione->begin_transaction();

if ($_SERVER["REQUEST_METHOD"] === "POST") {
?>
    <script>
        //script per gestire la visualizzazione del pulsante signUp.
        const buttonSignUp = document.getElementById('buttonSignUp');
        const signUp = document.getElementById('signUp');
        const loading = document.getElementById('loading');
        signUp.classList.remove('d-none'); //faccio apparire il pulsante sign up
        loading.classList.add('d-none'); //faccio scomparire il pulsante loading
    </script>
<?php
    $nome = $connessione->real_escape_string($_POST['nomeUtente']); //recupero il nome con cui si vuole effettuare la registrazione
    $password = $connessione->real_escape_string($_POST['password']); //recupero la password con cui si vuole effettuare la registrazione

    try {
        //verifico che il nome utente abbia più di 4 caratteri
        if (strlen($nome) < 5) {
            throw new Exception("Il nome utente ha meno di 5 caratteri", 1);
        } else {
            //verifico che il nome utente non sia già presente nel database
            $sql = "SELECT username FROM utente WHERE username = '$nome'";
            $result = $connessione->query($sql);
            if (mysqli_num_rows($result)) {
                throw new Exception("Il nome utente è già presente nel database", 1);
            } else {
                //verifico che la password abbia più di 5 caratteri
                if (strlen($password) < 6) {
                    throw new Exception("La password ha meno di 6 caratteri", 2);
                } else {
                    $hashed_password = password_hash($password, PASSWORD_DEFAULT); //eseguo una funzione di hashing sulla password
                    //creo il magazzino del nuovo utente
                    $sql1 = "INSERT INTO magazzino(dimensione)VALUES(20)";
                    if ($connessione->query($sql1)) { //se non ci sono errori
                        //recupero l'id del magazzino appena creato
                        $sql2 = "SELECT id FROM magazzino ORDER BY id DESC LIMIT 1";
                        $result = $connessione->query($sql2);
                        if (mysqli_num_rows($result)) { //se non ci sono errori
                            $idMagazzino = $result->fetch_array()['id'];
                            //creo il nuovo utente
                            $sql3 = "INSERT INTO utente(username, password, n_settimana, idMagazzino, utile) VALUES ('$nome','$hashed_password','1','$idMagazzino','5000')";
                            if ($connessione->query($sql3)) { //se non ci sono errori
                                //recupero l'id dell'utente appena creato
                                $sql4 = "SELECT id FROM utente ORDER BY id DESC LIMIT 1";
                                $result = $connessione->query($sql4);
                                if (mysqli_num_rows($result)) { //se non ci sono errori
                                    $idUtente = $result->fetch_array()['id'];
                                    //creo i costi fissi che dovrà pagare l'utente appena creato 
                                    $sql5 = "INSERT INTO costoFisso(nome,prezzo,idUtente)VALUES('Gas', 50, '$idUtente'),('Luce', 450, '$idUtente'),('Affitto', 1700, '$idUtente'),('Telecamere', 0, '$idUtente'),('Allarme', 0, '$idUtente'),('Guardie', 0, '$idUtente');";
                                    if ($connessione->query($sql5)) { //se non ci sono errori
                                        //recupero gli id di ogni prodotto del gioco 
                                        $sql6 = "SELECT id FROM prodotto ORDER BY id";
                                        $result = $connessione->query($sql6);
                                        if (mysqli_num_rows($result)) { //se non ci sono errori
                                            while ($idProdotto = $result->fetch_array()) {
                                                //inserisco i prodotti nel magazzino dell'utente con quantità = 0
                                                $sql7 = "INSERT INTO immagazzina(idMagazzino,idProdotto,quantitàPr) VALUES ('$idMagazzino', '$idProdotto[id]', 0)";
                                                if ($connessione->query($sql7)) {
                                                    $connessione->commit(); //effettuo la commit delle modifiche al database
                                                    $_SESSION['loggato'] = true; //registrazione effettuata con successo
                                                    $_SESSION['idUtente'] = $idUtente;
                                                    $_SESSION['idMagazzino'] = $idMagazzino;
                                                    $_SESSION['n_settimana'] = 1;
                                                    $_SESSION['utile'] = 2000;
                                                    $somma = 0;
                                                    $sql_select5 = "SELECT quantitàPr FROM immagazzina WHERE idMagazzino = $idMagazzino";
                                                    $sql_select6 = "SELECT m.dimensione
                                                    FROM magazzino m 
                                                    JOIN utente u ON u.idMagazzino = m.id
                                                    WHERE u.id = $idUtente
                                                   ";
                                                    $result5 = $connessione->query($sql_select5);
                                                    if (mysqli_num_rows($result5)) {
                                                        while ($row = $result5->fetch_assoc()) {
                                                            $somma += $row['quantitàPr'];
                                                        }
                                                        $_SESSION['prodottiMaga'] = $somma;
                                                    }
                                                    $result6 = $connessione->query($sql_select6);
                                                    if (mysqli_num_rows($result6)) {
                                                        while ($row = $result6->fetch_assoc()) {
                                                            $dimensione = $row['dimensione'];
                                                        }
                                                        $_SESSION['dimensioneMaga'] = $dimensione;
                                                    }
                                                } else {
                                                    throw new Exception("Errore durante la insert nella tabella immagazzina per inserire i prodotti nel magazzino", 3);
                                                }
                                            }
                                        } else {
                                            throw new Exception("Errore nella select dalla tabella prodotto per recuperare gli id", 3);
                                        }
                                    } else {
                                        throw new Exception("Errore durante la insert nella tabella costoFisso", 3);
                                    }
                                } else {
                                    throw new Exception("Errore nella select dalla tabella utente per recuperare l'ultimo id", 3);
                                }
                            } else {
                                throw new Exception("Errore durante la insert nella tabella utente per creare un nuovo utente", 3);
                            }
                        } else {
                            throw new Exception("Errore nella select dalla tabella magazzino per recuperare l'ultimo id", 3);
                        }
                    } else {
                        throw new Exception("Errore durante la insert nella tabella magazzino per creare un nuovo magazzino", 3);
                    }
                }
            }
        }
    } catch (Exception $e) {
        $connessione->rollback(); //eseguo la rollback delle modifiche al database
        $_SESSION['error'] = $e->getCode(); //recupero il codice di errore
        $_SESSION['loggato'] = false; //blocco la registrazione
        $connessione->close(); //chiudo la connessione
    }

    if ($_SESSION['loggato'] === true) {
        //registrazione avvenuta con successo
        $connessione->close(); //chiudo la connessione
        header("location: ../private/home.php");
    }
}
?>

<!DOCTYPE html>
<html lang="it">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous" />
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js" integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+" crossorigin="anonymous">
    </script>
    <link rel="stylesheet" href="style.css">
    <title>HomeTech - Sign up</title>

</head>

<body>
    <div id="public" class="d-flex flex-column min-vh-100 justify-content-center align-items-center">
        <div class="card" style="width: 20rem">
            <div class="text-center mb-3">
                <svg xmlns="http://www.w3.org/2000/svg" width="100" height="100" fill="currentColor" class="bi bi-person" viewBox="0 0 16 16">
                    <path d="M8 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6Zm2-3a2 2 0 1 1-4 0 2 2 0 0 1 4 0Zm4 8c0 1-1 1-1 1H3s-1 0-1-1 1-4 6-4 6 3 6 4Zm-1-.004c-.001-.246-.154-.986-.832-1.664C11.516 10.68 10.289 10 8 10c-2.29 0-3.516.68-4.168 1.332-.678.678-.83 1.418-.832 1.664h10Z" />
                </svg>
            </div>
            <form action="<?php echo $_SERVER["PHP_SELF"]; ?>" method="post">
                <div class="card-body">
                    <div class="mb-3">
                        <?php
                        //codice per gestire la visualizzazione dell'alert
                        if (isset($_SESSION['error'])) { //se c'è un errore
                            $error = $_SESSION['error']; //lo recupero
                            unset($_SESSION['error']); //pulisco la sessione
                            echo "<div id='alert'>";
                        } else {
                            echo "<div id='alert' class='d-none'>";
                        }
                        ?>
                        <!-- alert per visualizzare i messaggi di errore -->
                        <svg xmlns="http://www.w3.org/2000/svg" class="d-none">
                            <symbol id="exclamation-triangle-fill" fill="currentColor" viewBox="0 0 16 16">
                                <!-- simbolo del triangolo col ! in mezzo -->
                                <path d="M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767L8.982 1.566zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5zm.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2z">
                                </path>
                            </symbol>
                        </svg>
                        <div class="alert alert-danger d-flex align-items-center alert-dismissible fade show" role="alert">
                            <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Danger:">
                                <use xlink:href="#exclamation-triangle-fill"></use>
                            </svg>
                            <strong id="testoAlert">
                                <?php
                                //stampo il testo dell'errore dentro l'alert
                                switch ($error) {
                                    case 1:
                                        echo "Nome utente non valido";
                                        break;
                                    case 2:
                                        echo "La password deve essere di almeno sei caratteri";
                                        break;
                                    case 3:
                                        echo "Errore nella registrazione";
                                        break;
                                    default:
                                        break;
                                }
                                ?>
                            </strong>
                            <button type="sumbit" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            <!-- bottone per chiudere l'alert -->
                        </div>
                    </div>

                    <div class="mb-3">
                        <!-- form di inserimento -->
                        <label for="nomeUtente" class="form-label">Nome utente</label>
                        <input type="text" class="form-control" id="nomeUtente" name="nomeUtente" aria-describedby="nomeHelp" />
                        <div id="nomeHelp" class="form-text text-body-tertiary">Il nome deve essere di almeno 5 caratteri.</div>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" class="form-control" id="password" name="password" aria-describedby="passwordHelp" />
                        <div id="passwordHelp" class="form-text text-body-tertiary">La password deve essere di almeno 6 caratteri.</div>
                    </div>
                </div>
                <div id="signUp" class="text-center">
                    <!-- pulsante sign up -->
                    <button type="submit" id="buttonSignUp" class="btn btn-primary">
                        Sign up
                    </button>
                    <div class="form-text mt-2">
                        Sei già registrato?
                        <a href="./login.php">Log in</a>
                    </div>
                </div>
                <div id="loading" class="text-center d-none">
                    <!-- pulsante disabilitato che serve a dare l'idea del caricamento, appare alla pressione del pulsante sign up -->
                    <button class="btn btn-primary" type="button" disabled>
                        <span class="spinner-border spinner-border-sm" aria-hidden="true"></span>
                        <span role="status">Loading...</span>
                    </button>
                </div>
                <script>
                    /*
                    script per gestire la visualizzazione del pulsante signUp.
                    siccome tutte le query possono richiedere del tempo ad eseguirsi
                    */
                    signUp.onclick = () => { //alla pressione del pulsante sign up
                        signUp.classList.add('d-none'); //evito che l'utente prema il pulsante due volte di fila facendolo scomparire
                        loading.classList.remove('d-none'); //e facendo apparire un pulsante disabilitato con all'interno uno spinner di bootstrap 
                    }
                </script>
            </form>
        </div>
    </div>
</body>

</html>