<?php
session_start();
ini_set('display_errors', '0');
require_once(__DIR__ . "/config.php");
require_once(__DIR__ . "/settings.php");
require_once(__DIR__ . "/actions/discord_functions.php");
checkBan();

$pageID = $_GET['id'];
if (is_numeric($pageID))
{
    $pages = $pdo->prepare ("SELECT * FROM pages WHERE ID=?");
    $pages->execute([$pageID]);
}
if (empty($pageID))
{
    header('Location: index.php');
}

foreach($pages as $row)
{
    $title = $row['title'];
    $subtext = $row['subtext'];
    $whitelistid = $row['whitelistid'];
    $htmlText = $row['html'];
}

if (empty($title))
{
    header('Location: index.php');
}

// Whitelist Check
if (checkWhitelist($_SESSION['user_discordid'], $whitelistid) == true || $whitelistid == "") {
    // Whitelisted
} else {
    header('Location: index.php?notWhitelistedPage');
}
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

        <title><?php echo $serverName; ?> | <?php echo $title; ?></title>

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
        <div class="hero-banner-area">
            <div class="container">
                <div class="row justify-content-center">
                    <span class="main-section-title text-center"><?php echo $title; ?></span>
                    <span class="sub-text text-center"><?php echo $subtext; ?></span>
                </div>
            </div>
        </div>

        <section class="faq-area ptb-100 white-container">
            <div class="container" style="color: black;">
                <?php echo html_entity_decode($htmlText); ?>
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