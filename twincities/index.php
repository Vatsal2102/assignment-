<?php
namespace dsa_twin_cities;

include_once('config.php');
include_once('weather.php');

// Function to fetch map data using GoogleAPI
function getMapData($latitude, $longitude) {
    $apiKey = GOOGLE_API_KEY;
    $url = "https://maps.googleapis.com/maps/api/staticmap?center={$latitude},{$longitude}&zoom=12&size=600x300&key={$apiKey}";
    return $url;
}

// Function to fetch Flickr images using FlickrAPI
function getFlickrImages($city) {
    $apiKey = FLICKR_API_KEY;
    $url = "https://api.flickr.com/services/rest/?method=flickr.photos.search&api_key={$apiKey}&text={$city}&format=json&nojsoncallback=1";
    $response = file_get_contents($url);
    if ($response === FALSE) {
        return null;
    }
    return json_decode($response, true);
}


// Fetch Flickr images for Birmingham and Frankfurt
$birminghamImages = getFlickrImages('Birmingham');
$frankfurtImages = getFlickrImages('Frankfurt');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Twin Towns and Sister Cities</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div id="app">
        <h1>Twin Towns and Sister Cities</h1>
        <p>
            Twin towns or sister cities are a form of legal and social agreement between towns [and] cities ... in geographically and politically distinct areas to promote cultural and commercial ties. The modern concept of town twinning, conceived after the Second World War in 1947, was intended to foster friendship and understanding between different cultures and between former foes as an act of peace and reconciliation and to encourage trade and tourism. In recent times, town twinning has increasingly been used to form strategic international business links between member cities.[1]
        </p>
        <div id="weather">
            <!-- Date of weather data -->
            <h3>Weather</h3>
            <?php
            $formattedWeather = formatCurrentWeather(getCurrentWeather('Birmingham'));
            echo "Sunrise in Birmingham:". $formattedWeather['sunrise'];
            ?>
        </div>

        <h2>Frankfurt</h2>
    </div>
</body>
<!-- 
    <div id="images">
        <h2>Birmingham Images</h2>
        <?php if ($birminghamImages): ?>
            <?php foreach ($birminghamImages['photos']['photo'] as $photo) : ?>
                <?php
                $photoUrl = "https://live.staticflickr.com/{$photo['server']}/{$photo['id']}_{$photo['secret']}_q.jpg";
                ?>
                <img src="<?php echo $photoUrl; ?>" alt="Birmingham Image">
            <?php endforeach; ?>
        <?php else: ?>
            <p>Image data not available.</p>
        <?php endif; ?>

        <h2>Frankfurt Images</h2>
        <?php if ($frankfurtImages): ?>
            <?php foreach ($frankfurtImages['photos']['photo'] as $photo) : ?>
                <?php
                $photoUrl = "https://live.staticflickr.com/{$photo['server']}/{$photo['id']}_{$photo['secret']}_q.jpg";
                ?>
                <img src="<?php echo $photoUrl; ?>" alt="Frankfurt Image">
            <?php endforeach; ?>
        <?php else: ?>
            <p>Image data not available.</p>
        <?php endif; ?>
    </div> -->
</body>
</html>