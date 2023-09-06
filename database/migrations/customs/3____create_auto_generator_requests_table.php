<?php

use App\Models\AutoGeneratorRequest;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAutoGeneratorRequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(AutoGeneratorRequest::TABLE_NAME, function (Blueprint $table) {
            $table->id();
            $table->string(AutoGeneratorRequest::EMAIL);
            $table->string(AutoGeneratorRequest::PASSWORD);
            $table->string(AutoGeneratorRequest::MYLIST_TITLE);
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
        Schema::dropIfExists(AutoGeneratorRequest::TABLE_NAME);
    }
}
