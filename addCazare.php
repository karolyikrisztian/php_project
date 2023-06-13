<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $host = '127.0.0.1';
    $dbname = 'Project';
    $user = 'root';
    $password = '';

    $mysqli = new mysqli($host, $user, $password);

    if ($mysqli->connect_error) {
        die("Connection failed: " . $mysqli->connect_error);
    }

    $mysqli->select_db($dbname);

    $ins = $mysqli->prepare("
       INSERT INTO camere (hotel_id, numarul_patelor, pret_pe_seara, status)
       VALUES (?, ?, ?, ?)
    ");
    
    $hotel = $_POST['hotel'];
    $pret = $_POST['pret'];
    $patele = $_POST['patele'];
    $status = $_POST['status'];
    
    $ins->bind_param("iiis", $hotel, $patele, $pret, $status);
    
    if ($ins->execute()) {
        header("Location: ./listCazare.php");
    } else {
        die("Eroare: " . $ins->error);
    }
    
    $ins->close();
    $mysqli->close();
} else {
    die('Wrong method');
}
?>
