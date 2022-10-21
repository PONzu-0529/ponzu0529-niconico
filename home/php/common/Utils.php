<?php

require_once __DIR__ . '/EnvConstants.php';


class Utils
{
  public static function get_environment(): string
  {
    require_once __DIR__ . '/../config/Config.php';

    $env_username = exec('echo $USERNAME');

    if (mb_strlen($env_username) > 0) {
      return EnvConstants::LOCAL;
    }

    $branch_name = substr(exec("cd $BRANCH_ROOT && git branch --contains"), 2);

    switch ($branch_name) {
      case EnvConstants::MASTER:
      case EnvConstants::DEVELOP:
        return $branch_name;

      default:
        return '';
    }
  }
}
