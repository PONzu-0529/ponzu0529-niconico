<?php

namespace App\Services;

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\Log;
use App\Objects\Log\LoggingObject;

class LogService
{
    /**
     * Log
     *
     * @param LoggingObject $loggingObject Logging Object
     * @return void
     */
    public function Log(LoggingObject $loggingObject): void
    {
        $tableName = 'logs_' . date('Y') . '_' . date('m');

        $this->createTable($tableName);

        $logModel = new Log();
        $logModel->setTableName($tableName);

        $logModel['type'] = $loggingObject->getType();
        $logModel['message'] = $loggingObject->getMessage();
        $logModel['file'] = $loggingObject->getFile();
        $logModel['stacktrace'] = $loggingObject->getTrace();

        $logModel->save();
    }

    /**
     * Create Log Table
     *
     * @param string $tableName TableName
     * @return void
     */
    private function createTable(string $tableName): void
    {
        if (!Schema::hasTable($tableName)) {
            Schema::create($tableName, function (Blueprint $table) {
                $table->id();
                $table->string('type');
                $table->string('message');
                $table->string('file');
                $table->text('stacktrace');
                $table->timestamps();
                $table->softDeletes();
            });
        }
    }
}
