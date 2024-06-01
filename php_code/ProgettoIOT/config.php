
<?php
$host = "localhost";
$user = "root";
$password = "";
$db = "ProgettoIOT";

// Connessione al database
$connessione = new mysqli($host, $user, $password, $db);

// Controllo degli errori di connessione
if ($connessione->connect_errno) {
    die("Errore durante la connessione: " . $connessione->connect_error);
}

?>