<?php

class Niconico
{
  function GetVideoIdList(string $url)
  {
    // define
    $pattern = "/(sm|nm|so)[0-9]+/";

    $ch = curl_init($url);

    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    $html = curl_exec($ch);

    curl_close($ch);

    preg_match_all($pattern, $html, $output);

    $movie_id_list = array_unique($output[0]);

    return [
      "status" => "success",
      "movie_id_list" => $movie_id_list
    ];
  }


  function GetOfficialInfo(string $video_id)
  {
    $xml = simplexml_load_file("https://ext.nicovideo.jp/api/getthumbinfo/" . $video_id);

    if ($xml === false) {
      return [
        "status" => "failure",
        "message" => "Failure getting info."
      ];
    }

    // Not Found Video ID
    if (isset($xml->error)) {
      return [
        "status" => "failure",
        "message" => "Not Found or Invalid."
      ];
    }

    return [
      "status" => "success",
      "video_id" => $video_id,
      "title" => (string)$xml->thumb->title,
      "description" => (string)$xml->thumb->description,
      "user_nickname" => (string)$xml->thumb->user_nickname
    ];
  }


  function ReadVideoList(string $mode)
  {
    require __DIR__ . "/../config/config.php";

    // connect MySQL
    $mysqli = new mysqli($hostname, $username, $password, $database);

    if ($mode === 'all') {
      $result = $mysqli->query(
        "
          SELECT
            `niconico_video_titles`.`id`,
            `niconico_video_titles`.`video_id`,
            `niconico_video_titles`.`title`,
            `niconico_video_title_flags`.`favorite`,
            `niconico_video_title_flags`.`skip`
          FROM
            `niconico_video_titles`
              LEFT JOIN `niconico_video_title_flags`
                ON `niconico_video_titles`.`id` = `niconico_video_title_flags`.`title_id`
          ORDER BY `niconico_video_titles`.`id`
          ;
        "
      );
    } else if ($mode === 'favorite') {
      $result = $mysqli->query(
        "
          SELECT
            `niconico_video_titles`.`id`,
            `niconico_video_titles`.`video_id`,
            `niconico_video_titles`.`title`,
            `niconico_video_title_flags`.`favorite`,
            `niconico_video_title_flags`.`skip`
          FROM
            `niconico_video_titles`
              LEFT JOIN `niconico_video_title_flags`
                ON `niconico_video_titles`.`id` = `niconico_video_title_flags`.`title_id`
          WHERE
            `niconico_video_title_flags`.`favorite` = true
          ORDER BY `niconico_video_titles`.`id`
          ;
        "
      );
    } else if ($mode === 'withoutSkip') {
      $result = $mysqli->query(
        "
          SELECT
            `niconico_video_titles`.`id`,
            `niconico_video_titles`.`video_id`,
            `niconico_video_titles`.`title`,
            `niconico_video_title_flags`.`favorite`,
            `niconico_video_title_flags`.`skip`
          FROM
            `niconico_video_titles`
              LEFT JOIN `niconico_video_title_flags`
                ON `niconico_video_titles`.`id` = `niconico_video_title_flags`.`title_id`
          WHERE
            `niconico_video_title_flags`.`skip` = false
            OR `niconico_video_title_flags`.`skip` IS NULL
          ORDER BY `niconico_video_titles`.`id`
          ;
        "
      );
    } else {
      $result = $mysqli->query(
        "
          SELECT
            `niconico_video_titles`.`id`,
            `niconico_video_titles`.`video_id`,
            `niconico_video_titles`.`title`,
            `niconico_video_title_flags`.`favorite`,
            `niconico_video_title_flags`.`skip`
          FROM
            `niconico_video_titles`
              LEFT JOIN `niconico_video_title_flags`
                ON `niconico_video_titles`.`id` = `niconico_video_title_flags`.`title_id`
          ORDER BY `niconico_video_titles`.`id`
          ;
        "
      );
    }

    $video_default_list = $result->fetch_all(MYSQLI_ASSOC);
    $video_list = [];

    // Change Flags
    foreach ($video_default_list as $video) {
      // favorite
      if (intval($video['favorite']) === 1) {
        $video['favorite'] = true;
      } elseif (intval($video['favorite']) === 0) {
        $video['favorite'] = false;
      } else {
        $video['favorite'] = false;
      }

      // skip
      if (intval($video['skip']) === 1) {
        $video['skip'] = true;
      } elseif (intval($video['skip']) === 0) {
        $video['skip'] = false;
      } else {
        $video['skip'] = false;
      }

      array_push($video_list, $video);
    }

    return [
      'status' => 'success',
      'videos' => $video_list
    ];
  }


  function InsertVideo(string $video_id, string $title, $favorite, $skip)
  {
    require __DIR__ . "/../config/config.php";

    // define
    $favorite = $favorite === true ? 1 : 0;
    $skip = $skip === true ? 1 : 0;

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
          "message" => "$video_id is already registered."
        ];
      }
    } elseif (!$result) {
      return [
        "status" => "failure",
        "message" => "Failure registered."
      ];
    }

    // Insert Video
    $result = $mysqli->query(
      "
        INSERT INTO `niconico_video_titles`
          (`video_id`, `title`, `created_at`, `updated_at`)
        VALUES
          ('$video_id', '$title', now(), now())
        ;
      "
    );

    if (!$result) {
      return [
        "status" => "failure",
        "message" => "Failure registered."
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
          `video_id` = '$video_id'
        ;
      "
    );

    if (!$result) {
      return [
        "status" => "failure",
        "message" => "Failure registered."
      ];
    }

    $video_id_result = $result->fetch_all(MYSQLI_ASSOC);
    $video_id = $video_id_result[0]["id"];

    $result = $mysqli->query(
      "
        INSERT INTO `niconico_video_title_flags`
          (`title_id`, `favorite`, `skip`, `created_at`, `updated_at`)
        VALUES
          ($video_id, $favorite, $skip, now(), now())
        ;
      "
    );

    if (!$result) {
      return [
        "status" => "failure",
        "message" => "Failure registered."
      ];
    }

    return [
      "status" => "success"
    ];
  }


  function UpdateVideo(int $id, string $video_id, string $title, $favorite, $skip)
  {
    require __DIR__ . '/../config/config.php';

    // define
    $favorite = $favorite === true ? 1 : 0;
    $skip = $skip === true ? 1 : 0;

    // Connect MySQL
    $mysqli = new mysqli($hostname, $username, $password, $database);

    // Update Video
    $result = $mysqli->query(
      "
        UPDATE
          `niconico_video_titles`
        SET
          `video_id` = '$video_id',
          `title` = '$title',
          `updated_at` = now()
        WHERE
          `id` = $id
        ;
      "
    );

    // Update Flags
    $result = $mysqli->query(
      "
        SELECT
          COUNT(`id`) AS count
        FROM
          `niconico_video_title_flags`
        WHERE
          `title_id` = $id
        ;
      "
    );

    $video_flags_exist = $result->fetch_all(MYSQLI_ASSOC);
    $video_count = $video_flags_exist[0]['count'];

    if (intval($video_count) === 1) {
      $result = $mysqli->query(
        "
          UPDATE
            `niconico_video_title_flags`
          SET
            `favorite` = $favorite,
            `skip` = $skip,
            `updated_at` = now()
          WHERE
            `title_id` = $id
          ;
        "
      );
    } else {
      $result = $mysqli->query(
        "
          INSERT INTO `niconico_video_title_flags`
            (`title_id`, `favorite`, `skip`, `created_at`, `updated_at`)
          VALUES
            ($id, $favorite, $skip, now(), now())
          ;
        "
      );
    }

    if (!$result) {
      return [
        'status' => 'failed',
        'message' => 'Registered failed.'
      ];
    }

    return [
      'status' => 'success'
    ];
  }
}
