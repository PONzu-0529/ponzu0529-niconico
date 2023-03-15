<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\Constants\UserMusicConstant;

class CreateUserMusicTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_music', function (Blueprint $table) {
            $table->id();
            $table->bigInteger(UserMusicConstant::USER_ID);
            $table->bigInteger(UserMusicConstant::MUSIC_ID);
            $table->boolean(UserMusicConstant::FAVORITE);
            $table->boolean(UserMusicConstant::SKIP);
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
        Schema::dropIfExists('user_music');
    }
}
