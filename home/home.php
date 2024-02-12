<?php
if ($_SERVER["REQUEST_METHOD"] === "POST") {
if (isset($_POST['linkSignUp'])) {
    echo "hai premuto sign up";
}
} else {
    echo "errore nel form";
}
?>