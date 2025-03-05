<?php
/**
 * Twin Cities Web Application - Interactive Map Display Template
 *
 * This script generates an interactive Google Maps view for a specific city,
 * dynamically rendering markers for points of interest with custom styling
 * and interactive info windows.
 *
 * @package TwinCitiesWebApp
 * @subpackage Templates
 *
 *
 * Include Configuration File
 * 
 * Loads essential configuration settings, including API keys and 
 * application-wide parameters.
 *
 * Retrieve Google Maps API Key
 * 
 * Extracts the Google Maps API key from the global configuration 
 * to enable map rendering and interaction.
 * 
 * @var string $googleApiKey Unique API key for Google Maps JavaScript API
 *
 * Validate Map Data Availability
 * 
 * Ensures that required map data has been passed to the script before 
 * attempting to render the map. Provides an error message if data is missing.
 * 
 * @throws RuntimeException If map data is not provided
 *
 * Sanitize City Name for Safe HTML Output
 * 
 * Uses htmlspecialchars() to prevent potential XSS attacks when 
 * displaying the city name in the page title.
 * 
 * @var string $sanitizedCityName Escaped city name for safe HTML rendering
 *
 * @author: 
 * @version 1.0.0
 */
include_once('C:\laragon\www\Twin-cities-web-app\config.php');


$googleApiKey = GOOGLE_API_KEY;

if (!isset($mapData)) {
    /** 
     * Display Error Message 
     * 
     * Outputs a user-friendly error when map data is unavailable
     * and halts further script execution.
     */
    echo "Map data not available.";
    return;
}

$sanitizedCityName = htmlspecialchars($mapData['name']);
?>

<!-- 
Map Header and Instructions 
Provides context and user guidance for the interactive map
-->
<h1>Map of <?php echo $sanitizedCityName; ?></h1>
<p>Click on a marker to view details.</p>

<!-- 
Map Container 
Defines the HTML element where the Google Map will be rendered
-->
<div class="map-container">
    <!-- 
    Dynamic Map Div 
    Uses city-specific ID to support multiple map initializations
    -->
    <div id="map-<?php echo $sanitizedCityName; ?>" class="map"></div>
</div>

<script>
    /**
     * Dynamic Map Initialization Function
     * 
     * Generates a city-specific map initialization function that:
     * - Sets map center coordinates
     * - Applies custom map styling
     * - Creates markers for points of interest
     * - Adds interactive info windows
     * 
     * @function
     * @name initMap[CityName]
     * @global
     * 
     * @description
     * This function is dynamically named based on the city and is called 
     * by the Google Maps JavaScript API after script loading. It provides 
     * a fully interactive map experience with custom markers and info windows.
     */
    function initMap<?php echo $sanitizedCityName; ?>() {
        /** 
         * Debug Logging for Map Initialization
         * 
         * Outputs a console log message to confirm map initialization 
         * and aid in troubleshooting.
         */
        console.log("initMap function called for <?php echo $sanitizedCityName; ?>");

        /**
         * City Center Coordinates
         * 
         * Defines the geographical center point for map initialization,
         * extracted from the passed map data.
         * 
         * @type {Object} City coordinates with latitude and longitude
         */
        const city = { 
            lat: <?php echo $mapData['lat']; ?>, 
            lng: <?php echo $mapData['lng']; ?> 
        };

        /**
         * Custom Map Styling Configuration
         * 
         * Configures map appearance by selectively hiding:
         * - Point of Interest (POI) labels and geometries
         * - Transit labels and geometries
         * 
         * Provides a cleaner, less cluttered map experience.
         * 
         * @type {Array} Array of Google Maps styling rules
         */
        const mapStyles = [
            { featureType: "poi", elementType: "labels", stylers: [{ visibility: "off" }] },
            { featureType: "poi", elementType: "geometry", stylers: [{ visibility: "off" }] },
            { featureType: "transit", elementType: "labels", stylers: [{ visibility: "off" }] },
            { featureType: "transit", elementType: "geometry", stylers: [{ visibility: "off" }] }
        ];

        /**
         * Google Maps Instance Creation
         * 
         * Initializes a new Google Map with:
         * - Specified zoom level
         * - City center coordinates
         * - Custom map styling
         * 
         * @type {google.maps.Map} Interactive map object
         */
        const map = new google.maps.Map(document.getElementById("map-<?php echo $sanitizedCityName; ?>"), {
            zoom: 12,           // Default zoom level
            center: city,        // City center coordinates
            styles: mapStyles    // Custom map styling
        });

        /**
         * Dynamic Marker and Info Window Generation
         * 
         * Iterates through provided markers to:
         * - Create markers for each point of interest
         * - Define custom marker icons
         * - Generate interactive info windows
         * - Add mouseover/mouseout event listeners
         */
        <?php 
        /** 
         * Marker Iteration Loop
         * 
         * Generates unique markers and info windows for each 
         * point of interest in the current city.
         */
        foreach ($mapData['markers'] as $index => $marker): 
        ?>
            /**
             * Marker Position Definition
             * 
             * Sets geographical coordinates for each point of interest
             */
            const markerPosition<?php echo $index; ?> = { 
                lat: <?php echo $marker['lat']; ?>, 
                lng: <?php echo $marker['lng']; ?> 
            };
            
            /**
             * Marker Instance Creation
             * 
             * Generates a map marker with:
             * - Specific geographical position
             * - Custom icon
             * - Hover title
             */
            const markerInstance<?php echo $index; ?> = new google.maps.Marker({
                position: markerPosition<?php echo $index; ?>,
                map: map,
                title: "<?php echo htmlspecialchars($marker['name']); ?>",
                icon: {
                    url: "<?php echo htmlspecialchars($marker['icon']); ?>",
                    scaledSize: new google.maps.Size(40, 40)
                }
            });

            /**
             * Info Window Configuration
             * 
             * Creates an info window with detailed marker information:
             * - Name
             * - Coordinates
             * - Operating hours
             */
            const infoWindow<?php echo $index; ?> = new google.maps.InfoWindow({
                content: `
                <div>
                    <strong><?php echo htmlspecialchars($marker['name']); ?></strong><br>
                    <em>Coordinates:</em> <?php echo $marker['lat']; ?>, <?php echo $marker['lng']; ?><br>
                    <em>Open Time:</em> <?php echo htmlspecialchars($marker['open']); ?><br>
                    <em>Close Time:</em> <?php echo htmlspecialchars($marker['close']); ?>
                </div>
                `
            });

            /**
             * Interactive Marker Event Listeners
             * 
             * Adds dynamic interaction:
             * - Show info window on mouse hover
             * - Hide info window when mouse leaves marker
             */
            markerInstance<?php echo $index; ?>.addListener("mouseover", () => {
                infoWindow<?php echo $index; ?>.open(map, markerInstance<?php echo $index; ?>);
            });

            markerInstance<?php echo $index; ?>.addListener("mouseout", () => {
                infoWindow<?php echo $index; ?>.close();
            });
        <?php endforeach; ?>
    }
</script>
