<?php
session_start();
ini_set('display_errors', '0');
require_once(__DIR__ . "/config.php");
require_once(__DIR__ . "/settings.php");
checkBan();

$status = $pdo->query("SELECT * FROM status");
?> 
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

        <!-- CSS -->
        <link rel="stylesheet" href="assets/css/bootstrap.min.css">
        <link rel="stylesheet" href="assets/css/boxicons.min.css">
        <link rel="stylesheet" href="assets/css/meanmenu.min.css">
        <link rel="stylesheet" href="assets/css/fancybox.min.css">
        <link rel="stylesheet" href="assets/css/owl.carousel.min.css">
        <link rel="stylesheet" href="assets/css/owl.theme.default.min.css">
        <link rel="stylesheet" href="assets/css/magnific-popup.min.css">
        <link rel="stylesheet" href="assets/css/style.css">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css">

        <title><?php echo $serverName; ?> | Status</title>

        <!--OPEN GRAPH FOR DISCORD RICH PRESENCE-->
        <meta property="og:type" content="website" />
        <meta property="og:url" content="<?php echo BASE_URL; ?>" />
        <meta property="og:title" content="<?php echo $serverName; ?>" />
        <meta property="og:description" content="Community Site By Hamz#0001">
        <meta name="theme-color" content="<?php echo $accentColor; ?>">

        <link rel="icon" type="image/png" href="<?php echo $serverLogo; ?>">
    </head>

    <body>

        <!-- NAVBAR -->
        <?php include "includes/navbar.inc.php"; ?>

        <!-- MAIN -->
        <div class="hero-banner-area" id="home">
            <div class="container">
                <div class="row justify-content-center">
                    <span class="main-section-title text-center">Status</span>
                </div>
            </div>
        </div>
        <script>
            fetch('actions/getstatus.php').then(function (resp) {
                resp.text().then(function (text) {
                    $('#status').html(text);
                });
            });
        var auto_refresh = setInterval( function () {
            fetch('actions/getstatus.php').then(function (resp) {
                resp.text().then(function (text) {
                    $('#status').html(text);
                });
            });
        }, 10000);
        </script>
        <section class="faq-area pb-100 white-container" style="padding-top: 50px;">
            <div class="container">
                <?php
                if (!empty($statusNotification)) {
                    echo '<div class="alert alert-danger alert-dismissible fade show" style="text-align: center; font-size: 18px;" role="alert">'.$statusNotification.'</div>
                    ';
                }
                ?>
                <div class="row" id="status">
                    <div class="col-md-12">
                        <div class="login-form">
                            <h3 style="text-align: center; color: white;"><i class="bi bi-check" style="color: #00b67f; padding-right: 10px;"></i> All Systems Operational</h3>
                        </div>
                        <br><br>
                        <?php 
                        foreach ($status as $row)
                        {
                        ?>
                        <div class="login-form" style="margin-bottom: 20px;">
                            <div class="row">
                                <div class="col-md-11">
                                    <h4 style="padding-left: 30px; padding-top: 5px;"><?php echo $row['serviceName'] ?><span id="verification"></span></h4>
                                </div>
                                <div class="col-md-1">
                                    <div class="pulsating-circle-green"></div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="progress">
                                        <?php 
                                        for ($i = 0; $i < 100; $i++)
                                        {
                                            echo '<div class="progress-bar bg-green" role="progressbar" style="width: 1%" aria-valuenow="1" aria-valuemin="0" aria-valuemax="100"></div>';
                                        }
                                        ?>
                                        <div class="progress-bar bg-green-last" role="progressbar" style="width: 1%" aria-valuenow="1" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php
                        }
                        ?>
                    </div>
                </div>
            </div>
            <br><br>
        </section>

        <!-- FOOTER -->
        <?php include "includes/footer.inc.php"; ?>

        <!-- JS -->
        <script src="assets/js/jquery.min.js"></script>
        <script src="assets/js/bootstrap.bundle.min.js"></script>
        <script src="assets/js/owl.carousel.min.js"></script>
        <script src="assets/js/magnific-popup.min.js"></script>
        <script src="assets/js/parallax.min.js"></script>
        <script src="assets/js/meanmenu.min.js"></script>
        <script src="assets/js/fancybox.min.js"></script>
        <script src="assets/js/wow.min.js"></script>
        <script src="assets/js/main.js"></script>
    </body>
</html>