<?php

require_once __DIR__ . '/ServiceTestBase.php';

require_once __DIR__ . '/../../common/LogOptions.php';
require_once __DIR__ . '/../../common/ResponseStyle.php';

require_once __DIR__ . '/../../service/LoggingService.php';


class LoggingServiceTest extends ServiceTestBase
{
  const SERVICE_NAME = 'LoggingServiceTest';


  public function record_log_test(): ResponseStyle
  {
    $this->logging_service->record_log(new LogStyle(
      $this::SERVICE_NAME,
      LogTypeOption::LOG,
      'Record Log Test.'
    ));

    return new ResponseStyle(
      ResponseStatusOption::SUCCESS
    );
  }
}
