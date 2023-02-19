<?php

require __DIR__ . "/../vendor/autoload.php";
require __DIR__ . "/../model/LineNotify.php";
require __DIR__ . "/../model/Trello.php";


$trello = new Trello();
$line = new LineNotify();

$response = $trello->get_card_id_list("個人", "ToDo");
$result = json_decode($response);
$card_id_list = $result->cardIdList;

$card_name_list = [];

foreach ($card_id_list as $card_id) {
  $response = $trello->get_card_limit_result($card_id);

  $result = json_decode($response);

  if ($result->status === "success" && $result->cardStatus === "out") {
    array_push($card_name_list, "・$result->cardName");
  }
}

if (count($card_name_list) > 0) {
  $result = $line->sned_message(
    json_decode(
      json_encode([
        "type" => "alert",
        "message" => "Not Completed!!!\n" . implode(
          "\n",
          $card_name_list
        )
      ])
    )
  );
}
