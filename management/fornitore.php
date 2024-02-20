<?php
session_start();

if (!isset($_SESSION['articoli'])) {
    $_SESSION['articoli'] = [
      // Reparto Frutta e Verdura
      [
          "codice" => "FV001",
          "nome" => "Mela",
          "reparto" => "Frutta e Verdura",
          "prezzo" => 1.50,
      ],
      [
          "codice" => "FV002",
          "nome" => "Banana",
          "reparto" => "Frutta e Verdura",
          "prezzo" => 0.80,
      ],
      [
          "codice" => "FV003",
          "nome" => "Cetriolo",
          "reparto" => "Frutta e Verdura",
          "prezzo" => 0.99,
      ],
      [
          "codice" => "FV004",
          "nome" => "Insalata",
          "reparto" => "Frutta e Verdura",
          "prezzo" => 1.20,
      ],
      [
          "codice" => "FV005",
          "nome" => "Anguria",
          "reparto" => "Frutta e Verdura",
          "prezzo" => 3.50,
      ],
      [
          "codice" => "FV006",
          "nome" => "Kiwi",
          "reparto" => "Frutta e Verdura",
          "prezzo" => 2.00,
      ],
      [
          "codice" => "FV007",
          "nome" => "Arancia",
          "reparto" => "Frutta e Verdura",
          "prezzo" => 1.80,
      ],
      [
          "codice" => "FV008",
          "nome" => "Pomodoro",
          "reparto" => "Frutta e Verdura",
          "prezzo" => 1.00,
      ],
      [
          "codice" => "FV009",
          "nome" => "Pera",
          "reparto" => "Frutta e Verdura",
          "prezzo" => 2.20,
      ],
      [
          "codice" => "FV010",
          "nome" => "Zucchine",
          "reparto" => "Frutta e Verdura",
          "prezzo" => 1.30,
      ],
  
      // Reparto Gastronomia
      [
          "codice" => "GAS001",
          "nome" => "Pizza Margherita",
          "reparto" => "Gastronomia",
          "prezzo" => 5.99,
      ],
      [
          "codice" => "GAS002",
          "nome" => "Lasagna al Forno",
          "reparto" => "Gastronomia",
          "prezzo" => 8.50,
      ],
      [
          "codice" => "GAS003",
          "nome" => "Panzerotto",
          "reparto" => "Gastronomia",
          "prezzo" => 3.20,
      ],
      [
          "codice" => "GAS004",
          "nome" => "Arancini",
          "reparto" => "Gastronomia",
          "prezzo" => 2.50,
      ],
      [
          "codice" => "GAS005",
          "nome" => "Cotoletta Milanese",
          "reparto" => "Gastronomia",
          "prezzo" => 7.50,
      ],
      [
          "codice" => "GAS006",
          "nome" => "Insalata di Mare",
          "reparto" => "Gastronomia",
          "prezzo" => 9.99,
      ],
      [
          "codice" => "GAS007",
          "nome" => "Focaccia",
          "reparto" => "Gastronomia",
          "prezzo" => 4.00,
      ],
      [
          "codice" => "GAS008",
          "nome" => "Polpette al Sugo",
          "reparto" => "Gastronomia",
          "prezzo" => 6.75,
      ],
      [
          "codice" => "GAS009",
          "nome" => "Sformato di Verdure",
          "reparto" => "Gastronomia",
          "prezzo" => 5.25,
      ],
      [
          "codice" => "GAS010",
          "nome" => "Gnocchi al Pesto",
          "reparto" => "Gastronomia",
          "prezzo" => 4.80,
      ],
  
      // Reparto Pasticceria
      [
          "codice" => "PAS001",
          "nome" => "Cannolo Siciliano",
          "reparto" => "Pasticceria",
          "prezzo" => 2.50,
      ],
      [
          "codice" => "PAS002",
          "nome" => "Tiramisù",
          "reparto" => "Pasticceria",
          "prezzo" => 3.99,
      ],
      [
          "codice" => "PAS003",
          "nome" => "Profiteroles",
          "reparto" => "Pasticceria",
          "prezzo" => 4.50,
      ],
      [
          "codice" => "PAS004",
          "nome" => "Sfogliatella",
          "reparto" => "Pasticceria",
          "prezzo" => 2.20,
      ],
      [
          "codice" => "PAS005",
          "nome" => "Croissant",
          "reparto" => "Pasticceria",
          "prezzo" => 1.80,
      ],
      [
          "codice" => "PAS006",
          "nome" => "Baba al Rum",
          "reparto" => "Pasticceria",
          "prezzo" => 3.25,
      ],
      [
          "codice" => "PAS007",
          "nome" => "Millefoglie",
          "reparto" => "Pasticceria",
          "prezzo" => 5.99,
      ],
      [
          "codice" => "PAS008",
          "nome" => "Cheesecake",
          "reparto" => "Pasticceria",
          "prezzo" => 6.50,
      ],
      [
          "codice" => "PAS009",
          "nome" => "Cupcake",
          "reparto" => "Pasticceria",
          "prezzo" => 2.75,
      ],
      [
          "codice" => "PAS010",
          "nome" => "Biscotti alla Vaniglia",
          "reparto" => "Pasticceria",
          "prezzo" => 3.00,
      ],
  
      // Reparto Pescheria
      [
          "codice" => "PES001",
          "nome" => "Salmone Fresco",
          "reparto" => "Pescheria",
          "prezzo" => 12.99,
      ],
      [
          "codice" => "PES002",
          "nome" => "Gamberetti",
          "reparto" => "Pescheria",
          "prezzo" => 9.75,
      ],
      [
          "codice" => "PES003",
          "nome" => "Calamari",
          "reparto" => "Pescheria",
          "prezzo" => 8.50,
      ],
      [
          "codice" => "PES004",
          "nome" => "Branzino",
          "reparto" => "Pescheria",
          "prezzo" => 14.50,
      ],
      [
          "codice" => "PES005",
          "nome" => "Alici",
          "reparto" => "Pescheria",
          "prezzo" => 5.99,
      ],
      [
          "codice" => "PES006",
          "nome" => "Cozze",
          "reparto" => "Pescheria",
          "prezzo" => 7.25,
      ],
      [
          "codice" => "PES007",
          "nome" => "Scampi",
          "reparto" => "Pescheria",
          "prezzo" => 16.99,
      ],
      [
          "codice" => "PES008",
          "nome" => "Telline",
          "reparto" => "Pescheria",
          "prezzo" => 10.00,
      ],
      [
          "codice" => "PES009",
          "nome" => "Vongole",
          "reparto" => "Pescheria",
          "prezzo" => 11.75,
      ],
      [
          "codice" => "PES010",
          "nome" => "Pesce Spada",
          "reparto" => "Pescheria",
          "prezzo" => 18.50,
      ],
  
      // Reparto Macelleria
      [
          "codice" => "MAC001",
          "nome" => "Bistecca di Manzo",
          "reparto" => "Macelleria",
          "prezzo" => 15.99,
      ],
      [
          "codice" => "MAC002",
          "nome" => "Salsicce di Maiale",
          "reparto" => "Macelleria",
          "prezzo" => 6.25,
      ],
      [
          "codice" => "MAC003",
          "nome" => "Filetto di Maiale",
          "reparto" => "Macelleria",
          "prezzo" => 10.50,
      ],
      [
          "codice" => "MAC004",
          "nome" => "Pollo Intero",
          "reparto" => "Macelleria",
          "prezzo" => 7.99,
      ],
      [
          "codice" => "MAC005",
          "nome" => "Costine di Agnello",
          "reparto" => "Macelleria",
          "prezzo" => 12.75,
      ],
      [
          "codice" => "MAC006",
          "nome" => "Arrosto di Manzo",
          "reparto" => "Macelleria",
          "prezzo" => 20.00,
      ],
      [
          "codice" => "MAC007",
          "nome" => "Hamburger di Manzo",
          "reparto" => "Macelleria",
          "prezzo" => 5.50,
      ],
      [
          "codice" => "MAC008",
          "nome" => "Cervello di Vitello",
          "reparto" => "Macelleria",
          "prezzo" => 8.25,
      ],
      [
          "codice" => "MAC009",
          "nome" => "Fegato di Pollo",
          "reparto" => "Macelleria",
          "prezzo" => 4.00,
      ],
      [
          "codice" => "MAC010",
          "nome" => "Salamella",
          "reparto" => "Macelleria",
          "prezzo" => 3.50,
      ],
  ];
}


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    if (isset($_POST['articoli']) && is_array($_POST['articoli']) && isset($_POST['quantita']) && is_array($_POST['quantita'])) {
        $utente['ordini'] = isset($utente['ordini']) ? $utente['ordini'] : [];
        foreach ($_POST['articoli'] as $codice) {
            $quantita = $_POST['quantita'][$codice];
            if ($quantita > 0) {

                $ordine = [
                    'codice' => $codice,
                    'quantita' => $quantita,
                ];
                $utente['ordini'][] = $ordine;
            }
        }

      
       if(  $_SESSION['market'] = $utente){
        header('Location: pag.php') ;
       }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <title>Fornitore</title>
</head>
<body>

<nav class="navbar navbar-expand-lg bg-light">
  <div class="container-fluid">
    <a class="navbar-brand" href="pag.php">Fornitore</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
    </div>
    <div class="row justify-content-end">
            <div class="col-2">
               <a href="/home/private/home.html"> <button type="button" class="btn btn-primary">Indietro</button> </a>
            </div>
        </div>
  </div>
</nav>



<div class="container mt-5">
    <form action="<?php echo $_SERVER["PHP_SELF"] ?>" method="post">
        <table class="table">
            <thead>
                <tr>
                    <th></th>
                    <th>Codice</th>
                    <th>Nome</th>
                    <th>Prezzo</th>
                    <th>Quantità</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if (isset($_SESSION['articoli']) && is_array($_SESSION['articoli'])) {
                    foreach ($_SESSION['articoli'] as $articolo) {
                        if ($articolo['reparto'] === 'Frutta e Verdura') {
                            echo '<tr>';
                            echo '<td><input type="checkbox" name="articoli[]" value="' . $articolo['codice'] . '"></td>';
                            echo '<td>' . $articolo['codice'] . '</td>';
                            echo '<td>' . $articolo['nome'] . '</td>';
                            echo '<td>' . $articolo['prezzo'] . ' €</td>';
                            echo '<td><input type="number" name="quantita[' . $articolo['codice'] . ']" value="0" min="0"></td>';
                            echo '</tr>';
                        }
                    }
                } else {
                    echo '<tr><td colspan="5">Nessun articolo disponibile</td></tr>';
                }
                ?>
            </tbody>
        </table>
        <button type="submit" class="btn btn-primary">Aggiungi al carrello</button>
    </form>
</div>



</body>
</html>
