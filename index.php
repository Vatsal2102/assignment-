<!DOCTYPE html>
<html>
<head>
    <title>Home</title>
    <!-- Put the css file here -->
    <link rel="stylesheet" type="text/css" href="####">
    <meta name="viewport" content="width=device-width, initial-scale=1">
</head>
<!-- PHP code here -->
<?php
    // API key
    $apikey = "";
    // Cities name
    $city1 = "";
    $city2 = "";
    // API URL
    $apiUrl1 = "http://api.openweathermap.org/data/2.5/weather?q={$city1}&appid={$apikey}&units=metric";
    $apiUrl2 = "http://api.openweathermap.org/data/2.5/weather?q={$city2}&appid={$apikey}&units=metric";
    // Error handling
    $response1 = file_get_contents($apiUrl1);
    if ($response1 === FALSE) {
        die('Error occurred');
    }
    $response2 = file_get_contents($apiUrl2);
    if ($response2 === FALSE) {
        die('Error occurred');
    }

    // Decode the JSON data
    $data1 = json_decode($response1, true);
    $data2 = json_decode($response2, true);
    // Error handling
    if ($data1['cod'] !== 200) {
        die('Error: ' . $data1['message']);
    }
    if ($data2['cod'] !== 200) {
        die('Error: ' . $data2['message']);
    }

    // Assign the data to variables
    


?>
<!-- HTML code here -->
<body>
    

</body>
</html>