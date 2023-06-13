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

    $rem = $mysqli->prepare("
       DELETE FROM Hoteluri WHERE ID = ?
    ");
    
    $id = $_POST['id'];
    $rem->bind_param("s", $id);

    $result = $mysqli->query("SELECT hoteluri.id FROM hoteluri INNER JOIN camere ON hoteluri.id = camere.hotel_id INNER JOIN rezervari ON rezervari.camera_id = camere.id");
    $stmt = $mysqli->prepare("SELECT camere.id FROM camere WHERE camere.hotel_id = ?");
    $stmt->bind_param("s", $id);
    $stmt->execute();
    $result2 = $stmt->get_result()->fetch_assoc();

    if ($result && $stmt) {
        $rezervari = array();
    
        while ($row = $result->fetch_assoc()) {
            $rezervari[] = $row;
        }

        $canDelete = True;
        foreach($rezervari as $rez) {
            if ($rez['id'] == $id) {
                $canDelete = False;
                break;
            }
        }
        $result->free();
    } 
    else {
        echo "Eroare: " . $mysqli->error;
    }
    if($canDelete){
        if ($rem->execute()) {
            $rem->close();
            $mysqli->close();
            header("Location: ./listHotels.php");
        } else {
            die("Eroare: " . $rem->error);
        }
    }
    else{
        echo "There are reservations to this hotel Currently, you can't delete it now! ";
    }
   

} else {
    die('Wrong method');
}
?>
