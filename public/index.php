<?php

define('PREVENT_DIRECT_ACCESS', TRUE);
define('ROOT_DIR', dirname(__DIR__) . DIRECTORY_SEPARATOR);
define('APP_DIR', ROOT_DIR . 'app' . DIRECTORY_SEPARATOR);
define('SYSTEM_DIR', ROOT_DIR . 'scheme' . DIRECTORY_SEPARATOR);
define('PUBLIC_DIR', ROOT_DIR . 'public' . DIRECTORY_SEPARATOR);
define('RUNTIME_DIR', ROOT_DIR . 'runtime' . DIRECTORY_SEPARATOR);

if (($_SERVER['REQUEST_METHOD'] ?? 'GET') === 'GET') {
	$api_path = parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH);
	$api_messages = [
		'/api/login' => 'Use POST /api/login with JSON fields username and password.',
		'/api/register' => 'Use POST /api/register with JSON fields username, email, and password.',
	];

	if (isset($api_messages[$api_path])) {
		header('Allow: POST, OPTIONS');
		header('Content-Type: application/json; charset=UTF-8');
		http_response_code(405);
		echo json_encode(['error' => $api_messages[$api_path], 'status' => 405]);
		exit;
	}
}

require_once SYSTEM_DIR . 'kernel/LavaLust.php';
