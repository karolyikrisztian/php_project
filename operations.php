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
        <h1>Példák</h1>
<?php
//Hotelek, szobál, foglalások, vendégek lekérdezése és tárolása egy tömbben
$host = '127.0.0.1';
$dbname = 'Project';
$user = 'root';
$password = '';

$mysqli = new mysqli($host, $user, $password);

if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}

$mysqli->select_db($dbname);
$resultH = $mysqli->query("SELECT * FROM hoteluri");
$resultC = $mysqli->query("SELECT * FROM camere");
$resultR = $mysqli->query("SELECT * FROM rezervari");
$resultO = $mysqli->query("SELECT * FROM oaspeti");
$cazare = $mysqli->query("SELECT camere.hotel_id, hoteluri.nume, hoteluri.stele, hoteluri.oras, camere.id,  camere.numarul_patelor, camere.pret_pe_seara, camere.status FROM camere inner join hoteluri on camere.hotel_id = hoteluri.id");
 

if ($resultH && $resultC &&  $resultR &&  $resultO) {
    $hoteluriData = array();  $camereData = array(); $RezervariData = array(); $oaspetiData = array(); $cazareData = array();

    while ($row = $resultH->fetch_assoc()) {
        $hoteluriData[] = $row;
    }
    while ($row = $resultC->fetch_assoc()) {
        $camereData[] = $row;
    }
    while ($row = $resultR->fetch_assoc()) {
        $RezervariData[] = $row;
    }
    while ($row = $resultO->fetch_assoc()) {
        $oaspetiData[] = $row;
    }
    while ($row = $cazare->fetch_assoc()) {
        $cazareData[] = $row;
    }

} 
else {
    echo "Eroare: " . $mysqli->error;
}
//-------------------------------------------------------------------------------------
//hotelek neveinek elmentése egy külön tömbbe
$hotel_names = array_fill(0, count($hoteluriData), "0");

for ($i = 0; $i < count($hoteluriData); $i++) {
    $hotel_names[$i] = $hoteluriData[$i]['nume'];
}
for ($i = 0; $i < count($hoteluriData); $i++) {
    $hotel_names[$i] = $hoteluriData[$i]['nume'];
}

// rendezés ABC sorrendbe
//sort($hotel_names);
bubbleSort($hotel_names);

print "Hotelek ABC sorrendben: ";
foreach ($hotel_names as $hotel_name) {
    print $hotel_name . ", ";
}

//rendezés manuálisan: buborékrendezés ABC sorrendben, név szerint
function bubbleSort(&$array) {
    $n = count($array);
    for ($i = 0; $i < $n - 1; $i++) {
        for ($j = 0; $j < $n - $i - 1; $j++) {
            if ($array[$j] > $array[$j + 1]) {
                $temp = $array[$j];
                $array[$j] = $array[$j + 1];
                $array[$j + 1] = $temp;
            }
        }
    }
}
// ár szerinti rendezés
function ordeByPrice(&$rooms) {
    $n = count($rooms);
    for ($i = 0; $i < $n - 1; $i++) {
        for ($j = 0; $j < $n - $i - 1; $j++) {
            if ($rooms[$j]['pret_pe_seara'] > $rooms[$j + 1]['pret_pe_seara']) {
                $temp = $rooms[$j];
                $rooms[$j] = $rooms[$j + 1];
                $rooms[$j + 1] = $temp;
            }
        }
    }
}

//szállások végigjárása és a kategóriájuk meghatározása
print "<br>_____________________<br>Szállások és árkategóriájuk<br>" ;
$n = count($cazareData);
$i = 0;
do {
    print $cazareData[$i]['nume'] ." --> ". $cazareData[$i]['pret_pe_seara'] ." RON --> ". category( $cazareData[$i])."<br>";
    $i++;
} while ($i < $n);

print "<br>_____________________<br>Szállások és árkategóriájuk ismét, de ár szerint rendezve<br>" ;
ordeByPrice($cazareData);
$n = count($cazareData);
$i = 0;
do {
    print $cazareData[$i]['nume'] ." --> ". $cazareData[$i]['pret_pe_seara'] ." RON --> ". category( $cazareData[$i])."<br>";
    $i++;
} while ($i < $n);


//switch függvényben, hogy visszaadja a szállás kategóriáját ár szerint
function category($camere) {
    switch ($camere['pret_pe_seara']) {
        case ($camere['pret_pe_seara'] <= 100):
            return "Cheap";
            break;
        case ($camere['pret_pe_seara'] <= 150):
            return "Average";
            break;
        case ($camere['pret_pe_seara'] <= 200):
            return "Expensive";
            break;
        default:
            return "Very Expensive";
    }
}

//Hotelenként átlagos szállás ár
print "<br>";
printAveragePrices($mysqli);
function printAveragePrices($mysqli) {
    $query = "
        SELECT h.nume, AVG(c.pret_pe_seara) AS avg_price
        FROM Hoteluri h
        LEFT JOIN Camere c ON h.id = c.hotel_id
        GROUP BY h.id
    ";

    $result = $mysqli->query($query);

    if ($result->num_rows > 0) {
        echo "Average pret_pe_seara of each hotel:<br>";
        while ($row = $result->fetch_assoc()) {
            if($row['avg_price'] != "")
            {
                $formattedNumber = number_format($row['avg_price'], 2);
                echo "Hotel: " . $row['nume'] . ", Average Price: " . $formattedNumber . "<br>";
            }
        }
    } else {
        echo "No hotels found.";
    }
}







?>
</body>
</html>