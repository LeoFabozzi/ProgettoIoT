<?php
require_once('config.php');

// Dettagli admin
$email = 'leofabozzi@gmail.com';
$username = 'admin';
$password = 'progettoiot';
$role = 'admin';

// Hashare la password
$hashed_password = password_hash($password, PASSWORD_DEFAULT);

$sql_insert = "INSERT INTO utenti (email, username, password, role) VALUES ('$email', '$username', '$hashed_password', '$role')";

if ($connessione->query($sql_insert) === TRUE) {
    echo "Admin account created successfully";
} else {
    echo "Error: " . $sql_insert . "<br>" . $connessione->error;
}

$connessione->close();
?>
