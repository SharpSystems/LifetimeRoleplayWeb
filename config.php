<?php
// Documentation: https://docs.hamz.dev/
// Please look at documentation before you create a ticket.
// Recommended Web Hosting: https://hamzhosting.com/
// Add your domain to whitelist: https://license.hamzcad.com/

ini_set('display_errors', '0');

define('BASE_URL', 'https://domain.tld'); // Make sure no / at the end. Same Format as Example!

// SQL DATABASE CONNECTION \\
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASSWORD', 'password');
define('DB_NAME', 'hamzcommunity');

// DISCORD OAUTH2 - Get information from Discord Dev Portal \\
define('TOKEN', 'INSERT_TOKEN');
define('GUILD_ID', 'INSERT_GUILD_ID');
define('OAUTH2_CLIENT_ID', 'INSERT_CLIENT_ID');
define('OAUTH2_CLIENT_SECRET', 'INSERT_CLIENT_SECRET');

// DISCORD ADMIN PERMISSIONS \\
// This will allow an admin to login and setup the permissions in the Admin Settings. This gives access to all sections on the admin page!
$ADMINROLES = [
	"714183846102302820",
	"831898087814856763"
];

// GENERAL SETTINGS \\
date_default_timezone_set('GMT');
define('REQUIRE_IN_GUILD_LOGIN', true); // User needs to be in discord to login to the website. (Recommended: True)

// Rest of the settings are in the Admin page of the website.