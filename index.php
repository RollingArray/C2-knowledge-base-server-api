<?php

/**
 * © Rolling Array https://rollingarray.co.in/
 *
 * long description for the file
 *
 * @summary Bootstrap api route
 * @author code@rollingarray.co.in
 *
 * Created at     : 2021-04-21 10:04:44 
 * Last modified  : 2021-11-03 19:49:46
 */

// add CORS
if (isset($_SERVER['HTTP_ORIGIN'])) {
	header("Access-Control-Allow-Origin: {$_SERVER['HTTP_ORIGIN']}");
	header('Access-Control-Allow-Credentials: true');
	header('Access-Control-Max-Age: 86400');    // cache for 1 day
}

// Access-Control headers are received during OPTIONS requests
if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {

	if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_METHOD']))
		header("Access-Control-Allow-Methods: GET, POST, OPTIONS");

	if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']))
		header("Access-Control-Allow-Headers:        {$_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']}");

	exit(0);
}

require_once __DIR__ . '/vendor/autoload.php';

//lib
require_once __DIR__ . '/app/lib/BaseAPI.class.php';
require_once __DIR__ . '/app/lib/BaseDatabaseAPI.class.php';
require_once __DIR__ . '/app/lib/DBAccessLib.class.php';
require_once __DIR__ . '/app/lib/UtilityLib.class.php';
require_once __DIR__ . '/app/lib/ValidationLib.class.php';
require_once __DIR__ . '/app/lib/MessageLib.class.php';

//settings
require_once __DIR__ . '/settings.php';

//controllers
require_once __DIR__ . '/app/controllers/HelpController.php';

//php error reporting, 1 to enable, 0 to disable
error_reporting(~0);
ini_set('display_errors', 0);

//instances
$helpController = new C2\HelpController($settings);

//route
$requestUri = $_SERVER['REQUEST_URI'];
$apiVersion = 'v1/';

//check each route ans pass on to the controller
switch (true) {
	case strpos($requestUri, $apiVersion.'test'): {
			$helpController->test();
		}
		break;

	case strpos($requestUri, $apiVersion.'menus'): {
		$helpController->helpMenu();
	}
	break;

	case strpos($requestUri, $apiVersion.'article/crud'): {
		$helpController->crudArticle();
	}
	break;

	case strpos($requestUri, $apiVersion.'menu/crud'): {
		$helpController->crudMenu();
	}
	break;

	case strpos($requestUri, $apiVersion.'content/crud'): {
		$helpController->crudContent();
	}
	break;

	case strpos($requestUri, $apiVersion.'article/details'): {
		$helpController->articleDetails();
	}
	break;

	case strpos($requestUri, $apiVersion.'article/search'): {
		$helpController->searchArticle();
	}
	break;

	case strpos($requestUri, $apiVersion.'settings'): {
		$helpController->helpSettings();
	}
	break;

	case strpos($requestUri, $apiVersion.'article/feedback'): {
		$helpController->articleFeedback();
	}
	break;
	
	
	default:
}
