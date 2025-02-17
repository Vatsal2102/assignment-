<?php
namespace dsa_twin_cities;

include('config.php');

// Database connection
$mysqli = new \mysqli(DBMS['Host'], DBMS['User'], DBMS['Password'], DBMS['DB']);

if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}

// Query to get city and place data
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

// Generate RSS feed
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
