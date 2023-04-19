<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\Constants\MusicMemoConstant;
use App\Models\Constants\UserMusic2ViewConstant;

class CreateUserMusic2View extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement('
            DROP VIEW IF EXISTS `' . UserMusic2ViewConstant::VIEW_NAME . '`;
        ');
        DB::statement('
            CREATE VIEW `' . UserMusic2ViewConstant::VIEW_NAME . '` AS
            SELECT
                `musics`.`id` as `' . UserMusic2ViewConstant::MUSIC_ID . '`,
                `musics`.`title` as `' . UserMusic2ViewConstant::TITLE . '`,
                `musics`.`niconico_id` as `' . UserMusic2ViewConstant::NICONICO_ID . '`,
                `users`.`id` as `' . UserMusic2ViewConstant::USER_ID . '`,
                ifnull(`user_music`.`favorite`, false) as `' . UserMusic2ViewConstant::FAVORITE . '`,
                ifnull(`user_music`.`skip`, false) as `' . UserMusic2ViewConstant::SKIP . '`,
                ifnull(`' . MusicMemoConstant::TABLE_NAME . '`.`' . MusicMemoConstant::MEMO . '`, \'\') as `' . UserMusic2ViewConstant::MEMO . '`
            FROM
                `musics`
            CROSS JOIN `users`
            LEFT JOIN `user_music`
                ON `users`.`id` = `user_music`.`user_id`
                AND `musics`.`id` = `user_music`.`music_id`
                AND `user_music`.`deleted_at` IS NULL
            LEFT JOIN `' . MusicMemoConstant::TABLE_NAME . '`
                ON `users`.`id` = `' . MusicMemoConstant::TABLE_NAME . '`.`' . MusicMemoConstant::USER_ID . '`
                AND `musics`.`id` = `' . MusicMemoConstant::TABLE_NAME . '`.`' . MusicMemoConstant::MUSIC_ID . '`
                AND `' . MusicMemoConstant::TABLE_NAME . '`.`' . MusicMemoConstant::DELETED_AT . '` IS NULL
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
            DROP VIEW IF EXISTS `' . UserMusic2ViewConstant::VIEW_NAME . '`;
        ');
    }
}
