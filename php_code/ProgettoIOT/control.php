<?php

require_once('config.php');




if(isset($_GET['allarme'])){
    $allarm=$connessione->real_escape_string($_GET['allarme']);

    $sql_insert2="INSERT INTO access_allarm (allarm) VALUES ('$allarm')";
    if($connessione->query($sql_insert2)==true){
        echo "Nuovo record inserito con successo";
    }else{
        echo "Errore" . $sql_insert2 . "<br>" .$connessione->error; 
    }

}elseif(isset($_GET['uid'])){
    $uid = $connessione->real_escape_string($_GET['uid']);
    $sql_find_user = "SELECT id FROM utenti WHERE uid = '$uid'";
    $result = $connessione->query($sql_find_user);

if ($result->num_rows == 1) {
    $row = $result->fetch_assoc();
    $user_id = $row['id'];

    // Inserisci il record nel log degli accessi
    $sql_insert = "INSERT INTO access_logs (uid, user_id) VALUES ('$uid', '$user_id')";
    
    if ($connessione->query($sql_insert) === TRUE) {
        echo "Nuovo record creato con successo";
    } else {
        echo "Errore: " . $sql_insert . "<br>" . $connessione->error;
    }
} else {
    echo "Errore: UID non trovato";
}

}else{
    echo "Errore Parametro fornito non valido";
}

$connessione->close();
?>
