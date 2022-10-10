<?php

class Trello
{
  public function get_board_id($board_name)
  {
    require __DIR__ . "/../vendor/autoload.php";
    require __DIR__ . "/../config/config.php";

    $headers = array(
      "Accept" => "application/json"
    );

    $query = array(
      "key" => $trello_key,
      "token" => $trello_token
    );

    $response = Unirest\Request::get(
      "https://api.trello.com/1/members/$trello_id/boards",
      $headers,
      $query
    );

    $board_id = "";

    foreach ($response->body as $board_info) {
      if ($board_info->name === $board_name) {
        $board_id = $board_info->id;
      }
    }

    if ($board_id === "") {
      return json_encode(
        [
          "status" => "failure",
          "message" => "ERROR: $board_name is not defined."
        ]
      );
    }

    return json_encode(
      [
        "status" => "success",
        "boardId" => $board_id
      ]
    );
  }


  public function get_list_id($board_name, $list_name)
  {
    require __DIR__ . "/../vendor/autoload.php";
    require __DIR__ . "/../config/config.php";

    $response = $this->get_board_id($board_name);
    $result = json_decode($response);

    if ($result->status !== "success") {
      return json_encode(
        [
          "status" => "failure",
          "message" => $result->message
        ]
      );
    }

    $board_id = $result->boardId;

    $headers = array(
      "Accept" => "application/json"
    );

    $query = array(
      "key" => $trello_key,
      "token" => $trello_token
    );

    $response = Unirest\Request::get(
      "https://api.trello.com/1/boards/$board_id/lists",
      $headers,
      $query
    );

    $list_id = "";

    foreach ($response->body as $list_info) {
      if ($list_info->name === $list_name) {
        $list_id = $list_info->id;
      }
    }

    if ($list_id === "") {
      return json_encode(
        [
          "status" => "failure",
          "message" => "ERROR: $list_name is not defined."
        ]
      );
    }

    return json_encode(
      [
        "status" => "success",
        "listId" => $list_id
      ]
    );
  }


  public function get_card_id_list($board_name, $list_name)
  {
    require __DIR__ . "/../vendor/autoload.php";
    require __DIR__ . "/../config/config.php";

    $response = $this->get_list_id($board_name, $list_name);
    $result = json_decode($response);

    if ($result->status !== "success") {
      return json_encode(
        [
          "status" => "failure",
          "message" => $result->message
        ]
      );
    }

    $list_id = $result->listId;

    $headers = array(
      "Accept" => "application/json"
    );

    $query = array(
      "key" => $trello_key,
      "token" => $trello_token
    );

    $response = Unirest\Request::get(
      "https://api.trello.com/1/lists/$list_id/cards",
      $headers,
      $query
    );

    $card_id_list = [];

    foreach ($response->body as $card_info) {
      array_push($card_id_list, $card_info->id);
    }

    return json_encode(
      [
        "status" => "success",
        "cardIdList" => $card_id_list
      ]
    );
  }


  public function get_card_limit_result($card_id)
  {
    require __DIR__ . "/../vendor/autoload.php";
    require __DIR__ . "/../config/config.php";

    $headers = array(
      "Accept" => "application/json"
    );

    $query = array(
      "key" => $trello_key,
      "token" => $trello_token
    );

    $response = Unirest\Request::get(
      "https://api.trello.com/1/cards/$card_id",
      $headers,
      $query
    );

    if ($response->code === 400) {
      return json_encode(
        [
          "status" => "failure",
          "message" => "ERROR: Failure Trello Get API."
        ]
      );
    }

    $card_info = $response->body;

    if ($card_info->due !== null && strtotime(date("Y-m-d H:i:s")) > strtotime($card_info->due)) {
      return json_encode(
        [
          "status" => "success",
          "cardStatus" => "out",
          "cardName" => $card_info->name,
          "cardDesc" => $card_info->desc
        ],
        JSON_UNESCAPED_UNICODE
      );
    } else {
      return json_encode(
        [
          "status" => "success",
          "cardStatus" => "safe"
        ]
      );
    }
  }
}
