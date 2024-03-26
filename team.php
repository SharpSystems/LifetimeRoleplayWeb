<?php
session_start();
ini_set('display_errors', '0');
require_once(__DIR__ . "/config.php");
require_once(__DIR__ . "/settings.php");

$teamCategory = $pdo->query("SELECT * FROM team WHERE type='category' ORDER BY position ASC");

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

        <title><?php echo $serverName; ?> | Team</title>

        <!--OPEN GRAPH FOR DISCORD RICH PRESENCE-->
        <meta property="og:type" content="website" />
        <meta property="og:url" content="<?php echo BASE_URL; ?>" />
        <meta property="og:title" content="<?php echo $serverName; ?>" />
        <meta property="og:description" content="Community Site By Hamz#0001">
        <meta name="theme-color" content="<?php echo $accentColor; ?>">

        <link rel="icon" type="image/png" href="<?php echo $serverLogo; ?>">

        <style>
            .img-thumbnail {
                border: none;
            }

            .custom-shadow {
                box-shadow: 0 .425rem .60rem rgba(0,0,0,.1) !important;
            }
        </style>
    </head>

    <body>

        <!-- NAVBAR -->
        <?php include "includes/navbar.inc.php"; ?>

        <!-- MAIN -->
        <div class="hero-banner-area" id="home">
            <div class="container">
                <div class="row justify-content-center">
                    <span class="main-section-title text-center">Our Team</span>
                </div>
            </div>
        </div>

        <section class="faq-area ptb-100 white-container">
            <div class="container">
                <?php
                foreach ($teamCategory as $row)
                {
                    $categoryName = $row['name'];
                ?>
                <hr style="color: black;">
                <h2 style="color: black; text-align: center;"><?php echo $categoryName; ?></h2>
                <hr style="color: black;">
                <div class="row text-center justify-content-center pt-50 pb-50">
                    <?php
                    $teamMember = $pdo->prepare("SELECT * FROM team WHERE type='member' AND category=:categoryName");
                    $teamMember->bindParam(':categoryName', $categoryName);
                    $teamMember->execute();


                    foreach ($teamMember as $row2)
                    {
                        $memberName = $row2['name'];
                        $memberDiscordID = $row2['discordid'];
                        $memberAvatar = "";


                        $avatar = $pdo->prepare("SELECT * FROM users WHERE discordid=:memberDiscordID");
                        $avatar->bindParam(':memberDiscordID', $memberDiscordID);
                        $avatar->execute();

                        foreach ($avatar as $row3)
                        {
                            $memberAvatar = $row3['avatar'];
                        }

                        if($memberAvatar == "")
                        {
                            $memberAvatar = "assets/img/default-team.jpg";
                        }
                    ?>
                    <div class="col-md-3">
                        <div class="rounded custom-shadow py-4 px-4">
                            <img class="img-fluid rounded-circle mb-3 img-thumbnail shadow-sm" style="width: 70%; " src="<?php echo $memberAvatar; ?>">
                            <h4 style="color: black;" class="black"><?php echo $memberName; ?></h4>
                        </div>
                    </div>
                    <?php
                    }
                    ?>
                </div>
                <?php
                }
                ?>
            </div>
            <br><br><br>
        </section>

        <!-- FOOTER -->
        <?php include "includes/footer.inc.php"; ?>

        <!-- JS -->
        <script src="assets/js/jquery.min.js"></script>
        <script src="assets/js/bootstrap.bundle.min.js"></script>
        <script src="assets/js/owl.carousel.min.js"></script>
        <script src="assets/js/parallax.min.js"></script>
        <script src="assets/js/magnific-popup.min.js"></script>
        <script src="assets/js/meanmenu.min.js"></script>
        <script src="assets/js/fancybox.min.js"></script>
        <script src="assets/js/wow.min.js"></script>
        <script src="assets/js/main.js"></script>
    </body>
</html>