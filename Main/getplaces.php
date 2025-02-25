<?php
header('Content-Type: application/json');
include_once('C:\laragon\www\Twin-cities-web-app\config.php');

$hostname = DBMS['Host'];
$username = DBMS['User'];
$password = DBMS['Password'];
$database_name = DBMS['DBName'];

$db = new mysqli($hostname, $username, $password, $database_name);

if ($db->connect_error) {
    die(json_encode(["error" => "Database connection failed: " . $db->connect_error]));
}

// Fetch places with coordinates, city name
$query = "
    SELECT place.name, place.description, place.latitude, place.longitude, city.name AS city_name 
    FROM place 
    JOIN city ON place.cityID = city.cityID
    ORDER BY city.cityID;
";

$result = $db->query($query);

$places = [];

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $places[] = $row;
    }
}

echo json_encode($places);
$db->close();
