<?php

/**
 * Retrieves a list of places with their associated city information from the database.
 *
 * This script connects to the database and performs a SQL query to fetch details of places,
 * including their name, description, geographical coordinates, and corresponding city name.
 * The results are ordered by city ID to ensure consistent output.
 *
 * @file getplaces.php
 * @package PlacesAPI
 * @subpackage Locations
 *
 * @uses mysqli Database connection for querying place information
 *
 * @return void Outputs a JSON-encoded array of places with their details
 *
 * @throws JsonException If JSON encoding fails
 * @throws DatabaseConnectionException If database connection cannot be established
 *
 * @version 1.0.0
 */


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

// Complex SQL query to fetch places with associated city information
// Orders results by city ID for consistent output
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

// Convert database results to JSON for easy client-side consumption
echo json_encode($places);
$db->close();
