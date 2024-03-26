<?php
session_start();
ini_set('display_errors', '0');
require_once(__DIR__ . "/config.php");
require_once(__DIR__ . "/settings.php");

?> 
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

        <!-- CSS -->
        <link rel="stylesheet" href="assets/css/bootstrap.min.css">
        <link rel="stylesheet" href="assets/css/style.css">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css">

        <title><?php echo $serverName; ?> | Banned</title>

        <link rel="icon" type="image/png" href="<?php echo $serverLogo; ?>">
    </head>

    <body>

        <!-- MAIN -->
        <div class="hero-banner-area jarallax" data-jarallax='{"speed": 0.3}'>
            <div class="container main-container">
                <div class="row justify-content-center">
                    <div class="col-md-12">
                        <div class="text-center">
                            <h2 style="padding-top: 140px; padding-bottom: 100px; font-weight: 800; font-size: 100px; line-height: .9;">YOU ARE BANNED.</h2>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- FOOTER -->
        <footer>
        <div class="container">
            <div class="footer-bottom-area">
                <div class="row">
                    <div class="col-md-11">
                        <p style="text-align: left;"><?php echo $footerText; ?></p>
                    </div>
                </div>
            </div>
        </div>
        </footer>

        <!-- JS -->
        <script src="assets/js/jquery.min.js"></script>
        <script src="assets/js/bootstrap.bundle.min.js"></script>
        <script src="assets/js/owl.carousel.min.js"></script>
        <script src="assets/js/parallax.min.js"></script>
        <script src="assets/js/meanmenu.min.js"></script>
        <script src="assets/js/fancybox.min.js"></script>
        <script src="assets/js/wow.min.js"></script>
        <script src="assets/js/main.js"></script>
    </body>
</html>