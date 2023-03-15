<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateIpAddressesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement('
            DROP TABLE IF EXISTS `ip_addresses`;
        ');
        DB::statement('
            CREATE TABLE IF NOT EXISTS `ip_addresses` (
                `id` int(16) NOT NULL PRIMARY KEY AUTO_INCREMENT,
                `ip_address` varchar(64) NOT NULL,
                `memo` varchar(64),
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
            DROP TABLE IF EXISTS `ip_addresses`;
        ');
    }
}
