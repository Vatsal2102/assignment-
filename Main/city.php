<?php

namespace dsa_twin_cities;

include_once('C:\laragon\www\Twin-cities-web-app\config.php');
include_once('C:\laragon\www\Twin-cities-web-app\Main\weather.php');

// Check if city is provided in the URL and that it is one of the ones we are using
if (isset($_GET['city'])) {
    $cityName = $_GET['city'];

    if ($cityName == CITY1['NAME']) {
        $city1 = [
            'name' => CITY1['NAME'],
            'country' => CITY1['COUNTRY'],
            'latitude' => CITY1['LATITUDE'],
            'longitude' => CITY1['LONGITUDE'],
            'markers' => json_decode(CITY1['MARKERS'], true)
        ];

        $city2 = [
            'name' => CITY2['NAME'],
            'country' => CITY2['COUNTRY'],
            'latitude' => CITY2['LATITUDE'],
            'longitude' => CITY2['LONGITUDE'],
            'markers' => json_decode(CITY2['MARKERS'], true)
        ];
    } elseif ($cityName == CITY2['NAME']) {
        $city1 = [
            'name' => CITY2['NAME'],
            'country' => CITY2['COUNTRY'],
            'latitude' => CITY2['LATITUDE'],
            'longitude' => CITY2['LONGITUDE'],
            'markers' => json_decode(CITY2['MARKERS'], true)
        ];

        $city2 = [
            'name' => CITY1['NAME'],
            'country' => CITY1['COUNTRY'],
            'latitude' => CITY1['LATITUDE'],
            'longitude' => CITY1['LONGITUDE'],
            'markers' => json_decode(CITY1['MARKERS'], true)
        ];
    } else {
        header("Location: 404.php");
        die();
    }

    // Function to fetch and format weather data
    function getFormattedWeatherData($city) {
        $currentWeather = getCurrentWeather($city['name'], $city['country']);
        $formattedCurrentWeather = formatCurrentWeather($currentWeather);

        $forecastWeather = getForecastWeather($city['name'], $city['country']);
        $formattedForecastWeather = formatForecastWeather($forecastWeather);

        return [
            'current' => $formattedCurrentWeather,
            'forecast' => $formattedForecastWeather
        ];
    }

    // Fetch and format weather data for both cities
    $weatherDataCity1 = getFormattedWeatherData($city1);
    $weatherDataCity2 = getFormattedWeatherData($city2);

    include_once('C:\laragon\www\Twin-cities-web-app\Templates\head.php');
    include_once('C:\laragon\www\Twin-cities-web-app\Templates\nav.php');

    function displayMap($city) {
        $mapData = [
            'name' => $city['name'],
            'lat' => $city['latitude'],
            'lng' => $city['longitude'],
            'markers' => $city['markers']
        ];
        include('C:\laragon\www\Twin-cities-web-app\Templates\displaymap.php');
    }

    // Display map only for the selected city
    displayMap($city1);

    // Display combined weather widget
    include('C:\laragon\www\Twin-cities-web-app\Templates\weatherwidget.php');

    include_once('C:\laragon\www\Twin-cities-web-app\Templates\footer.php');

    ?>
    <script>
        function initializeMaps() {
            initMap<?php echo $city1['name']; ?>();
        }
    </script>
    <?php
} else {
    header("Location: 404.php");
    die();
}
?>

