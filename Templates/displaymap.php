<?php
include_once('C:\laragon\www\Twin-cities-web-app\config.php');
$googleApiKey = GOOGLE_API_KEY;

if (!isset($mapData)) {
    echo "Map data not available.";
    return;
}
?>
<h1>Map of <?php echo $mapData['name']; ?></h1>
<p>Click on a marker to view details.</p>

<div id="map-<?php echo $mapData['name']; ?>" class="map" style="height: 500px; width: 100%;"></div>

<script>
    // Initialize the map
    function initMap<?php echo $mapData['name']; ?>() {
        console.log("initMap function called for <?php echo $mapData['name']; ?>"); // Debugging: Check if this appears in the console

        // City coordinates
        const city = { lat: <?php echo $mapData['lat']; ?>, lng: <?php echo $mapData['lng']; ?> };

        // Define map styles to hide default places
        const mapStyles = [
            {
                featureType: "poi", // Points of interest
                elementType: "labels", // Labels for POIs
                stylers: [{ visibility: "off" }] // Hide POI labels
            },
            {
                featureType: "poi", // Points of interest
                elementType: "geometry", // Geometry for POIs
                stylers: [{ visibility: "off" }] // Hide POI geometry
            },
            {
                featureType: "transit", // Transit features (e.g., bus stops, train stations)
                elementType: "labels", // Labels for transit features
                stylers: [{ visibility: "off" }] // Hide transit labels
            },
            {
                featureType: "transit", // Transit features
                elementType: "geometry", // Geometry for transit features
                stylers: [{ visibility: "off" }] // Hide transit geometry
            }
        ];

        // Create a map centered on the city
        const map = new google.maps.Map(document.getElementById("map-<?php echo $mapData['name']; ?>"), {
            zoom: 12,
            center: city,
            styles: mapStyles // Apply custom styles
        });

        // Create an InfoWindow to display details
        const infoWindow = new google.maps.InfoWindow();

        // Add markers for each place
        <?php foreach ($mapData['markers'] as $index => $marker): ?>
            const markerPosition<?php echo $index; ?> = { lat: <?php echo $marker['lat']; ?>, lng: <?php echo $marker['lng']; ?> };
            const markerInstance<?php echo $index; ?> = new google.maps.Marker({
                position: markerPosition<?php echo $index; ?>,
                map: map,
                title: "<?php echo $marker['name']; ?>",
                icon: {
                    url: "<?php echo $marker['icon']; ?>",
                    scaledSize: new google.maps.Size(40, 40) // Resize the icon to 40x40 pixels
                }
            });

            // Add a click listener to the marker to show details
            markerInstance<?php echo $index; ?>.addListener('click', () => {
                infoWindow.setContent(`
                    <div>
                        <strong><?php echo $marker['name']; ?></strong><br>
                        <em>Coordinates:</em> <?php echo $marker['lat']; ?>, <?php echo $marker['lng']; ?>
                    </div>
                `);
                infoWindow.open(map, markerInstance<?php echo $index; ?>);
            });
        <?php endforeach; ?>
    }

    // Load the Google Maps JavaScript API (ONLY ONCE)
    const script<?php echo $mapData['name']; ?> = document.createElement('script');
    script<?php echo $mapData['name']; ?>.src = `https://maps.googleapis.com/maps/api/js?key=<?php echo $googleApiKey; ?>&callback=initMap<?php echo $mapData['name']; ?>`;
    script<?php echo $mapData['name']; ?>.async = true;
    script<?php echo $mapData['name']; ?>.defer = true;
    document.head.appendChild(script<?php echo $mapData['name']; ?>);
</script>