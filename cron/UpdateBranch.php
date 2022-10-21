<?php

require_once __DIR__ . '/../home/php/common/EnvConstants.php';
require_once __DIR__ . '/../home/php/common/LogOptions.php';
require_once __DIR__ . '/../home/php/common/Utils.php';
require_once __DIR__ . '/../home/php/config/Config.php';
require_once __DIR__ . '/../home/php/service/LineNotifyService.php';
require_once __DIR__ . '/../home/php/service/LoggingService.php';

$logging_service = new LoggingService();
$line_notify_service = new LineNotifyService();

$SERVICE_NAME = 'Cron';

$logging_service->record_log(new LogStyle(
  $SERVICE_NAME,
  LogTypeOption::LOG,
  'update_branch',
  "Start Update $REPOSITORY_NAME."
));

$env = Utils::get_environment();

$command = '';
$command .= $env === EnvConstants::DEVELOP ? "cd $BRANCH_ROOT && " : '';
$command .= 'git pull';
$command .= $env === EnvConstants::DEVELOP ? " && rm -Rf ../../public_html/$DIR_NAME/. && cp -r home/. ../../public_html/$DIR_NAME/" : '';

exec($command);

if (Utils::get_environment() === EnvConstants::DEVELOP) {
  $line_notify_service->send_log_message("Update Branch '$REPOSITORY_NAME.'");
}

$logging_service->record_log(new LogStyle(
  $SERVICE_NAME,
  LogTypeOption::LOG,
  'update_branch',
  "Finish Update $REPOSITORY_NAME."
));
