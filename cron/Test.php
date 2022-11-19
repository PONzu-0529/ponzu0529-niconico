<?php

require_once __DIR__ . '/../home/php/common/ResponseStyle.php';
require_once __DIR__ . '/../home/php/common/LogOptions.php';

require_once __DIR__ . '/../home/php/service/LoggingService.php';
require_once __DIR__ . '/../home/php/service/LineNotifyService.php';

require_once __DIR__ . '/../home/php/test/api/AuthApiTest.php';
require_once __DIR__ . '/../home/php/test/api/LineNotifyApiTest.php';
require_once __DIR__ . '/../home/php/test/api/VocaloidMusicApiTest.php';

require_once __DIR__ . '/../home/php/test/service/AuthServiceTest.php';
require_once __DIR__ . '/../home/php/test/service/LineNotifyServiceTest.php';
require_once __DIR__ . '/../home/php/test/service/LoggingServiceTest.php';
require_once __DIR__ . '/../home/php/test/service/VocaloidMusicServiceTest.php';


function check_test_result(ResponseStyle $test_result)
{
  $SERVICE_NAME = 'RegressionTest';

  $logging_service = new LoggingService();
  $line_notify_service = new LInenotifyservice();

  if ($test_result->get_status() !== ResponseStatusOption::SUCCESS) {
    $logging_service->record_log(new LogStyle(
      $SERVICE_NAME,
      LogTypeOption::ERROR,
      strval($test_result->get_data())
    ));

    $line_notify_service->send_alert_message(
      "$SERVICE_NAME Failure: " . strval($test_result->get_data())
    );
  }
}


// LoggingService
$logging_service_test = new LoggingServiceTest();
check_test_result($logging_service_test->record_log_test());

// LineNotifyService
$line_notify_service_test = new LineNotifyServiceTest();
check_test_result($line_notify_service_test->send_log_message());
// check_test_result($line_notify_service_test->send_alert_message());
// check_test_result($line_notify_service_test->send_error_message());
// check_test_result($line_notify_service_test->send_success_message());

// LineNotify API
$line_notify_api_test = new LineNotifyApiTest();
check_test_result($line_notify_api_test->send_log_message());
// check_test_result($line_notify_api_test->send_different_host_log_message()); // Only Local to Server
check_test_result($line_notify_api_test->send_different_version_log_message());

// Auth
$auth_service_test = new AuthServiceTest();
// check_test_result($auth_service_test->get_access_token_by_email());
check_test_result($auth_service_test->get_access_token_by_dummy_email());
check_test_result($auth_service_test->get_access_token_by_dummy_password());
// check_test_result($auth_service_test->check_access_token());
check_test_result($auth_service_test->check_dummy_access_token());
check_test_result($auth_service_test->check_old_access_token());
// check_test_result($auth_service_test->check_access_token_by_email());
// check_test_result($auth_service_test->check_access_token_by_dummy_email());
// check_test_result($auth_service_test->check_dummy_access_token_by_email());
// check_test_result($auth_service_test->check_old_access_token_by_email());
// check_test_result(AuthApiTest::GetAccessTokenByEmail());
// check_test_result(AuthApiTest::CheckAccessToken());
// check_test_result(AuthApiTest::CheckAccessTokenByEmail());

// VocaloidMusicService
$vocaloid_music_service_test = new VocaloidMusicServiceTest();
check_test_result($vocaloid_music_service_test->get_all_data());
check_test_result($vocaloid_music_service_test->get_data_without_skip());
check_test_result(VocaloidMusicApiTest::get_music_list());
check_test_result(VocaloidMusicApiTest::get_data_without_skip());
check_test_result(VocaloidMusicApiTest::insert_music());
// check_test_result(VocaloidMusicApiTest::update_music());
// check_test_result(VocaloidMusicApiTest::delete_music());
