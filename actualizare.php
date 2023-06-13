<?php
$gazda = '127.0.0.1'; $nume_baza_date = 'Project'; $utilizator = 'root'; $parola = '';

$mysqli = new mysqli($gazda, $utilizator, $parola);

if ($mysqli->connect_error) {
    die("Eroare de conexiune: " . $mysqli->connect_error);
}

$mysqli->select_db($nume_baza_date);

// Obține data curentă
$dataCurenta = date('Y-m-d');

// Obține toate rezervările
$queryRezervari = "
    SELECT r.camera_id, r.data_check_in, r.data_check_out
    FROM Rezervari r
    INNER JOIN Camere c ON r.camera_id = c.id
";
$rezultatRezervari = $mysqli->query($queryRezervari);

if ($rezultatRezervari) {
    while ($rezervare = $rezultatRezervari->fetch_assoc()) {
        $idCamera = $rezervare['camera_id'];
        $dataCheckIn = $rezervare['data_check_in'];
        $dataCheckOut = $rezervare['data_check_out'];

        // Determină starea bazată pe date
        if ($dataCurenta >= $dataCheckIn && $dataCurenta <= $dataCheckOut) {
            $stare = 'ocupat';
        } else {
            $stare = 'disponibil';
        }

        // Actualizează starea camerei în baza de date
        $interogareActualizare = "UPDATE Camere SET status = ? WHERE id = ?";
        $declaratieActualizare = $mysqli->prepare($interogareActualizare);
        $declaratieActualizare->bind_param("si", $stare, $idCamera);
        $declaratieActualizare->execute();
    }

    $rezultatRezervari->free();
}

$mysqli->close();
header("Location: ./listCazare.php");
?>