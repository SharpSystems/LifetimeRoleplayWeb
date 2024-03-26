<?php
session_start();
ini_set('display_errors', '0');
require_once(__DIR__ . "/config.php");
require_once(__DIR__ . "/settings.php");
checkBan();

$gallery = $pdo->query("SELECT * FROM gallery");

?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <!-- Required meta tags -->
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

        <title><?php echo $serverName; ?> | Gallery</title>

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
                    <span class="main-section-title text-center">Gallery</span>
                </div>
            </div>
        </div>

        <section class="faq-area ptb-100 white-container">
            <div class="container">
                <div class="row">
                    <?php
                    foreach ($gallery as $row)
                    {
                        echo '
                        <div class="col-lg-4 col-md-6 col-sm-6">
                        <div class="single-gallery-item">
                            <a data-fancybox="gallery" href="assets/img/gallery/'.$row['link'].'">
                                <img src="assets/img/gallery/'.$row['link'].'" alt="image" style="user-select: none; user-drag: none;" draggable="false" onmousedown="return false">
                            </a>
                        </div>
                        </div>   
                        ';
                    }
                    ?>
                </div>
                <hr style="color: black">
            </div>
            <br><br><br>
        </section>

        <!-- FOOTER -->
        <?php include "includes/footer.inc.php"; ?>

        <!-- JS -->
        <script src="assets/js/jquery.min.js"></script>
        <script src="assets/js/bootstrap.bundle.min.js"></script>
        <script src="assets/js/magnific-popup.min.js"></script>
        <script src="assets/js/owl.carousel.min.js"></script>
        <script src="assets/js/parallax.min.js"></script>
        <script src="assets/js/meanmenu.min.js"></script>
        <script src="assets/js/fancybox.min.js"></script>
        <script src="assets/js/wow.min.js"></script>
        <script src="assets/js/main.js"></script>
    </body>
</html>