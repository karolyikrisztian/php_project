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
            die("Error: Failed to delete the record from Camere.");
        }
    } else {
        echo "The room is currently reserved and cannot be deleted.";
    }

    $stmt->close();
    $mysqli->close();
} else {
    die('Wrong method');
}
?>
