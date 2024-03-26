<?php
// GETTING ALL SETTINGS & ESTABLISHING SQL CONNECTION \\
try{
    $pdo = new PDO('mysql:host='.DB_HOST.';dbname='.DB_NAME, DB_USER, DB_PASSWORD);
} catch(PDOException $ex)
{
    echo json_encode(array("response" => "400", "message" => "Missing Parameters"));
}

$settings = $pdo->query("SELECT * FROM settings");

foreach ($settings as $row)
{
    $serverName = $row['serverName'];
    $serverLogo = BASE_URL."/assets/img/".$row['serverLogo'];
	$serverIP = $row['serverIP'];
	$discordInvite = $row['discordInvite'];
	$footerText = $row['footerText'];
	$about = $row['about'];
	$backgroundImage = BASE_URL."/assets/img/".$row['backgroundImage'];
	$statusNotification = $row['statusNotification'];
	$accentColor = $row['accentColor'];
	$backgroundColor = $row['backgroundColor'];
	$maintenance = $row['maintenance'];
	$faqStatus = $row['faqStatus'];

	$emailSocial = $row['emailSocial'];
	$twitterSocial = $row['twitterSocial'];
	$youtubeSocial = $row['youtubeSocial'];
	$tiktokSocial = $row['tiktokSocial'];
	$instaSocial = $row['instaSocial'];
	$githubSocial = $row['githubSocial'];

	$settings_log = $row['settings_log'];
	$navigation_log = $row['navigation_log'];
	$form_log = $row['form_log'];
	$page_log = $row['page_log'];
	$ban_log = $row['ban_log'];
	$rules_log = $row['rule_log'];
	$gallery_log = $row['gallery_log'];
	$team_log = $row['team_log'];
	$dev_log = $row['dev_log'];
	$feedback_log = $row['feedback_log'];
	$permissions_log = $row['permissions_log'];
}

function checkBan()
{
	global $pdo;
	
    $user_discordid = $_SESSION['user_discordid'];

    $stmt = $pdo->prepare("SELECT * FROM bans WHERE discordid=?");
    $stmt->execute([$user_discordid]);
    $result = $stmt->fetchAll();

    if (sizeof($result) > 0)
    {
		session_unset();
		session_destroy();
        header('Location: '.BASE_URL.'/ban.php');
    }
}
?>
<style>
	.hero-banner-area {
		background-image: url("<?php echo $backgroundImage; ?>") !important;
	}

	:root {
		--mainColor: <?php echo $accentColor; ?> !important;
	}

	.accent-color {
		color: <?php echo $accentColor; ?> !important;
	}

	.white-container {
		background-color: <?php echo $backgroundColor; ?> !important;
	}
</style>