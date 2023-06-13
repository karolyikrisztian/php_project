<html>
    <head>
    <link rel="stylesheet" type="text/css" href="style.css">
    </head>
    <body>
    <ul>
        <li><a href="createDB.php">Create DataBase</a></li>
        <li><a href="fillTables.php">Insert Data</a></li>
        <li><a href="listHotels.php">List Hotels</a></li>
        <li><a href="listCazare.php">List Cazare</a></li>
        <li><a href="operations.php">Opeations</a></li>
        <li><a href="actualizare.php">Actualizarea Rezervari</a></li>
    </ul>
<?php
    $host = '127.0.0.1';  
    $dbname = 'Project';      
    $user = 'root';  
    $password = '';

    $mysqli = new mysqli($host, $user, $password);

    if ($mysqli->connect_error) {
        die("Eroare de conexiune: " . $mysqli->connect_error);
    }

    $mysqli->query("DROP DATABASE IF EXISTS $dbname;");
    $mysqli->query("CREATE DATABASE $dbname;");
    $mysqli->select_db($dbname);

    $mysqli->query("
        CREATE TABLE IF NOT EXISTS Hoteluri (
            id INT(11) AUTO_INCREMENT PRIMARY KEY,
            nume VARCHAR(50) NOT NULL,
            tara VARCHAR(50) NOT NULL,
            oras VARCHAR(50) NOT NULL,
            adresa VARCHAR(100) NOT NULL,
            stele INT(11) NOT NULL
        );
    ");

    $mysqli->query("
    CREATE TABLE IF NOT EXISTS Camere (
        id INT(11) AUTO_INCREMENT PRIMARY KEY,
        hotel_id INT(11) NOT NULL,
        numarul_patelor INT(11) NOT NULL,
        pret_pe_seara DECIMAL(10,2) NOT NULL,
        status VARCHAR(25) NOT NULL DEFAULT 'available',
        FOREIGN KEY (hotel_id) REFERENCES Hoteluri(id)
            ON DELETE CASCADE
    );
");

    $mysqli->query("
        CREATE TABLE IF NOT EXISTS Oaspeti (
            CNP VARCHAR(13) PRIMARY KEY,
            nume VARCHAR(100) NOT NULL,
            email VARCHAR(100) NOT NULL
        );
    ");

    $mysqli->query("
        CREATE TABLE IF NOT EXISTS Rezervari (
            CNP VARCHAR(13) NOT NULL,
            camera_id INT(11) NOT NULL,
            data_rezervari DATE NOT NULL,
            data_check_in DATE NOT NULL,
            data_check_out DATE NOT NULL,
            nr_persoane INT(11) NOT NULL,
            PRIMARY KEY (CNP, camera_id, data_rezervari),
            FOREIGN KEY (CNP) REFERENCES Oaspeti(CNP),
            FOREIGN KEY (camera_id) REFERENCES Camere(id)
        );
    ");

    $mysqli->query("
        CREATE TABLE IF NOT EXISTS Facilitati (
            id INT(11) AUTO_INCREMENT PRIMARY KEY,
            room_id INT(11) NOT NULL,
            Facilitati VARCHAR(100) NOT NULL,
            FOREIGN KEY (room_id) REFERENCES Camere(id)
        );
    ");

    echo "Baza de date și tabelul au fost create cu succes";

    $mysqli->close();
?>
</body>
</html>