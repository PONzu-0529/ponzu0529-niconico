<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\Constants\PaymentModelConstant;

class CreatePaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(PaymentModelConstant::TABLE_NAME, function (Blueprint $table) {
            $table->id();
            $table->bigInteger(PaymentModelConstant::USER_ID);
            $table->string(PaymentModelConstant::TITLE);
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
        Schema::dropIfExists(PaymentModelConstant::TABLE_NAME);
    }
}
