<?php

require_once __DIR__ . '/DBBase.php';


class LoggingDB extends DBBase
{
  public function record_log(string $type, string $log): void
  {
    if (!$this->is_exist_logs_table()) {
      $this->create_logs_table();
    }

    $table_name = $this->get_logs_table_name();

    $this->mysqli->query(
      "
        INSERT INTO `$table_name`
          (`type`, `log`, `created_at`, `updated_at`)
        VALUES
          ('$type', '$log', now(), now())
        ;
      "
    );
  }


  private function is_exist_logs_table(): bool
  {
    $table_name = $this->get_logs_table_name();

    $sql_result = $this->mysqli->query("SHOW TABLES LIKE '$table_name'");

    return $sql_result->num_rows !== 0;
  }


  private function create_logs_table(): void
  {
    $table_name = $this->get_logs_table_name();

    $this->mysqli->query(
      "
        CREATE TABLE IF NOT EXISTS `$table_name` (
          `id` int(16) NOT NULL PRIMARY KEY AUTO_INCREMENT,
          `type` varchar(64),
          `log` varchar(256),
          `created_at` datetime NOT NULL,
          `updated_at` datetime NOT NULL
        );
      "
    );
  }


  private function get_logs_table_name(): string
  {
    $today = new DateTime();

    return 'logs_' . $today->format('Y_m');
  }
}
