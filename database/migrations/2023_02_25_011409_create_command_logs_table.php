<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Constants\CommandLogConstant;

class CreateCommandLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('command_logs', function (Blueprint $table) {
            $table->id();
            $table->string(CommandLogConstant::COMMAND);
            $table->text(CommandLogConstant::OUTPUT);
            $table->timestamps();

            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('command_logs');
    }
}
