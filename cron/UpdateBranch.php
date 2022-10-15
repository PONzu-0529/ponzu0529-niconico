<?php

require_once __DIR__ . '/config/Config.php';
require_once __DIR__ . '/../home/php/model/db/LoggingDB.php'; // LogOption
require_once __DIR__ . '/../home/php/service/LineNotifyService.php';
require_once __DIR__ . '/../home/php/service/LoggingService.php';

$logging_service = new LoggingService();
$line_notify_service = new LineNotifyService();

$logging_service->record_log(new LogOption('cron', 'log', "Start Update $REPOSITORY_NAME."));

exec("
  cd $BRANCH_ROOT && \
  git pull && \
  cp -r home/. ../../public_html/$DIR_NAME/
");

$line_notify_service->send_log_message("Update Branch '$REPOSITORY_NAME.'");
$logging_service->record_log(new LogOption('cron', 'log', "Finish Update $REPOSITORY_NAME."));
