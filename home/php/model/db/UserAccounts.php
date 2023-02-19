<?php

require_once __DIR__ . '/DBBase.php';


class UserAccounts extends DBBase
{
  public function get_id_by_user_name(string $user_name): int
  {
    $sql_result = $this->mysqli->query(
      "
        SELECT
          id
        FROM
          user_accounts
        WHERE
          name = '$user_name'
        ;
      "
    );

    $db_result = $sql_result->fetch_assoc();

    if (isset($db_result)) {
      return intval($db_result["id"]);
    } else {
      return -1;
    }
  }


  public function get_id_by_email(string $email): int
  {
    $sql_result = $this->mysqli->query(
      "
        SELECT
          id
        FROM
          user_accounts
        WHERE
          email = '$email'
        ;
      "
    );

    $db_result = $sql_result->fetch_assoc();

    if (isset($db_result)) {
      return intval($db_result["id"]);
    } else {
      return -1;
    }
  }


  public function get_password_hash_by_id(int $id): string
  {
    $sql_result = $this->mysqli->query(
      "
        SELECT
          password_hash
        FROM
          user_accounts
        WHERE
          id = '$id'
        ;
      "
    );

    $db_result = $sql_result->fetch_assoc();

    if (isset($db_result)) {
      return $db_result["password_hash"];
    } else {
      return '';
    }
  }


  public function insert_user(string $user_name, string $email, string $password_hash): void
  {
    $this->mysqli->query(
      "
        INSERT INTO `user_accounts`
          (`name`, `email`, `password_hash`, `created_at`, `updated_at`)
        VALUES
          ('$user_name', '$email', '$password_hash', now(), now())
        ;
      "
    );
  }


  public function update_name_by_id(int $id, string $user_name): void
  {
    $this->mysqli->query(
      "
        UPDATE
          `user_accounts`
        SET
          `name` = '$user_name',
          `updated_at` = now()
        WHERE
          `id` = $id
        ;
      "
    );
  }


  public function update_password_hash_by_id(int $id, string $password_hash): void
  {
    $this->mysqli->query(
      "
        UPDATE
          `user_accounts`
        SET
          `password_hash` = '$password_hash',
          `updated_at` = now()
        WHERE
          `id` = $id
        ;
      "
    );
  }


  public function delete_user_by_id(int $id): void
  {
    $this->mysqli->query(
      "
        DELETE FROM
          `user_accounts`
        WHERE
          `id` = $id
      "
    );
  }
}
