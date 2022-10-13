<?php

require_once __DIR__ . '/DBBase.php';


class LineNotifyDB extends DBBase
{
  public function get_all_data(): array
  {
    $data = [];

    $result = $this->mysqli->query(
      "
        SELECT
          *
        FROM
          `line_notify_access_tokens`
        ;
      "
    );

    $result_list = $result->fetch_all(MYSQLI_ASSOC);

    // Set Data
    foreach ($result_list as $line_notify) {
      array_push(
        $data,
        new LineNotifyAccessTokens(
          intval($line_notify['id']),
          $line_notify['type'],
          $line_notify['access_token'],
          new DateTime($line_notify['created_at']),
          new DateTime($line_notify['updated_at'])
        )
      );
    }

    return $data;
  }
}


class LineNotifyAccessTokens
{
  public int $id;
  public string $type;
  public string $access_token;
  public DateTime $created_at;
  public DateTime $updated_at;


  public function __construct(
    int $id,
    string $type,
    string $access_token,
    DateTime $created_at,
    DateTime $updated_at
  ) {
    $this->id = $id;
    $this->type = $type;
    $this->access_token = $access_token;
    $this->created_at = $created_at;
    $this->updated_at = $updated_at;
  }
}
