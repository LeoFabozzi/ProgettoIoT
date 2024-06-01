<?php
session_start();

// Verifica se l'utente ha effettuato l'accesso
if (!isset($_SESSION['loggato'])) {
    // L'utente non ha effettuato l'accesso, reindirizzalo alla pagina di login
    header('Location: login.php');
    exit(); // Assicura che lo script termini qui e il reindirizzamento sia eseguito correttamente
}


$_SESSION = array();

session_destroy();

header("location: login.html");
exit;
?>