<?php

// Generate RSS feed for cities, places, and news items
// Combines data from multiple database tables
namespace dsa_twin_cities;

include_once('C:\laragon\www\Twin-cities-web-app\config.php');

// Database connection
$mysqli = new \mysqli(DBMS['Host'], DBMS['User'], DBMS['Password'], DBMS['DBName']);

if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}

// Complex JOIN query to aggregate city, place, and news information
// Ensures comprehensive content for RSS feed
$query = "
    SELECT city.name AS city_name, city.description AS city_description, city.history AS city_history, 
           place.name AS place_name, place.description AS place_description, 
           news.title AS news_title, news.content AS news_content, news.date AS news_date
    FROM city
    LEFT JOIN place ON city.cityID = place.cityID
    LEFT JOIN news ON city.cityID = news.cityID
    ORDER BY city.name, place.name, news.date DESC
";

$result = $mysqli->query($query);

if (!$result) {
    die("Query failed: " . $mysqli->error);
}

// Set proper XML and RSS headers
// Sanitize and encode data for XML compatibility
// Generate RSS feed items dynamically from database results
header("Content-Type: application/rss+xml; charset=UTF-8");

echo "<?xml version='1.0' encoding='UTF-8' ?>";
echo "<rss version='2.0'>";
echo "<channel>";
echo "<title>Twin Cities RSS Feed</title>";
echo "<link></link>";
echo "<description>RSS feed of cities, places of interest, and news items</description>";

while ($row = $result->fetch_assoc()) {
    echo "<item>";
    echo "<title>" . htmlspecialchars($row['city_name']) . " - " . htmlspecialchars($row['place_name']) . "</title>";
    echo "<description>" . htmlspecialchars($row['city_description']) . " " . htmlspecialchars($row['place_description']) . "</description>";
    echo "<pubDate>" . date(DATE_RSS, strtotime($row['news_date'])) . "</pubDate>";
    echo "<link>" . urlencode($row['city_name']) . "</link>";
    echo "<guid>" . urlencode($row['city_name']) . "</guid>";
    echo "</item>";
}

echo "</channel>";
echo "</rss>";

$mysqli->close();
?>
