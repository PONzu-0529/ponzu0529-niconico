<?php

// Style: {{host}}/api/{{Version}}/{{Controller File Name}}/{{Method Name}}
// ex: {{host}}/api/v1/auth/get-access-token

$path = $_SERVER["REQUEST_URI"];
$path_list = explode("/", $path);

// Set Host
$host = $_SERVER["HTTP_HOST"];

// set version
if (isset($path_list[2])) {
  $version = $path_list[2];
}

// set file path
if (isset($path_list[3])) {
  $file_path = __DIR__ . "/" . "controller" . "/" . changeCamelCase($path_list[3]) . ".php";
} else {
  $file_path = "";
}

// set body
$body = json_decode(file_get_contents("php://input"), true);

if (
  $path_list[1] === "api" && isset($version) && file_exists($file_path) && isset($path_list[4])
) {
  require_once $file_path;

  $class_name = changeCamelCase($path_list[3]) . "Controller";
  $function_name = changeCamelCase($path_list[4]);

  $class = new $class_name($host, $version, $body);
  $response = json_encode($class->$function_name());

  // define header
  header("Access-Control-Allow-Origin: *");
  header("Access-Control-Allow-Headers: *");

  echo $response;
} else {
  // Vue
  header("Content-Type: text/html; charset=utf-8");
  readfile(__DIR__ . "/../index.html");
}

function changeCamelCase(string $str): string
{
  $str = strtr($str, ["-" => " ", "_" => " "]);
  $str = ucwords($str);
  $str = strtr($str, [" " => ""]);

  return $str;
}
