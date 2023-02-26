ROOT=$1

COMMAND='git pull' && OUTPUT=`cd $ROOT && $COMMAND` && php $ROOT/cron/commandLog.php "$COMMAND" "$OUTPUT"
COMMAND='composer install' && OUTPUT=`cd $ROOT && $COMMAND` && php $ROOT/cron/commandLog.php "$COMMAND" "$OUTPUT"
COMMAND='yarn' && OUTPUT=`cd $ROOT && $COMMAND` && php $ROOT/cron/commandLog.php "$COMMAND" "$OUTPUT"
COMMAND='php artisan key:generate' && OUTPUT=`cd $ROOT && $COMMAND` && php $ROOT/cron/commandLog.php "$COMMAND" "$OUTPUT"
COMMAND='php artisan migrate' && OUTPUT=`cd $ROOT && $COMMAND` && php $ROOT/cron/commandLog.php "$COMMAND" "$OUTPUT"
COMMAND='php artisan db:seed' && OUTPUT=`cd $ROOT && $COMMAND` && php $ROOT/cron/commandLog.php "$COMMAND" "$OUTPUT"
COMMAND='yarn build-full' && OUTPUT=`cd $ROOT && $COMMAND` && php $ROOT/cron/commandLog.php "$COMMAND" "$OUTPUT"
