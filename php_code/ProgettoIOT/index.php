<?php

session_start();
if(!isset($_SESSION['loggato']) || $_SESSION['loggato'] !== true ){
    header("location: login.html");
    exit;
}
?>

<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistema di Controllo Accessi</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 0;
            background: #f4f4f4;
            color: #333;
        }

        .header {
            background: #17a2b8;
            color: white;
            padding: 10px 0;
        }

        .header_content {
            display: flex;
            justify-content: space-between;
            align-items: center;
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
        }

        .header_titolo {
            font-size: 24px;
            text-decoration: none;
            color: white;
        }

        .header_menu {
            list-style: none;
            display: flex;
            gap: 20px;
        }

        .header_menu li {
            margin: 0;
        }

        .header_menu a {
            text-decoration: none;
            color: white;
            font-size: 18px;
        }

        .header_menu a:hover {
            text-decoration: underline;
        }

        h1 {
            text-align: center;
            margin-top: 50px;
        }

        .button {
            display: flex;
            justify-content: center;
            gap: 20px;
            margin: 20px;
        }

        button {
            padding: 10px 20px;
            font-size: 16px;
            color: white;
            background: #17a2b8;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        button:hover {
            background: #45a049;
        }
    </style>
</head>
<body>
    <header class="header">
        <div class="header_content">
            <a href="index.php" class="header_titolo"><strong>Progetto IOT</strong></a>
            <ul class="header_menu">
                <li><a href="index.php">Home</a></li>
                <li><a href="register.html">Registra Nuovo Utente</a></li>
                <li><a href="logout.php">Logout</a></li>
            </ul>
        </div>
    </header>

    <h1>Sistema di Controllo Accessi</h1>
    <div class="button">
        <button onclick="setServo()">Imposta Servo</button>
        <button onclick="disableAlarm()">Disattiva Allarme</button>
    </div>

    <script>
        function setServo() {
            fetch("http://192.168.1.12/set_servo")
                .then(response => response.text())
                .then(data => console.log(data));
        }

        function disableAlarm() {
            fetch("http://192.168.1.12/disable_alarm")
                .then(response => response.text())
                .then(data => console.log(data));
        }
    </script>
</body>
</html>
