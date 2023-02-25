<?php

require __DIR__ . '/../vendor/autoload.php';

$ch = curl_init(env('APP_URL', 'http://localhost') . '/api/command-log');
$query = json_encode([
  'command' => $argv[1] ?? 'command_empty',
  'output' => $argv[2] ?? 'output_empty'
]);

curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-type: application/json'));
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, $query);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

$response = curl_exec($ch);
curl_close($ch);

$response_obj = json_decode($response);
