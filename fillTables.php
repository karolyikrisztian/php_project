<html>
    <head>
    <link rel="stylesheet" type="text/css" href="style.css">
    </head>
    <body>
    <ul>
        <li><a href="createDB.php">relansarea bazei de date</a></li>
        <li><a href="fillTables.php">inserați datele în mod automat</a></li>
        <li><a href="listHotels.php">Listare Hotels</a></li>
        <li><a href="listCazare.php">Listare Cazare</a></li>
        <li><a href="exemple.php">Exemple</a></li>
        <li><a href="actualizare.php">Actualizarea Rezervari</a></li>
    </ul>
<?php
    $host = '127.0.0.1';
    $dbname = 'Project';
    $user = 'root';
    $password = '';

    $mysqli = new mysqli($host, $user, $password);

    if ($mysqli->connect_error) {
        die("Connection failed: " . $mysqli->connect_error);
    }


    $mysqli->select_db($dbname);

    $hoteluriData = [
        ['Hotel A', 'Romania', 'Bucharest', '123 Main Street', 4],
        ['Hotel B', 'United States', 'New York', '456 Elm Street', 5],
        ['Hotel C', 'France', 'Paris', '789 Oak Street', 3],
        ['Hotel D', 'Italy', 'Rome', '321 Maple Street', 4]
    ];

    $insertHoteluriStmt = $mysqli->prepare("
        INSERT INTO Hoteluri (nume, tara, oras, adresa, stele)
        VALUES (?, ?, ?, ?, ?)
    ");

    foreach ($hoteluriData as $hotel) {
        $insertHoteluriStmt->bind_param("ssssi", $hotel[0], $hotel[1], $hotel[2], $hotel[3], $hotel[4]);
        $insertHoteluriStmt->execute();
    }

    $camereData = [
        [1, 1, 100.00, 'Disponibil'],
        [1, 2, 150.00, 'Disponibil'],
        [2, 1, 120.00, 'Disponibil'],
        [3, 2, 180.00, 'Disponibil']
    ];

    $insertCamereStmt = $mysqli->prepare("
        INSERT INTO Camere (hotel_id, numarul_patelor, pret_pe_seara, status)
        VALUES (?, ?, ?, ?)
    ");

    foreach ($camereData as $camera) {
        $insertCamereStmt->bind_param("iids", $camera[0], $camera[1], $camera[2], $camera[3]);
        $insertCamereStmt->execute();
    }

    $oaspetiData = [
        ['1234567891234', 'John Doe', 'john.doe@example.com'],
        ['1234567891235', 'Jane Smith', 'jane.smith@example.com'],
        ['1234567891236', 'Michael Johnson', 'michael.johnson@example.com'],
        ['1234567891237', 'Emily Davis', 'emily.davis@example.com']
    ];

    $insertOaspetiStmt = $mysqli->prepare("
        INSERT INTO Oaspeti (CNP, nume, email)
        VALUES (?, ?, ?)
    ");

    foreach ($oaspetiData as $oaspet) {
        $insertOaspetiStmt->bind_param("sss", $oaspet[0], $oaspet[1], $oaspet[2]);
        $insertOaspetiStmt->execute();
    }
    
    $insertRezervariStmt = $mysqli->prepare("
    INSERT INTO Rezervari (CNP, camera_id, data_rezervari, data_check_in, data_check_out, nr_persoane)
    VALUES 
        ('1234567891234', 1, '2023/06/01', '2023/06/10', '2023/06/15', 2),
        ('1234567891235', 2, '2023/06/02', '2023/06/11', '2023/06/14', 1),
        ('1234567891234', 3, '2023/06/03', '2023/06/12', '2023/06/16', 2)
");

$insertRezervariStmt->execute();
    echo "Success";

    $mysqli->close();
?>
</body>
</html>