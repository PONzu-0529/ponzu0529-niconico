<?php

class Web
{
  public function get_web_info(string $url): array
  {
    $ch = curl_init($url);

    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    $html = curl_exec($ch);

    curl_close($ch);

    preg_match(
      "/<title>(.+)<\/title>/",
      $html,
      $output
    );

    $title = str_replace(
      ["<title>", "</title>"],
      ["", ""],
      $output[0]
    );

    return [
      "status" => "success",
      "title" => $title
    ];
  }
}
