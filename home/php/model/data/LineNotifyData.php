<?php

require_once __DIR__ . '/../db/LineNotifyDB.php';


class LineNotifyData
{
  private LineNotifyDB $line_notify_db;
  public array $access_token_list = [];


  public function __construct()
  {
    $this->line_notify_db = new LineNotifyDB();

    $this->access_token_list = [
      'log' => '',
      'alert' => '',
      'error' => '',
      'success' => ''
    ];

    $this->set_all_data();
  }


  private function set_all_data(): void
  {
    $db_data = $this->line_notify_db->get_all_data();

    // Set Data
    foreach ($db_data as $db_column) {
      $db_column_obj = get_object_vars($db_column);

      $db_column_data = new LineNotifyAccessTokens(
        $db_column_obj['id'],
        $db_column_obj['type'],
        $db_column_obj['access_token'],
        $db_column_obj['created_at'],
        $db_column_obj['updated_at'],
      );

      $this->access_token_list[$db_column_data->type] = $db_column_data->access_token;
    }
  }
}
