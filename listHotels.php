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
        <h1>Listare hoteluri</h1>
<?php
    $gazda = '127.0.0.1';
    $nume_baza_date = 'Project';
    $utilizator = 'root';
    $parola = '';

    $mysqli = new mysqli($gazda, $utilizator, $parola);

    if ($mysqli->connect_error) {
        die("Conexiune eșuată: " . $mysqli->connect_error);
    }

    $mysqli->select_db($nume_baza_date);
    $rezultat = $mysqli->query("SELECT * FROM hoteluri");
 
    if ($rezultat) {
        $dateHoteluri = array();

        while ($rand = $rezultat->fetch_assoc()) {
            $dateHoteluri[] = $rand;
        }

        $rezultat->free();
    } 
    else {
        echo "Eroare: " . $mysqli->error;
    }
    echo '<table>';
    echo '<tr> <th >Nume</th> <th>Stele</th> <th>Tara</th> <th >Oras</th> <th >Adresa</th> <th >Ștergere</th></tr>';
    foreach ($dateHoteluri as $rand) {
        echo "<tr>";
        echo "<form method='POST' action='deleteHotel.php'>";
        echo "<input type='hidden' name='id' value='" . $rand['id'] . "'>";
        echo "<td>" . $rand['nume'] . "</td>";
        echo "<td class='stele'>" . $rand['stele'] . "</td>";
        echo "<td>" . $rand['tara'] . "</td>";
        echo "<td>" . $rand['oras'] . "</td>";
        echo "<td>" . $rand['adresa'] . "</td>";
        echo "<td><button class='btn' type='submit'>Ștergere</button></td>";
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
    <input type="text" requried="required" placeholder="Tara" name="tara">
    <input type="text" requried="required" placeholder="Oras" name="oras">
    <input type="text" requried="required" placeholder="Adresa" name="adresa">
    <input class="btn"  type="submit" value="Adaugă"> 
</form>
    </body>
</html>