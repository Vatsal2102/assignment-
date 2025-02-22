<?php
session_start();

// Handle AJAX request
if (isset($_POST['toggleDarkMode'])) {
    // Toggle dark mode session state
    $_SESSION['dark-mode'] = isset($_SESSION['dark-mode']) && $_SESSION['dark-mode'] === "enabled" ? "disabled" : "enabled";

    // Return JSON response
    echo json_encode(["darkMode" => $_SESSION['dark-mode']]);
    exit;
}

// Set the dark mode class based on session value
$darkModeClass = isset($_SESSION['dark-mode']) && $_SESSION['dark-mode'] === "enabled" ? "dark-mode" : "";
