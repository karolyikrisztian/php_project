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
        <h1>Listare Cazare</h1>
        
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
    $camRes = $mysqli->query("SELECT camere.hotel_id, hoteluri.nume, hoteluri.stele, hoteluri.oras, camere.id,  camere.numarul_patelor, camere.pret_pe_seara, camere.status FROM camere inner join hoteluri on camere.hotel_id = hoteluri.id");
 
    if ($camRes) {
        $camereData = array();
        while ($row = $camRes->fetch_assoc()) {
            $camereData[] = $row;
        }
        $camRes->free();
    } 


    else {
        echo "Eroare: " . $mysqli->error;
    }
    echo '<table>';
    echo '<tr><th>Status</th> <th >Hotel</th> <th>Stele</th> <th>Patele</th> <th>Pret pe seasra</th> <th >Oras</th> <th >Stergere</th></tr>';
    foreach ($camereData as $row) {
        $stele = str_repeat("★ ", $row['stele']);
        echo "<tr>";
        echo "<form method='POST' action='deleteCazare.php'>";
        echo "<input type='hidden' name='id' value='" . $row['id'] . "'>";
        echo "<td>" . strtolower($row['status']) . "</td>";
        echo "<td>" . $row['nume'] . "</td>";
        echo "<td '>" .$stele . "</td>";
        echo "<td>" . $row['numarul_patelor'] . "</td>";
        echo "<td>" . $row['pret_pe_seara'] . "</td>";
        echo "<td>" . $row['oras'] . "</td>";
        echo "<td><button class='btn' type='submit'>Stergere</button></td>";
        echo "</form>";
        echo "</tr>";
    }
    
    $result = $mysqli->query("SELECT * FROM hoteluri");
 
    if ($result) {
        $hoteluriData = array();

        while ($row = $result->fetch_assoc()) {
            $hoteluriData[] = $row;
        }

        $result->free();
    } 
    else {
        echo "Eroare: " . $mysqli->error;
    }


    echo '</table>';
    $mysqli->close();
?>
<h1> Cazare noua</h1>
<form method="POST" action="addCazare.php">
    <select name="hotel" id="stele">
    <?php
        foreach($hoteluriData as $hotel){
            echo "<option value='".$hotel['id']."'>".$hotel['nume']."</option>";
        }
    ?>
    </select>
    <input type="number"  min="0"  name="patele" placeholder="Numarol patelor">
    <input type="number"  min="0" name="pret" placeholder="Pret pe Seara">
    <input type="radio" name="status" value="Disponibil" checked> Disponibil 
    <input type="radio" name="status" value="Occupat"> Occupat
    <input class="btn" type="submit" value="Add"> 
</form>


    </body>
</html>