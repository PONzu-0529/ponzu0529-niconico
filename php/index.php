<?php
require_once __DIR__ . '/model/LineNotify.php';
require_once __DIR__ . '/auth.php';
require_once __DIR__ . '/niconico.php';

$path = $_SERVER['REQUEST_URI'];

if ($path === '/api/check-access-token') {
  /////
  ///// Check Access Token
  /////
  $body = json_decode(file_get_contents("php://input"));

  // Check Access Token
  $result = json_decode(check_access_token($body->accessToken));

  if ($result->status === 'success') {
    $response = json_encode([
      'status' => 'success'
    ]);
  } else {
    $response = json_encode([
      'status' => 'failed',
      'message' => $result->message
    ]);
  }

  response($response);

  return;
} elseif ($path === '/api/get-access-token') {
  /////
  ///// Get Access Token
  ////
  $body = json_decode(file_get_contents("php://input"));

  // Get Access Token
  $result = json_decode(get_access_token($body->name, $body->password));

  if ($result->status === 'success') {
    $response =  json_encode([
      'status' => 'success',
      'access_token' => $result->access_token
    ]);
  } else {
    $response = json_encode([
      'status' => 'failed',
      'message' => $result->message
    ]);
  }

  response($response);

  return;
} elseif ($path === '/api/niconico/create-video') {
  /////
  ///// Niconico
  ///// Create Video
  /////
  $body = json_decode(file_get_contents("php://input"));

  // Check Access Token
  $result = json_decode(check_access_token($body->accessToken));

  if ($result->status !== 'success') {
    response(
      json_encode(
        [
          'status' => 'failed',
          'message' => $result->message
        ]
      )
    );

    return;
  }

  // Create Video
  $result = json_decode(
    create_video(
      $body
    )
  );

  if ($result->status !== 'success') {
    response(
      json_encode(
        [
          'status' => 'failed',
          'message' => $result->message
        ]
      )
    );

    return;
  }

  response(
    json_encode(
      [
        'status' => 'success'
      ]
    )
  );

  return;
} elseif ($path === '/api/niconico/get-official-info') {
  /////
  ///// Niconico
  ///// Get Official Info
  /////
  $body = json_decode(file_get_contents("php://input"));

  // Check Access Token
  $result = json_decode(check_access_token($body->accessToken));

  if ($result->status !== 'success') {
    response(
      json_encode(
        [
          'status' => 'failed',
          'message' => $result->message
        ]
      )
    );

    return;
  }

  // Get Official Info
  $result = json_decode(
    get_official_info(
      $body
    )
  );

  if ($result->status !== 'success') {
    response(
      json_encode(
        [
          'status' => 'failed',
          'message' => $result->message
        ]
      )
    );

    return;
  }

  response(
    json_encode(
      [
        'status' => 'success',
        'title' => $result->title
      ]
    )
  );

  return;
} elseif ($path === '/api/niconico/read-all-videos') {
  /////
  ///// Niconico
  ///// Read All Videos
  /////
  $body = json_decode(file_get_contents("php://input"));

  // Check Access Token
  $result = json_decode(check_access_token($body->accessToken));

  if ($result->status !== 'success') {
    response(
      json_encode(
        [
          'status' => 'failed',
          'message' => $result->message
        ]
      )
    );

    return;
  }

  // Read All Videos
  $result = json_decode(
    read_all_videos()
  );

  if ($result->status !== 'success') {
    response(
      json_encode(
        [
          'status' => 'failed',
          'message' => $result->message
        ]
      )
    );

    return;
  }

  response(
    json_encode(
      [
        'status' => 'success',
        'videos' => $result->videos
      ]
    )
  );

  return;
}

switch ($path) {
  case '/api/niconico/read-mylist-videos':
    /////
    ///// Read Mylist Videos
    /////
    $body = json_decode(file_get_contents("php://input"));

    // Check Access Token
    $result = json_decode(check_access_token($body->accessToken));

    if ($result->status !== 'success') {
      response(
        json_encode(
          [
            'status' => 'failed',
            'message' => $result->message
          ]
        )
      );

      break;
    }

    // Read Mylist Videos
    $result = json_decode(
      read_mylist_videos(
        $body
      )
    );

    if ($result->status !== 'success') {
      response(
        json_encode(
          [
            'status' => 'failed',
            'message' => $result->message
          ]
        )
      );

      break;
    }

    response(
      json_encode(
        [
          'status' => 'success',
          'videos' => $result->videos
        ]
      )
    );

    break;


  case '/api/niconico/update-video':
    /////
    ///// Update Video
    /////
    $body = json_decode(file_get_contents("php://input"));

    // Check Access Token
    $result = json_decode(check_access_token($body->accessToken));

    if ($result->status !== 'success') {
      response(
        json_encode(
          [
            'status' => 'failed',
            'message' => $result->message
          ]
        )
      );

      break;
    }

    // Update Video
    $result = json_decode(
      update_video($body)
    );

    if ($result->status !== 'success') {
      response(
        json_encode(
          [
            'status' => 'failed',
            'message' => $result->message
          ]
        )
      );

      break;
    }

    response(
      json_encode(
        [
          'status' => 'success'
        ]
      )
    );

    break;


  case '/api/line-notify':
    /////
    ///// LINE Notify
    /////
    $body = json_decode(file_get_contents("php://input"));

    // Check Access Token
    $result = json_decode(check_access_token($body->accessToken));

    if ($result->status !== 'success') {
      response(
        json_encode(
          [
            'status' => 'failed',
            'message' => $result->message
          ]
        )
      );

      break;
    }

    // LINE Notify
    $line = new LineNotify();

    $result = $line->sned_message($body);

    if ($result !== 'success') {
      response(
        json_encode(
          [
            'status' => 'failed',
            'message' => $result
          ]
        )
      );

      break;
    }

    response(
      json_encode(
        [
          'status' => 'success'
        ]
      )
    );

    break;


  default:
    /////
    ///// HTML
    /////
    header('Content-Type: text/html; charset=utf-8');
    readfile(__DIR__ . '/index.html');
}

function response($response)
{
  // Define
  header("Access-Control-Allow-Origin: *");
  header("Access-Control-Allow-Headers: *");

  echo $response;
}
