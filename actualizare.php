<?php
$host = '127.0.0.1'; $dbname = 'Project'; $user = 'root'; $password = '';

$mysqli = new mysqli($host, $user, $password);

if ($mysqli->connect_error) {
    die("Eroare de conexiune: " . $mysqli->connect_error);
}

$mysqli->select_db($dbname);

// Get the current date
$currentDate = date('Y-m-d');

// Get all reservations
$reservationsQuery = "
    SELECT r.camera_id, r.data_check_in, r.data_check_out
    FROM Rezervari r
    INNER JOIN Camere c ON r.camera_id = c.id
";
$reservationsResult = $mysqli->query($reservationsQuery);

if ($reservationsResult) {
    while ($reservation = $reservationsResult->fetch_assoc()) {
        $roomId = $reservation['camera_id'];
        $checkInDate = $reservation['data_check_in'];
        $checkOutDate = $reservation['data_check_out'];

        // Determine the status based on the dates
        if ($currentDate >= $checkInDate && $currentDate <= $checkOutDate) {
            $status = 'occupat';
        } else {
            $status = 'disponibil';
        }

        // Update the room status in the database
        $updateQuery = "UPDATE Camere SET status = ? WHERE id = ?";
        $updateStatement = $mysqli->prepare($updateQuery);
        $updateStatement->bind_param("si", $status, $roomId);
        $updateStatement->execute();
    }

    $reservationsResult->free();

}


$mysqli->close();
header("Location: ./listCazare.php");

?>