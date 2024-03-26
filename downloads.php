<?php
session_start();
ini_set('display_errors', '0');
require_once(__DIR__ . "/config.php");
require_once(__DIR__ . "/settings.php");
require_once(__DIR__ . "/actions/discord_functions.php");
checkBan();

if (empty($_SESSION['logged_in']))
{
	header('Location: '.BASE_URL.'/actions/register.php');
}

$downloads = $pdo->query("SELECT * FROM downloads");
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

        <title><?php echo $serverName; ?> | Downloads</title>

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
                    <span class="main-section-title text-center">Downloads</span>
                </div>
            </div>
        </div>

        <section class="faq-area ptb-100 white-container">
            <div class="container">
                <div class="row text-center justify-content-center">
                    <?php
                    foreach ($downloads as $row)
                    {
                        if (checkWhitelist($_SESSION['user_discordid'], $row['whitelistid']) == true || empty($row['whitelistid'])) {
                    ?>
                        <div class="col-md-4" style="padding: 20px;">
                            <div class="card" style="padding: 30px; border-radius: 30px; box-shadow: 0px 0px 15px black;">
                                <img class="card-img-top" src="<?php echo $row['image']; ?>" alt="Image">
                                <div class="card-body">
                                    <h5 class="card-title"><?php echo $row['title']; ?></h5>
                                    <p class="card-text text-muted"><?php echo $row['subtext']; ?></p>
                                    <button onclick="download('<?php echo $row['link']; ?>', '<?php echo $row['title']; ?>')" target="_blank" class="btn btn-outline-info">Download</button>
                                </div>
                            </div>
                        </div>
                    <?php
                        }
                    }
                    ?>
                </div>
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
        <script>
            function download(link, title)
            {
                window.open(link, '_blank');
                $.ajax({
                    url: 'actions/functions.php',
                    type: 'POST',
                    data: {downloadlog: title},
                    success: function(data)
                    {

                    }
                });
            }
        </script>
    </body>
</html>