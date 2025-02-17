<?php
namespace dsa_twin_cities;

include('config.php');

// Function to fetch weather data using OpenWeatherAPI
function getWeatherData($city) {
    $apiKey = OpenWeatherAPI;
    $url = "http://api.openweathermap.org/data/2.5/weather?q={$city}&appid={$apiKey}";
    $response = file_get_contents($url);
    return json_decode($response, true);
}

// Function to fetch map data using GoogleAPI
function getMapData($latitude, $longitude) {
    $apiKey = GoogleAPI;
    $url = "https://maps.googleapis.com/maps/api/staticmap?center={$latitude},{$longitude}&zoom=12&size=600x300&key={$apiKey}";
    return $url;
}

// Fetch weather data for Birmingham and Frankfurt
$birminghamWeather = getWeatherData('Birmingham');
$frankfurtWeather = getWeatherData('Frankfurt');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Twin Cities Web App</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div id="app">
        <h1>Twin Cities Web App</h1>
        
        <h2>Birmingham</h2>
        <p>Weather: <?php echo $birminghamWeather['weather'][0]['description']; ?></p>
        <p>Temperature: <?php echo $birminghamWeather['main']['temp']; ?>K</p>
        <img src="<?php echo getMapData('52.4862', '-1.8904'); ?>" alt="Birmingham Map">

        <h2>Frankfurt</h2>
        <p>Weather: <?php echo $frankfurtWeather['weather'][0]['description']; ?></p>
        <p>Temperature: <?php echo $frankfurtWeather['main']['temp']; ?>K</p>
        <img src="<?php echo getMapData('50.1109', '8.6821'); ?>" alt="Frankfurt Map">
    </div>
</body>
</html>
