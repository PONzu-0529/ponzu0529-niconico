ROOT=$1

COMMAND='git pull' && OUTPUT=`cd $ROOT && $COMMAND` && /usr/bin/php7.4 $ROOT/cron/commandLog.php "$COMMAND" "$OUTPUT"
COMMAND='composer install' && OUTPUT=`cd $ROOT && $COMMAND` && /usr/bin/php7.4 $ROOT/cron/commandLog.php "$COMMAND" "$OUTPUT"
COMMAND='yarn' && OUTPUT=`cd $ROOT && $COMMAND` && /usr/bin/php7.4 $ROOT/cron/commandLog.php "$COMMAND" "$OUTPUT"
COMMAND='/usr/bin/php7.4 artisan key:generate' && OUTPUT=`cd $ROOT && $COMMAND` && /usr/bin/php7.4 $ROOT/cron/commandLog.php "$COMMAND" "$OUTPUT"
COMMAND='/usr/bin/php7.4 artisan migrate' && OUTPUT=`cd $ROOT && $COMMAND` && /usr/bin/php7.4 $ROOT/cron/commandLog.php "$COMMAND" "$OUTPUT"
COMMAND='/usr/bin/php7.4 artisan db:seed' && OUTPUT=`cd $ROOT && $COMMAND` && /usr/bin/php7.4 $ROOT/cron/commandLog.php "$COMMAND" "$OUTPUT"
COMMAND='yarn build-full' && OUTPUT=`cd $ROOT && $COMMAND` && /usr/bin/php7.4 $ROOT/cron/commandLog.php "$COMMAND" "$OUTPUT"
