<?php

require __DIR__ . '/config/config.php';

// Define
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: *");

$body = file_get_contents("php://input");
$body_array = json_decode($body, true);

// Connect MySQL
$mysqli = new mysqli($hostname, $username, $password, $database);

// Check AccessToken
$result = $mysqli->query(
  "SELECT access_token FROM user_account_access_token;"
);

$result_array = $result->fetch_all(MYSQLI_NUM);

if (!in_array([$body_array['accessToken']], $result_array)) {
  echo json_encode([
    'status' => 'failed',
    'message' => 'This AccessToken is not registered.'
  ]);

  return;
}

// Check Timeout
$result = $mysqli->query(
  "SELECT created_at FROM user_account_access_token WHERE access_token = '" . $body_array['accessToken'] . "';"
);

$created_at = new DateTime($result->fetch_assoc()['created_at']);

$today = new DateTime();

if ($today < $created_at->modify('+1 minute')) {
  echo json_encode([
    'status' => 'success'
  ]);
} else {
  echo json_encode([
    'status' => 'failed',
    'message' => 'This AccessToken Timeout.'
  ]);
}

