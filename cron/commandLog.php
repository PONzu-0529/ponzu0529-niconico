<?php

preg_match('/APP_URL=.+/', file_get_contents(__DIR__ . '/../.env'), $matches);
$host = explode('=', $matches[0])[1];

$ch = curl_init("$host/api/command-log");
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
