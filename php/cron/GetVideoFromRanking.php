<?php

require __DIR__ . "/../model/LineNotify.php";
require __DIR__ . "/../model/Niconico.php";

$url = "https://www.nicovideo.jp/ranking/genre/music_sound?tag=VOCALOID";

$line = new LineNotify();
$niconico = new Niconico();

$result = $niconico->get_movie_id_list_from_url($url);

$movie_id_list = $result["movie_id_list"];

$cnt = 0;

foreach ($movie_id_list as $movie_id) {
  $result = $niconico->get_official_info($movie_id);

  if ($result["status"] === "success") {
    $result = $niconico->insert_movie($result["video_id"], $result["title"]);
  }

  var_dump($result);

  if ($result["status"] === "success") {
    $cnt++;
  }
}

$result = $line->sned_message(
  json_decode(
    json_encode([
      "type" => "success",
      "message" => "Add $cnt Videos."
    ])
  )
);
