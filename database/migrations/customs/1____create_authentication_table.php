<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAuthenticationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement('
            DROP TABLE IF EXISTS `authentication`;
        ');
        DB::statement('
            CREATE TABLE IF NOT EXISTS `authentication` (
                `id` int(16) NOT NULL PRIMARY KEY AUTO_INCREMENT,
                `user_id` int(16) NOT NULL,
                `function_id` varchar(64) NOT NULL,
                `authentication_level` varchar(64) NOT NULL,
                `created_at` timestamp NULL DEFAULT NULL,
                `updated_at` timestamp NULL DEFAULT NULL,
                `deleted_at` timestamp NULL DEFAULT NULL
            );
        ');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement('
            DROP TABLE IF EXISTS `authentication`;
        ');
    }
}
