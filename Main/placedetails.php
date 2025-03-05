<?php

/**
 * Retrieves detailed information for a specific place from the database.
 *
 * This script accepts a place name as a parameter and fetches comprehensive
 * details about that place from the database. If no place is found, it terminates
 * with an error message.
 *
 * @file placedetails.php
 * @package PlacesAPI
 * @subpackage LocationDetails
 *
 * @uses mysqli Prepared statement to safely fetch place details
 * @uses $_GET|$_POST Place name parameter (method depends on implementation)
 *
 * @param string $place_name Name of the place to retrieve details for
 *
 * @return void Outputs place details or error message
 *
 * @throws DatabaseConnectionException If database connection cannot be established
 * @throws NoPlaceFoundException If no place matches the given name
 *
 * @version 1.0.0
 */

// Retrieve and display detailed information about a specific place from the database
include_once('C:\laragon\www\Twin-cities-web-app\config.php');

// Establish secure database connection using credentials from configuration
// Using prepared statement to prevent SQL injection
$place_name = isset($_GET['place']) ? $_GET['place'] : '';

$hostname = DBMS['Host'];
$username = DBMS['User'];
$password = DBMS['Password'];
$database_name = DBMS['DBName'];

$db = new mysqli($hostname, $username, $password, $database_name);

if ($db->connect_error) {
    die("Database connection failed: " . $db->connect_error);
}

// Fetch place details based on URL parameter
// Handles case where no place is found
$query = "SELECT * FROM place WHERE name = ?";
$stmt = $db->prepare($query);
$stmt->bind_param("s", $place_name);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $place = $result->fetch_assoc();
} else {
    die("No details found for this place.");
}

$db->close();
?>

<!DOCTYPE html>
<html lang="en">
<!-- Display basic place information -->
 <!-- Includes link to external Wikipedia page for more details -->
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $place['name']; ?> - Details</title>
</head>

<body>
    <h1><?php echo $place['name']; ?></h1>
    <p><?php echo $place['description']; ?></p>
    <h3>Location:</h3>
    <p>Latitude: <?php echo $place['latitude']; ?>, Longitude: <?php echo $place['longitude']; ?></p>

    <h3>External Resources:</h3>
    <p><a href="https://en.wikipedia.org/wiki/<?php echo urlencode($place['name']); ?>" target="_blank">Wikipedia Page</a></p>
</body>

</html>