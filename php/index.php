<?php
require_once __DIR__ . '/model/LineNotify.php';
require_once __DIR__ . '/model/Niconico.php';
require_once __DIR__ . "/model/Todofuken.php";
require_once __DIR__ . "/model/Web.php";
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
    /////
    ///// Get Web Info
    /////
  case "/api/get-web-info":
    $body = json_decode(file_get_contents("php://input"));

    // Validate
    if (!isset($body->url) || $body->url === '') {
      response(
        json_encode(
          [
            "status" => "failure",
            "message" => "ERROR: Param URL is not exist."
          ]
        )
      );

      break;
    }

    // Get Web Info
    $web = new Web();

    $result = $web->get_web_info($body->url);

    if ($result["status"] !== "success") {
      response(
        json_encode(
          [
            "status" => "failure",
            "message" => "ERROR: Failure Get Web Info."
          ]
        )
      );

      break;
    }

    response(
      json_encode(
        [
          "status" => "success",
          "title" => $result["title"]
        ]
      )
    );

    break;


    /////
    ///// Get Todofuken List
    /////
  case "/api/v1/get-todofuken-list":
    $body = json_decode(file_get_contents("php://input"));

    // Validate
    if (!isset($body->num) || $body->num === '') {
      response(
        json_encode(
          [
            "status" => "failure",
            "message" => "ERROR: Param Num is not exist."
          ]
        )
      );

      break;
    }

    // Get Todofuken List
    $todofuken = new Todofuken();

    $result = $todofuken->get_todofuken_list($body->num);

    response(
      json_encode(
        [
          "status" => "success",
          "todofulen_list" => $result
        ]
      )
    );

    break;


    /////
    ///// Get Movie ID List
    /////
  case '/api/niconico/get-movie-id-list':
    $body = json_decode(file_get_contents("php://input"));

    // Validate
    if (!isset($body->accessToken) || $body->accessToken === '') {
      response(
        json_encode(
          [
            'status' => 'failure',
            'message' => 'ERROR: Access Token is not exist.'
          ]
        )
      );

      break;
    } elseif (!isset($body->url) || $body->url === '') {
      response(
        json_encode(
          [
            'status' => 'failure',
            'message' => 'ERROR: URL is not exist.'
          ]
        )
      );

      break;
    }

    // Check Access Token
    $result = json_decode(check_access_token($body->accessToken));

    if ($result->status !== 'success') {
      response(
        json_encode(
          [
            'status' => 'failure',
            'message' => $result->message
          ]
        )
      );

      break;
    }

    // Get Movie ID List
    $line = new LineNotify();
    $niconico = new Niconico();
    $cnt = 0;

    $result = $niconico->get_movie_id_list_from_url($body->url);
    $movie_id_list = $result["movie_id_list"];

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

    response(
      json_encode(
        [
          'status' => 'success',
        ]
      )
    );

    break;


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
