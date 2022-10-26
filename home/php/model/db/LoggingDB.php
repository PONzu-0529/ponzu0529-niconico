<?php

require_once __DIR__ . '/DBBase.php';
require_once __DIR__ . '/../../common/LogOptions.php';


class LoggingDB extends DBBase
{
  public function record_log(LogStyle $log_style): void
  {
    if (!$this->is_exist_logs_table()) {
      $this->create_logs_table();
    }

    $table_name = $this->get_logs_table_name();

    $debug_info = debug_backtrace();
    $last_debug_info = end($debug_info);
    $file_name = $last_debug_info['file'];
    $function_name = $last_debug_info['function'];

    $this->mysqli->query(
      "
        INSERT INTO `$table_name`
          (`service`, `type`, `file_name`, `function_name`, `log`, `created_at`, `updated_at`)
        VALUES
          ('$log_style->service', '$log_style->type', '$file_name', '$function_name', '$log_style->log', now(), now())
        ;
      "
    );
  }


  public static function record(LogStyle $log_style): void
  {
    $mysqli = DBBase::get_db_connection();

    if (!static::is_exist_logs_table()) {
      static::create_logs_table();
    }

    $table_name = static::get_logs_table_name();

    $debug_info = debug_backtrace();
    $last_debug_info = end($debug_info);
    $file_name = $last_debug_info['file'];
    $function_name = $last_debug_info['function'];

    $mysqli->query(
      "
        INSERT INTO `$table_name`
          (`service`, `type`, `file_name`, `function_name`, `log`, `created_at`, `updated_at`)
        VALUES
          ('$log_style->service', '$log_style->type', '$file_name', '$function_name', '$log_style->log', now(), now())
        ;
      "
    );
  }


  private static function is_exist_logs_table(): bool
  {
    $mysqli = DBBase::get_db_connection();

    $table_name = static::get_logs_table_name();

    $sql_result = $mysqli->query("SHOW TABLES LIKE '$table_name'");

    return $sql_result->num_rows !== 0;
  }


  private static function create_logs_table(): void
  {
    $mysqli = DBBase::get_db_connection();

    $table_name = static::get_logs_table_name();

    $mysqli->query(
      "
        CREATE TABLE IF NOT EXISTS `$table_name` (
          `id` int(16) NOT NULL PRIMARY KEY AUTO_INCREMENT,
          `service` varchar(64),
          `type` varchar(64),
          `file_name` varchar(64),
          `function_name` varchar(64),
          `log` varchar(256),
          `created_at` datetime NOT NULL,
          `updated_at` datetime NOT NULL
        );
      "
    );
  }


  private static function get_logs_table_name(): string
  {
    $today = new DateTime();

    return 'logs_' . $today->format('Y_m');
  }
}
