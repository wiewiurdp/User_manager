<?php
session_start();
require_once __DIR__ . '/config/db.php';
$response = [];

try {
    $conn = new PDO(
        "mysql:host=" . DB_HOST . ";dbname=" . DB_DB . ";charset=utf8"
        , DB_LOGIN, DB_PASSWORD,
        [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
    );
} catch (PDOException $e) {
    $response = ['error' => 'DB Connection error: ' . $e->getMessage()];
}

$uriPathInfo = $_SERVER['PATH_INFO'];
$path = explode('/', $uriPathInfo);
$requestClass = $path[1];

$requestClass = preg_replace('#[^0-9a-zA-Z]#', '', $requestClass);
$className = ucfirst($requestClass);
$classFile = __DIR__ . '/class/' . $className . '.php';

require_once $classFile;

$secondArg = isset($path[2]) ? $path[2] : null;

if (!isset($response['error'])) {
    include_once __DIR__ . '/restEndpoints/' . $className . '.php';
}

header('Content-Type: application/json');

if (isset($response['error'])) {
    header("HTTP/1.0 400 Bad Request");
}

echo json_encode($response);
