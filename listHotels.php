<html>
    <head>
    <link rel="stylesheet" type="text/css" href="style.css">
    </head>
    <body>
    <ul>
        <li><a href="createDB.php">Create DataBase</a></li>
        <li><a href="fillTables.php">Insert Data</a></li>
        <li><a href="listHotels.php">List Hotels</a></li>
        <li><a href="listCazare.php">List Cazare</a></li>
        <li><a href="operations.php">Opeations</a></li>
        <li><a href="actualizare.php">Actualizarea Rezervari</a></li>
    </ul>
        <h1>List hoteluri</h1>
        
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
    echo '<table>';
    echo '<tr> <th >Nume</th> <th>Stele</th> <th>Tara</th> <th >Oras</th> <th >Adresa</th> <th >Stergere</th></tr>';
    foreach ($hoteluriData as $row) {
        echo "<tr>";
        echo "<form method='POST' action='deleteHotel.php'>";
        echo "<input type='hidden' name='id' value='" . $row['id'] . "'>";
        echo "<td>" . $row['nume'] . "</td>";
        echo "<td class='stele'>" . $row['stele'] . "</td>";
        echo "<td>" . $row['tara'] . "</td>";
        echo "<td>" . $row['oras'] . "</td>";
        echo "<td>" . $row['adresa'] . "</td>";
        echo "<td><button class='btn' type='submit'>Stergere</button></td>";
        echo "</form>";
        echo "</tr>";
    }
    
    echo '</table>';

    $mysqli->close();

?>
<form method="POST" action="addHotel.php">
    <input type="text" placeholder="Numele Hotelului" name="nume">
    <label for="stele">Stele</label>
    <select name="stele" id="stele">
        <option value="1">1</option>
        <option value="2">2</option>
        <option value="3">3</option>
        <option value="4">4</option>
        <option value="5">5</option>
    </select>
    <input type="text" placeholder="Tara" name="tara">
    <input type="text" placeholder="Oras" name="oras">
    <input type="text" placeholder="Adresa" name="adresa">
    <input class="btn" type="submit" value="Add"> 
</form>


    </body>
</html>