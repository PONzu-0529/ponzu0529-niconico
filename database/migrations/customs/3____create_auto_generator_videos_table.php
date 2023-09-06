<?php

use App\Models\AutoGeneratorVideo;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAutoGeneratorVideosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(AutoGeneratorVideo::TABLE_NAME, function (Blueprint $table) {
            $table->id();
            $table->string(AutoGeneratorVideo::REQUEST_ID);
            $table->string(AutoGeneratorVideo::VIDEO_ID);
            $table->string(AutoGeneratorVideo::STATE);
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
        Schema::dropIfExists(AutoGeneratorVideo::TABLE_NAME);
    }
}
