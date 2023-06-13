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
       INSERT INTO Hoteluri (nume, tara, oras, adresa, stele)
       VALUES (?, ?, ?, ?, ?)
    ");
    
    $nume = $_POST['nume'];
    $tara = $_POST['tara'];
    $oras = $_POST['oras'];
    $adresa = $_POST['adresa'];
    $stele = $_POST['stele'];
    
    $ins->bind_param("sssss", $nume, $tara, $oras, $adresa, $stele);
    
    if ($ins->execute()) {
        header("Location: ./listHotels.php");
    } else {
        die("Eroare: " . $ins->error);
    }
    
    $ins->close();
    $mysqli->close();
} else {
    die('Wrong method');
}
?>
