ROOT=$1
PRIVATE_HOME=$2

COMMAND='git pull' && OUTPUT=`cd $ROOT && $COMMAND` && /usr/bin/php7.4 $ROOT/cron/commandLog.php "$COMMAND" "$OUTPUT"
COMMAND="/usr/bin/php7.4 $PRIVATE_HOME/bin/composer install" && OUTPUT=`cd $ROOT && $COMMAND` && /usr/bin/php7.4 $ROOT/cron/commandLog.php "$COMMAND" "$OUTPUT"
COMMAND="$PRIVATE_HOME/.nodebrew/current/bin/node $PRIVATE_HOME/.nodebrew/current/bin/yarn" && OUTPUT=`cd $ROOT && $COMMAND` && /usr/bin/php7.4 $ROOT/cron/commandLog.php "$COMMAND" "$OUTPUT"
COMMAND='/usr/bin/php7.4 artisan migrate' && OUTPUT=`cd $ROOT && $COMMAND` && /usr/bin/php7.4 $ROOT/cron/commandLog.php "$COMMAND" "$OUTPUT"
COMMAND="$PRIVATE_HOME/.nodebrew/current/bin/node $PRIVATE_HOME/.nodebrew/current/bin/yarn build-full" && OUTPUT=`cd $ROOT && $COMMAND` && /usr/bin/php7.4 $ROOT/cron/commandLog.php "$COMMAND" "$OUTPUT"