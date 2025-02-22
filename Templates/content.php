<body class="<?php echo $darkModeClass; ?>">

    <div class="container">
        <h1>Dark Mode with PHP & AJAX</h1>

        <button id="darkModeToggle">
            <?php echo isset($_SESSION['dark-mode']) && $_SESSION['dark-mode'] === "enabled" ? "☀️ Light Mode" : "🌙 Dark Mode"; ?>
        </button>
    </div>

    <script src="C:\laragon\www\Twin-cities-web-app\Main\darkmode.js"></script>
</body>