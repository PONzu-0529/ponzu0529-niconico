<?php

require_once __DIR__ . '/../home/php/common/EnvConstants.php';
require_once __DIR__ . '/../home/php/common/Utils.php';
require_once __DIR__ . '/../home/php/config/Config.php';
require_once __DIR__ . '/../home/php/service/LineNotifyService.php';
require_once __DIR__ . '/../home/php/service/LoggingService.php';

$line_notify_service = new LineNotifyService();

$SERVICE_NAME = 'Cron';

LoggingService::record($SERVICE_NAME, "Start Update $REPOSITORY_NAME.");

$env = Utils::get_environment();

$command = '';
$command .= $env === EnvConstants::DEVELOP ? "cd $BRANCH_ROOT && " : '';
$command .= 'git pull';
$command .= $env === EnvConstants::DEVELOP ? " && rm -Rf ../../public_html/$DIR_NAME/* && cp -r home/. ../../public_html/$DIR_NAME/" : '';

exec($command);

if (Utils::get_environment() === EnvConstants::DEVELOP) {
  $line_notify_service->send_log_message("Update Branch '$REPOSITORY_NAME'.");
}

LoggingService::record($SERVICE_NAME, "Finish Update $REPOSITORY_NAME.");
