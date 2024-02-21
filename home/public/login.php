<?php
session_start();
require_once("../connessione.php");

if ($_SERVER["REQUEST_METHOD"] === "POST") {
?>
    <script>
        //script per gestire la visualizzazione del pulsante logIn.
        const buttonLogin = document.getElementById('buttonLogin');
        const login = document.getElementById('login');
        const loading = document.getElementById('loading');
        login.classList.remove('d-none'); //faccio apparire il pulsante logIn
        loading.classList.add('d-none'); //faccio scomparire il pulsante loading
    </script>
<?php
    $nome = $connessione->real_escape_string($_POST['nomeUtente']); //recupero il nome con cui si vuole effettuare la login
    $password = $connessione->real_escape_string($_POST['password']); //recupero la password con cui si vuole effettuare la login

    try {
        //verifico che il nome utente abbia più di 4 caratteri
        if (strlen($nome) < 5) {
            $_SESSION['error'] = 1; //nome utente troppo corto
            $_SESSION['loggato'] = false; //blocco la registrazione
            $connessione->close();
        } else { //se il nome utente ha più di 4 caratteri vado avanti col la logIn
            if (strlen($password) < 6) { //se la password contiene meno di 6 caratteri blocco la logIn
                $_SESSION['error'] = 2; //password troppo corta
                $_SESSION['loggato'] = false; //blocco la registrazione
                $connessione->close();
            } else { //se la password ha più di 5 caratteri vado avanti con la logIn
                $sql_select = "SELECT password FROM utente WHERE username = '$nome'";
                $result = $connessione->query($sql_select);
                if (mysqli_num_rows($result)) {
                    $passwordSaved = $result->fetch_array()['password'];
                    if (password_verify($password, $passwordSaved)) { //confronto le due password
                        $_SESSION['loggato'] = true; //login effettuata con successo
                    } else {
                        $_SESSION['error'] = 2; //password non corretta
                        $_SESSION['loggato'] = false; //blocco la registrazione
                        $connessione->close();
                    }
                } else {
                    throw new Exception("Non ci sono account con questo username", "./login.html");
                }
            }
        }
    } catch (Exception $e) {
        $_SESSION['error'] = 3; //errore con una query
        $_SESSION['loggato'] = false; //blocco la login
        $connessione->close();
    }

    if (!isset($_SESSION['error']) && isset($_SESSION['loggato'])) {
        //login avvenuta con successo
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
    <title>Log in</title>

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
                                        echo "Password errata";
                                        break;
                                    case 3:
                                        echo "Errore nella login";
                                        break;
                                    default:
                                        break;
                                }
                                ?>
                            </strong>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            <!-- bottone per chiudere l'alert -->
                        </div>
                    </div>
                    <div class="mb-3">
                        <!-- form di inserimento -->
                        <label for="nomeUtente" class="form-label">Nome utente</label>
                        <input type="text" class="form-control" id="nomeUtente" name="nomeUtente" required />
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" class="form-control" id="password" name="password" required />
                    </div>
                    <div id="login" class="text-center">
                        <!-- pulsante log in -->
                        <button type="submit" id="buttonLogin" class="btn btn-primary">
                            Log in
                        </button>
                        <div class="form-text mt-2">
                            Non sei ancora registrato?
                            <a href="./registrazione.php">Sign up</a>
                        </div>
                    </div>
                    <div id="loading" class="text-center d-none">
                        <!-- pulsante disabilitato che serve a dare l'idea del caricamento, appare alla pressione del pulsante logIn -->
                        <button class="btn btn-primary" type="button" disabled>
                            <span class="spinner-border spinner-border-sm" aria-hidden="true"></span>
                            <span role="status">Loading...</span>
                        </button>
                    </div>
                    <script>
                        /*
                    script per gestire la visualizzazione del pulsante logIn.
                    siccome tutte le query possono richiedere del tempo ad eseguirsi
                    */
                        buttonLogin.onclick = () => { //alla pressione del pulsante logIn
                            login.classList.add('d-none'); //evito che l'utente prema il pulsante due volte di fila facendolo scomparire
                            loading.classList.remove('d-none'); //e facendo apparire un pulsante disabilitato con all'interno uno spinner di bootstrap 
                        }
                    </script>
                </div>
            </form>
        </div>
    </div>
</body>

</html>