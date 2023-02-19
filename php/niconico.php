<?php

function get_official_info($info)
{
  // Check Validation
  if (!isset($info->videoId) || $info->videoId === '') {
    return json_encode(
      [
        'status' => 'failed',
        'message' => 'videoId is empty.'
      ]
    );
  }

  // get Official Information
  $xml = simplexml_load_file("https://ext.nicovideo.jp/api/getthumbinfo/" . $info->videoId);

  if ($xml === false) {
    return json_encode(
      [
        'status' => 'failed',
        'message' => 'Getting Info failed.'
      ]
    );
  }

  return json_encode(
    [
      'status' => 'success',
      'title' => $xml->thumb->title
    ]
  );
}

/////
///// Read All Videos
/////
function read_all_videos()
{
  require __DIR__ . '/config/config.php';

  // Connect MySQL
  $mysqli = new mysqli($hostname, $username, $password, $database);

  // Read All Video
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

  return json_encode([
    'status' => 'success',
    'videos' => $video_list
  ]);
}

/////
///// Create Video
/////
function create_video($info)
{
  require __DIR__ . '/config/config.php';

  // Check Validation
  if (!isset($info->videoId) || $info->videoId === '') {
    return json_encode(
      [
        'status' => 'failed',
        'message' => 'VideoId is not exist.'
      ]
    );
  } elseif (!isset($info->title) || $info->title === '') {
    return json_encode(
      [
        'status' => 'failed',
        'message' => 'Title is not exist.'
      ]
    );
  } elseif (!isset($info->favorite)) {
    return json_encode(
      [
        'status' => 'failed',
        'message' => 'Favorite Flg is not exist.'
      ]
    );
  } elseif (!isset($info->skip)) {
    return json_encode(
      [
        'status' => 'failed',
        'message' => 'Skip Flg is not exist.'
      ]
    );
  }

  // Connect MySQL
  $mysqli = new mysqli($hostname, $username, $password, $database);

  // Check Registered
  $result = $mysqli->query(
    "SELECT `video_id` FROM niconico_video_titles;"
  );

  if (gettype($result) !== 'boolean') {
    $result_array = $result->fetch_all(MYSQLI_NUM);

    if (in_array([$info->videoId], $result_array)) {
      return json_encode([
        'status' => 'failed',
        'message' => $info->videoId . ' is already registered.'
      ]);
    }
  } elseif (!$result) {
    return json_encode([
      'status' => 'failed',
      'message' => 'Registered failed.'
    ]);
  }

  // Insert Video
  $result = $mysqli->query(
    "INSERT INTO `niconico_video_titles` (`video_id`, `title`, `created_at`, `updated_at`) VALUES ('" . $info->videoId . "', '" . $info->title . "', now(), now());"
  );

  if (!$result) {
    return json_encode([
      'status' => 'failed',
      'message' => 'Registered failed.'
    ]);
  }

  // Insert Flags
  $result = $mysqli->query(
    "
      SELECT
        `id`
      FROM
        `niconico_video_titles`
      WHERE
        `video_id` = '" . $info->videoId . "'
      ;
    "
  );

  if (!$result) {
    return json_encode([
      'status' => 'failed',
      'message' => 'Registered failed.'
    ]);
  }

  $video_id_result = $result->fetch_all(MYSQLI_ASSOC);
  $video_id = $video_id_result[0]['id'];

  $result = $mysqli->query(
    "
      INSERT INTO `niconico_video_title_flags`
        (`title_id`, `favorite`, `skip`, `created_at`, `updated_at`)
      VALUES
        (" . $video_id . ", " . ($info->favorite ? 1 : 0) . ", " . ($info->skip ? 1 : 0) . ", now(), now())
      ;
    "
  );

  if (!$result) {
    return json_encode([
      'status' => 'failed',
      'message' => 'Registered failed.'
    ]);
  }

  return json_encode([
    'status' => 'success'
  ]);
}

/////
///// Read Mylist Videos
/////
function read_mylist_videos($info)
{
  require __DIR__ . '/config/config.php';

  // Define
  $MAX_VIDEO_NUM = 100;

  // Connect MySQL
  $mysqli = new mysqli($hostname, $username, $password, $database);

  // Read Mylist Videos
  if (isset($info->favorite)) {
    $result = $mysqli->query(
      "
        SELECT
          `video_id`
        FROM
          `niconico_video_titles`
            LEFT JOIN `niconico_video_title_flags`
              ON `niconico_video_titles`.`id` = `niconico_video_title_flags`.`title_id`
        WHERE
          `niconico_video_title_flags`.`favorite` = true
        ;
      "
    );
  } elseif (isset($info->skip)) {
    $result = $mysqli->query(
      "
        SELECT
          `video_id`
        FROM
          `niconico_video_titles`
            LEFT JOIN `niconico_video_title_flags`
              ON `niconico_video_titles`.`id` = `niconico_video_title_flags`.`title_id`
        WHERE
          `niconico_video_title_flags`.`skip` = false
          OR `niconico_video_title_flags`.`skip` IS NULL
      "
    );
  } else {
    $result = $mysqli->query(
      "SELECT `video_id` FROM niconico_video_titles;"
    );
  }

  $video_list = $result->fetch_all(MYSQLI_NUM);

  // Fix
  $video_id_list = [];

  if (count($video_list) > $MAX_VIDEO_NUM) {
    while (count($video_id_list) < $MAX_VIDEO_NUM) {
      $video_id = $video_list[mt_rand(0, (count($video_list) - 1))][0];

      if (!in_array($video_id, $video_id_list)) {
        array_push($video_id_list, $video_id);
      }
    }
  } else {
    foreach ($video_list as $video) {
      $video_id = $video[0];

      array_push($video_id_list, $video_id);
    }
  }

  return json_encode([
    'status' => 'success',
    'videos' => $video_id_list
  ]);
}

/////
///// Update Video
/////
function update_video($info)
{
  require __DIR__ . '/config/config.php';

  // Check Validation
  if (!isset($info->id) || $info->id === '') {
    return json_encode(
      [
        'status' => 'failed',
        'message' => 'ID is not exist.'
      ]
    );
  } elseif (!isset($info->videoId) || $info->videoId === '') {
    return json_encode(
      [
        'status' => 'failed',
        'message' => 'VideoId is not exist.'
      ]
    );
  } elseif (!isset($info->title) || $info->title === '') {
    return json_encode(
      [
        'status' => 'failed',
        'message' => 'Title is not exist.'
      ]
    );
  } elseif (!isset($info->favorite)) {
    return json_encode(
      [
        'status' => 'failed',
        'message' => 'Favorite Flg is not exist.'
      ]
    );
  } elseif (!isset($info->skip)) {
    return json_encode(
      [
        'status' => 'failed',
        'message' => 'Skip Flg is not exist.'
      ]
    );
  }

  // Connect MySQL
  $mysqli = new mysqli($hostname, $username, $password, $database);

  // Update Video
  $result = $mysqli->query(
    "
    UPDATE
      `niconico_video_titles`
    SET
      `video_id` = '" . $info->videoId . "',
      `title` = '" . $info->title . "',
      `updated_at` = now()
    WHERE
      `id` = " . $info->id . "
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
        `title_id` = " . $info->id . "
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
          `favorite` = " . ($info->favorite ? 1 : 0) . ",
          `skip` = " . ($info->skip ? 1 : 0) . ",
          `updated_at` = now()
        WHERE
          `title_id` = " . $info->id . "
        ;
      "
    );
  } else {
    $result = $mysqli->query(
      "
        INSERT INTO `niconico_video_title_flags`
          (`title_id`, `favorite`, `skip`, `created_at`, `updated_at`)
        VALUES
          (" . $info->id . ", " . ($info->favorite ? 1 : 0) . ", " . ($info->skip ? 1 : 0) . ", now(), now())
        ;
      "
    );
  }

  if (!$result) {
    return json_encode([
      'status' => 'failed',
      'message' => 'Registered failed.'
    ]);
  }

  return json_encode([
    'status' => 'success'
  ]);
}
