<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\Constants\PaymentConstant;

class CreatePaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(PaymentConstant::TABLE_NAME, function (Blueprint $table) {
            $table->id();
            $table->bigInteger(PaymentConstant::USER_ID);
            $table->string(PaymentConstant::TITLE);
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
        Schema::dropIfExists(PaymentConstant::TABLE_NAME);
    }
}
