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

        <title><?php echo $serverName; ?> | Maintenance</title>

        <!--OPEN GRAPH FOR DISCORD RICH PRESENCE-->
        <meta property="og:type" content="website" />
        <meta property="og:url" content="<?php echo BASE_URL; ?>" />
        <meta property="og:title" content="<?php echo $serverName; ?>" />
        <meta property="og:description" content="Community Site By Hamz#0001">
        <meta name="theme-color" content="<?php echo $accentColor; ?>">

        <link rel="icon" type="image/png" href="<?php echo $serverLogo; ?>">
    </head>

    <body>

        <!-- MAIN -->
        <div class="hero-banner-area jarallax" data-jarallax='{"speed": 0.3}'>
            <div class="container main-container">
                <div class="row justify-content-center">
                    <div class="col-md-12">
                        <div class="text-center">
                            <p style="padding-top: 140px; margin-bottom: 60px; font-weight: 800; font-size: 45px; line-height: 1;">MAINTENANCE MODE :(</p>
                            <i><p style="padding-top: 40px; margin-bottom: 100px; font-weight: 400; font-size: 40px; line-height: 1;">Sorry for the inconvenience, we should be back up shortly!</p></i>
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
                    <div class="col-md-4 text-center">
                        <p style="text-align: center;"><?php echo $footerText; ?></p>
                    </div>
                    <div class="col-md-4 text-center">
                    </div>
                    <div class="col-md-4 text-center">
                        <a style="text-align: center;" href="<?php echo BASE_URL; ?>/actions/register.php"><i class="bi bi-person-fill"></i></a>
                    </div>
                </div>
            </div>
        </div>
        </footer>

        <!-- JS -->
        <script src="assets/js/parallax.min.js"></script>
        <script src="assets/js/main.js"></script>
    </body>
</html>