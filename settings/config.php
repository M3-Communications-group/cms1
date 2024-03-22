<?php
DEFINE("DEV_MODE", TRUE);

DEFINE("SESSION_NAME", "statehouse");
DEFINE("SITE_TITLE", "State House Seychelles | Office of the President");
DEFINE("SITE_DESCRIPTION", "Get the latest news and updates, explore behind-the-scenes photos from State House and find out how you can engage with the most open administration in our country’s history.");
DEFINE("SITE_HOST", filter_input(INPUT_SERVER, 'HTTP_HOST', FILTER_SANITIZE_URL));
DEFINE("SITE_PROTOCOL", filter_input(INPUT_SERVER, 'HTTPS') == "on" ? 'https://' : 'http://'); 

require_once (DEV_MODE) ? 'development.php' : 'production.php';

DEFINE("SITE_URL", SITE_PROTOCOL . SITE_HOST . SITE_BASE);

DEFINE("SITE_IMAGE", SITE_URL . "img/statehouse_big.jpg");
DEFINE("SITE_IMAGE_WIDTH", "1200"); //1200
DEFINE("SITE_IMAGE_HEIGHT", "630"); // 630


