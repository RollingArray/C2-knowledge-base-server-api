<?php

namespace C2;

/**
 * © Rolling Array https://rollingarray.co.in/
 *
 * long description for the file
 *
 * @summary short description for the file
 * @author code@rollingarray.co.in
 *
 * Created at     : 2021-04-21 10:04:44 
 * Last modified  : 2021-11-03 21:09:24
 */

require_once __DIR__ . '/app/lib/DotEnvLib.class.php';

//dot env instances, load environment variables
$dotEnvLib = new DotEnv\DotEnvLib(__DIR__.'/.env');
$dotEnvLib->load();

$settings = [

	// environment specific configurations
	'db' => [
		'host' => getenv('DB_HOST'),
		'username' => getenv('DB_USERNAME'),
		'password' => getenv('DB_PASSWORD'),
		'database' => getenv('DATABASE'),
		'port' => getenv('DB_PORT'),
	],

	'email' => [
		//
	],

	// Monolog settings
	'logger' => [
		'name' => 'C2',
		'path' => 'logs/logs.log',
	],

	//validation rules
	'validationRules' => [
		//user
		'article_id' => '/^[a-zA-Z0-9\-]{2,200}/',
		'search_key' => '/^[a-zA-Z0-9]{2,200}/',
		'app_name' => '/^[a-zA-Z0-9\-]{2,200}/',
		'sign_up_url' => '/^(?:([A-Za-z]+):)?(\/{0,3})([0-9.\-A-Za-z]+)(?::(\d+))?(?:\/([^?#]*))?(?:\?([^#]*))?(?:#(.*))?$/',
		'support_email' => '/^([\w-]+(?:\.[\w-]+)*)@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$/',
		'feedback_type' => '/(delightful|neutral|sad)/',
	],
	'errorValidationMessage' => [
		'article_id' => 'Invalid article id',
	],
	'errorMessage' => [
		//
	],
	'successMessage' => [
		//
	],
];
?>
