<?php

require_once __DIR__ . '/EnvConstants.php';
require_once __DIR__ . '/ResponseStyle.php';


class Utils
{
  public static function get_environment(): string
  {
    require __DIR__ . '/../config/Config.php';

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


  public static function change_camel_case(string $str): string
  {
    $str = strtr($str, ["-" => " ", "_" => " "]);
    $str = ucwords($str);
    $str = strtr($str, [" " => ""]);
  
    return $str;
  }


  public static function compare_response_style(
    ResponseStyle $response_style_1,
    ResponseStyle $response_style_2
  ): ResponseStyle {
    if ($response_style_1->get_status() !== $response_style_2->get_status()) {
      return new ResponseStyle(
        ResponseStatusOption::FAILURE,
        'Response Status "' . $response_style_1->get_status() . '" is not "' . $response_style_2->get_status() . '".'
      );
    }

    if ($response_style_1->get_data() !== $response_style_2->get_data()) {
      return new ResponseStyle(
        ResponseStatusOption::FAILURE,
        'Response Data "' . strval($response_style_1->get_data()) . '" is not "' . strval($response_style_2->get_data()) . '".'
      );
    }

    return new ResponseStyle(
      ResponseStatusOption::SUCCESS,
      'Each Response Style is Equal.'
    );
  }
}
