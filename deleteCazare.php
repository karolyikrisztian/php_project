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

    $id = $_POST['id'];

    $stmt = $mysqli->prepare("SELECT camera_id  FROM rezervari WHERE camera_id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 0) {
        $rem = $mysqli->prepare("DELETE FROM camere WHERE id = ?");
        $rem->bind_param("i", $id);
        $rem->execute();

        if ($rem->affected_rows > 0) {
            header("Location: ./listCazare.php");
            exit;
        } else {
            die("Eroare: Nu s-a reușit ștergerea înregistrării din Camere.");
        }
    } else {
        echo "Camera este rezervată în prezent și nu poate fi ștearsă.";
    }

    $stmt->close();
    $mysqli->close();
} else {
    die('Metoda greșită');
}
?>
</body></html>