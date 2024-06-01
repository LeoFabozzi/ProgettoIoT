<?php



session_start();
if(!isset($_SESSION['loggato']) || $_SESSION['loggato'] !== true ){
    header("location: login.html");
    exit;
}



require_once('config.php');

// Controlla se sono stati inviati dati tramite il metodo POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Recupera i valori inviati dal modulo di registrazione
    $email = $connessione->real_escape_string($_POST['email']);
    $username = $connessione->real_escape_string($_POST['username']);
    $password = $connessione->real_escape_string($_POST['password']);
    $uid = "83%02AC%02AF%020D";
    $role = "admin";
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Query per verificare se l'email o l'username sono già utilizzati
    $check_query = "SELECT * FROM utenti WHERE email = '$email' OR username = '$username'";
    $result = $connessione->query($check_query);

    // Se non ci sono corrispondenze, procedi con l'inserimento nel database
    if ($result->num_rows == 0) {
        $sql = "INSERT INTO utenti (email, username, password,role,uid) VALUES ('$email', '$username', '$hashed_password','$role','$uid')";

        if ($connessione->query($sql) === true) {
            // Reindirizza l'utente all'area privata dopo la registrazione
            header("location: index.php");
            exit; // Termina lo script dopo il reindirizzamento
        } else {
            echo "Errore durante la registrazione utente: " . $connessione->error;
        }
    } else {
        echo '
                <script>
                    alert("email o username già utilizzati ");
                    window.location= "register.html";
                </script>   
                '; 
    }
} else {
    // Se non sono stati inviati dati tramite POST, gestisci l'errore
   
    echo '
    <script>
        alert("i dati non sono stati inviati corretamente ");
        window.location= "register.html";
    </script>   
    '; 
}
// Chiudi la connessione al database
$connessione->close();
?>