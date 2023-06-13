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
        die("Conexiunea a eșuat: " . $mysqli->connect_error);
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
        echo "Există rezervări pentru acest hotel În prezent, nu le puteți șterge acum! ";
    }
   

} else {
    die(' method grasit');
}
?>
</body>
</html>