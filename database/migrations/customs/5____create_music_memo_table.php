<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\Constants\MusicMemoConstant;

class CreateMusicMemoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(MusicMemoConstant::TABLE_NAME, function (Blueprint $table) {
            $table->id();
            $table->bigInteger(MusicMemoConstant::USER_ID);
            $table->bigInteger(MusicMemoConstant::MUSIC_ID);
            $table->text(MusicMemoConstant::MEMO);
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
        Schema::dropIfExists(MusicMemoConstant::TABLE_NAME);
    }
}
