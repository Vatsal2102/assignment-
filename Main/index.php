<?php
namespace dsa_twin_cities;

include_once('C:\laragon\www\Twin-cities-web-app\config.php');
include_once('C:\laragon\www\Twin-cities-web-app\Main\weather.php');

// Fetch current weather data for Birmingham
$currentWeatherBirmingham = getCurrentWeather('Birmingham');
$formattedWeatherBirmingham = formatCurrentWeather($currentWeatherBirmingham);

// Fetch current weather data for Frankfurt
$currentWeatherFrankfurt = getCurrentWeather('Frankfurt');
$formattedWeatherFrankfurt = formatCurrentWeather($currentWeatherFrankfurt);

include_once('C:\laragon\www\Twin-cities-web-app\Templates\head.php');
include_once('C:\laragon\www\Twin-cities-web-app\Templates\nav.php');
?>

<div class="container">
    <div class="row">
        <div class="col-md-6">
            <?php
            $formattedWeather = $formattedWeatherBirmingham;
            include('C:\laragon\www\Twin-cities-web-app\Templates\weatherwidget.php');
            ?>
        </div>
        <div class="col-md-6">
            <?php
            $formattedWeather = $formattedWeatherFrankfurt;
            include('C:\laragon\www\Twin-cities-web-app\Templates\weatherwidget.php');
            ?>
        </div>
    </div>
</div>


<?php
include_once('C:\laragon\www\Twin-cities-web-app\Templates\footer.php');
include_once('C:\laragon\www\Twin-cities-web-app\Templates\content.php');
include_once('C:\laragon\www\Twin-cities-web-app\Main\map.php');
?>