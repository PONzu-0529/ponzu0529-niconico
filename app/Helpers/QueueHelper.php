<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Queue;

class QueueHelper
{
    /**
     * Wait Time
     *
     * @var integer
     */
    private static $WAIT_TIME = 10;

    /**
     * Wait for the Queue to Complete
     *
     * @param string $queueName Queue Name
     * @return void
     */
    public static function waitQueue(string $queueName)
    {
        while (true) {
            if (Queue::size($queueName) === 0) {
                break;
            }

            sleep(QueueHelper::$WAIT_TIME);
        }
    }
}
