<?php
include_once('C:\laragon\www\Twin-cities-web-app\config.php');
$googleApiKey = GOOGLE_API_KEY;

if (!isset($mapData)) {
    echo "Map data not available.";
    return;
}
?>
<h1>Map of <?php echo htmlspecialchars($mapData['name']); ?></h1>
<p>Click on a marker to view details.</p>

<div class="map-container">
    <div id="map-<?php echo htmlspecialchars($mapData['name']); ?>" class="map"></div>
</div>

<script>
    function initMap<?php echo htmlspecialchars($mapData['name']); ?>() {
        console.log("initMap function called for <?php echo htmlspecialchars($mapData['name']); ?>");

        const city = { lat: <?php echo $mapData['lat']; ?>, lng: <?php echo $mapData['lng']; ?> };

        const mapStyles = [
            { featureType: "poi", elementType: "labels", stylers: [{ visibility: "off" }] },
            { featureType: "poi", elementType: "geometry", stylers: [{ visibility: "off" }] },
            { featureType: "transit", elementType: "labels", stylers: [{ visibility: "off" }] },
            { featureType: "transit", elementType: "geometry", stylers: [{ visibility: "off" }] }
        ];

        const map = new google.maps.Map(document.getElementById("map-<?php echo htmlspecialchars($mapData['name']); ?>"), {
            zoom: 12,
            center: city,
            styles: mapStyles
        });

        <?php foreach ($mapData['markers'] as $index => $marker): ?>
            const markerPosition<?php echo $index; ?> = { lat: <?php echo $marker['lat']; ?>, lng: <?php echo $marker['lng']; ?> };
            const markerInstance<?php echo $index; ?> = new google.maps.Marker({
                position: markerPosition<?php echo $index; ?>,
                map: map,
                title: "<?php echo htmlspecialchars($marker['name']); ?>",
                icon: {
                    url: "<?php echo htmlspecialchars($marker['icon']); ?>",
                    scaledSize: new google.maps.Size(40, 40)
                }
            });

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

            markerInstance<?php echo $index; ?>.addListener("mouseover", () => {
                infoWindow<?php echo $index; ?>.open(map, markerInstance<?php echo $index; ?>);
            });

            markerInstance<?php echo $index; ?>.addListener("mouseout", () => {
                infoWindow<?php echo $index; ?>.close();
            });
        <?php endforeach; ?>
    }
</script>
