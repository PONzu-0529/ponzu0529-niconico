<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserMusicView extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement('
            DROP VIEW IF EXISTS `user_music_view`;
        ');
        DB::statement('
            CREATE VIEW `user_music_view` AS
            SELECT
                `musics`.`id` as `music_id`,
                `musics`.`title`,
                `musics`.`niconico_id`,
                `users`.`id` as `user_id`,
                ifnull(`user_music`.`favorite`, false) as `favorite`,
                ifnull(`user_music`.`skip`, false) as `skip`
            FROM
                `musics`
                CROSS JOIN `users`
                LEFT JOIN `user_music` ON `users`.`id` = `user_music`.`user_id`
                AND `musics`.`id` = `user_music`.`music_id`
                AND `user_music`.`deleted_at` IS NULL
            WHERE
                `musics`.`deleted_at` IS NULL;
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
            DROP VIEW IF EXISTS `user_music_view`;
        ');
    }
}
