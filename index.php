<?php
session_start();
ini_set('display_errors', '0');
require_once(__DIR__ . "/config.php");
require_once(__DIR__ . "/settings.php");
require_once(__DIR__ . "/actions/discord_functions.php");
checkBan();
// ACTION NOTIFICATIONS
if(isset($_GET['notInDiscord']))
{
  $actionMessage = '<div class="alert alert-danger alert-dismissible fade show" style="text-align: center; font-size: 18px;" role="alert"><a href="index.php"><span style="color: black; font-size: 20px;" aria-hidden="true">&times;</span></a> This server requires you to be in the discord in order to login!</div>';
}

if(isset($_GET['notWhitelistedPage']))
{
  $actionMessage = '<div class="alert alert-warning alert-dismissible fade show" style="text-align: center; font-size: 18px;" role="alert"><a href="index.php"><span style="color: black; font-size: 20px;" aria-hidden="true">&times;</span></a> You are not whitelisted for this page!</div>';
}

$faq = $pdo->query("SELECT * FROM faq ORDER BY position ASC");
$features = $pdo->query("SELECT * FROM features");
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

        <title><?php echo $serverName; ?> | Home</title>

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
        <div class="hero-banner-area jarallax" data-jarallax='{"speed": 0.3}' id="home">
            <div class="container main-container">
                <div class="row justify-content-center">
                <?php if($actionMessage){echo $actionMessage;} ?>
                    <div class="col-xl-9">
                        <div class="slider-content text-center">
                            <!-- <h2 class="welcome-header" style="padding-top: 60px; margin-bottom: 60px; font-weight: 800; font-size: 7vw; line-height: .9;">WELCOME!</h2> -->
                            <img src="assets/img/welcome.png" alt="Welcome" style="padding-top: 60px; margin-bottom: 60px;"><br>
                            <a href="fivem://connect/<?php echo $serverIP; ?>" target="_blank" class="btn btn-info main-button-custom skew1"><i class="bi bi-play-fill"></i>&nbsp; PLAY NOW&nbsp;&nbsp;&nbsp;&nbsp;</a>
                            <a href="<?php echo $discordInvite; ?>" target="_blank" class="btn btn-info main-button-custom skew2"><i class="bi bi-discord"></i>&nbsp; JOIN DISCORD</a>
                        </div>
                    </div>
                </div>
                <div class="row justify-content-center" style="margin-top: 60px;">
                    <div class="col-md-4">
                        <div class="card flex-row" style="margin-bottom: 20px;"><img class="card-img-left example-card-img-responsive" style="max-width: 40%; padding: 20px;" src="assets/img/fivem.png"/>
                            <div class="card-body">
                                <h4 class="card-title h5 h4-sm card-title-custom" id="getplayers"></h4>
                                <p class="card-text card-text-custom">Online Players</p>
                            </div>
                        </div>
                    </div>
                    <script>
                            fetch('actions/getplayers.php').then(function (resp) {
                                resp.text().then(function (text) {
                                    $('#getplayers').html(text);
                                });
                            });
                        var auto_refresh = setInterval( function () {
                            fetch('actions/getplayers.php').then(function (resp) {
                                resp.text().then(function (text) {
                                    $('#getplayers').html(text);
                                });
                            });
                        }, 30000);
                    </script>
                    <div class="col-md-4">
                        <div class="card flex-row"><img class="card-img-left example-card-img-responsive" style="max-width: 40%; padding: 20px;" src="assets/img/discord.png"/>
                            <div class="card-body">
                                <h4 class="card-title h5 h4-sm card-title-custom" id="getmembers"></h4>
                                <p class="card-text card-text-custom">Discord Members</p>
                            </div>
                        </div>
                    </div>
                    <script>
                            fetch('actions/getmembers.php').then(function (resp) {
                                resp.text().then(function (text) {
                                    $('#getmembers').html(text);
                                });
                            });
                        var auto_refresh = setInterval( function () {
                            fetch('actions/getmembers.php').then(function (resp) {
                                resp.text().then(function (text) {
                                    $('#getmembers').html(text);
                                });
                            });
                        }, 100000);
                    </script>
                </div>
                <br>
            </div>
        </div>

        <!-- ABOUT -->
        <?php
        if (!empty($about)) {
        ?>
        <section class="pt-80 pb-80 white-container" id="about">
            <div class="container">
                <div class="section-title">
                    <span class="sub-title" style="color: black;">About <span class="accent-color">Us</span></span>
                    <br>
                    <span class="sub-text" style="color: black;"><?php echo $about; ?></span>
                </div>
                <hr style="color: black;">
                <div class="row justify-content-around text-center">
                    <?php
                    foreach($features as $row)
                    {
                    ?>
                    <div class="col-md-3" style="margin-top: 30px;">
                        <i style="font-size: 40px; padding: 25px;" class="accent-color bi bi-<?php echo $row['icon'] ?>"></i>
                        <h5 style="color: black; font-weight: 600;"><?php echo $row['title'] ?></h5>
                        <p style="color: black;" class="par-white"><?php echo $row['text'] ?></p>
                    </div>
                    <?php
                    }
                    ?>
                </div>
            </div>
        </section>
        <?php
        }
        if ($faqStatus == 1) {
        ?>
        <section class="pt-80 pb-80" id="faq">
            <div class="container">
                <style>
                footer {
                    background-color: white !important;
                    color: black;
                }

                .footer-bottom-area {
                    border: none;
                }

                .faq-accordion .accordion .accordion-title {
                    color: white;
                }

                .accordion-item {
                    border: 1px solid white;
                }

                .faq-accordion .accordion .accordion-content p {
                    color: white;
                }

                .faq-accordion .accordion .accordion-item {
                    margin-bottom: 0;
                }

                .socials {
                    color: black !important;
                }

                body.dark-mode footer {
                    background-color: #181818 !important;
                    color: white;
                }

                body.dark-mode .socials {
                    color: white !important;
                }
                </style>
                <div class="faq-accordion" style="width: 50em; max-width: 100%; margin-left: auto; margin-right: auto;">
                    <span class="sub-title" style="text-align: center; padding-bottom: 20px;">FAQ</span>
                    <ul class="accordion">
                    <?php
                    foreach($faq as $row)
                    {
                        echo '<li class="accordion-item">
                        <a class="accordion-title" href="javascript:void(0)">
                            <i class="bx bx-chevron-down"></i>
                            '.$row['question'].'
                        </a>

                        <div class="accordion-content">
                            <p>'.$row['answer'].'</p>
                        </div>
                    </li>';
                    }
                    ?>
                    </ul>
                </div>
                <br>
            </div>
        </section>
        <!-- FOOTER -->
        <footer>
            <div class="container">
                <div class="footer-bottom-area">
                    <div class="row">
                        <div class="col-md-4">
                            <p style="text-align: center;"><?php echo $footerText; ?></p>
                        </div>
                        <div class="col-md-4 text-center">
                            <?php
                            if (!empty($emailSocial))
                            {
                                echo '<a class="socials" target="_blank" href="mailto:'.$emailSocial.'"><i class="bi bi-envelope p-2"></i></a>';
                            }

                            if (!empty($twitterSocial))
                            {
                                echo '<a class="socials" target="_blank" href="'.$twitterSocial.'"><i class="bi bi-twitter p-2"></i></a>';
                            }

                            if (!empty($youtubeSocial))
                            {
                                echo '<a class="socials" target="_blank" href="'.$youtubeSocial.'"><i class="bi bi-youtube p-2"></i></a>';
                            }

                            if (!empty($tiktokSocial))
                            {
                                echo '<a class="socials" target="_blank" href="'.$tiktokSocial.'"><i class="bi bi-tiktok p-2"></i></a>';
                            }

                            if (!empty($instaSocial))
                            {
                                echo '<a class="socials" target="_blank" href="'.$instaSocial.'"><i class="bi bi-instagram p-2"></i></a>';
                            }

                            if (!empty($githubSocial))
                            {
                                echo '<a class="socials" target="_blank" href="'.$githubSocial.'"><i class="bi bi-github p-2"></i></a>';
                            }
                            ?>
                        </div>
                        <div class="col-md-4">
                            <p style="text-align: center;">Made with <3 by <a href="https://discord.gg/3DDWp6w" target="_blank">Hamz#0001</a></p>
                        </div>
                    </div>
                </div>
            </div>
        </footer>
        <?php
        } else {
            include "includes/footer.inc.php";
        }
        ?>

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
        <script>
        (function ($){
        $.fn.counter = function() {
            const $this = $(this),
            numberFrom = parseInt($this.attr('data-from')),
            numberTo = parseInt($this.attr('data-to')),
            delta = numberTo - numberFrom,
            deltaPositive = delta > 0 ? 1 : 0,
            time = parseInt($this.attr('data-time')),
            changeTime = 10;

            let currentNumber = numberFrom,
            value = delta*changeTime/time;
            var interval1;
            const changeNumber = () => {
            currentNumber += value;
            //checks if currentNumber reached numberTo
            (deltaPositive && currentNumber >= numberTo) || (!deltaPositive &&currentNumber<= numberTo) ? currentNumber=numberTo : currentNumber;
            this.text(parseInt(currentNumber));
            currentNumber == numberTo ? clearInterval(interval1) : currentNumber;
            }

            interval1 = setInterval(changeNumber,changeTime);
        }
        }(jQuery));
        </script>
    </body>
</html>