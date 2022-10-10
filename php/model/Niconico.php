<?php

class Niconico
{
  public function get_official_info(string $video_id): array
  {
    $xml = simplexml_load_file("https://ext.nicovideo.jp/api/getthumbinfo/" . $video_id);

    if ($xml === false) {
      return
        [
          "status" => "failure",
          "message" => "ERROR: Failure getting info."
        ];
    }

    // Not Found Video ID
    if (isset($xml->error)) {
      return
        [
          "status" => "failure",
          "message" => "ERROR: Not Found or Invalid."
        ];
    }

    return
      [
        "status" => "success",
        "video_id" => $video_id,
        "title" => (string)$xml->thumb->title,
        "description" => (string)$xml->thumb->description,
        "user_nickname" => (string)$xml->thumb->user_nickname
      ];
  }


  public function get_movie_id_list_from_url(string $url): array
  {
    $ch = curl_init($url);

    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    $html = curl_exec($ch);

    curl_close($ch);

    preg_match_all(
      "/sm[0-9]+/",
      $html,
      $output
    );

    $movie_id_list = array_unique($output[0]);

    return [
      "status" => "success",
      "movie_id_list" => $movie_id_list
    ];
  }


  public function insert_movie(string $video_id, string $title): array
  {
    require __DIR__ . "/../config/config.php";

    // Connect MySQL
    $mysqli = new mysqli($hostname, $username, $password, $database);

    // Check Registered
    $result = $mysqli->query(
      "
        SELECT
          `video_id`
        FROM
          `niconico_video_titles`
        ;
      "
    );

    if (gettype($result) !== "boolean") {
      $result_array = $result->fetch_all(MYSQLI_NUM);

      if (in_array([$video_id], $result_array)) {
        return [
          "status" => "failure",
          "message" => "ERROR: $video_id is already registered."
        ];
      }
    } elseif (!$result) {
      return [
        "status" => "failure",
        "message" => "ERROR: Failure registered."
      ];
    }

    // Insert Video
    $result = $mysqli->query(
      "
        INSERT INTO `niconico_video_titles`
          (`video_id`, `title`, `created_at`, `updated_at`)
        VALUES
          (\"$video_id\", \"$title\", now(), now())
        ;
      "
    );

    if (!$result) {
      return [
        "status" => "failure",
        "message" => "ERROR: Failure registered."
      ];
    }

    // Insert Flags
    $result = $mysqli->query(
      "
        SELECT
          `id`
        FROM
          `niconico_video_titles`
        WHERE
          `video_id` = \"$video_id\"
        ;
      "
    );

    if (!$result) {
      return [
        "status" => "failure",
        "message" => "ERROR: Failure registered."
      ];
    }

    $video_id_result = $result->fetch_all(MYSQLI_ASSOC);
    $video_id = $video_id_result[0]["id"];

    $result = $mysqli->query(
      "
        INSERT INTO `niconico_video_title_flags`
          (`title_id`, `favorite`, `skip`, `created_at`, `updated_at`)
        VALUES
          (\"$video_id\", 0, 0, now(), now())
        ;
      "
    );

    if (!$result) {
      return [
        "status" => "failure",
        "message" => "ERROR: Failure registered."
      ];
    }

    return [
      "status" => "success"
    ];
  }
}
