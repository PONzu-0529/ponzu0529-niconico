<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\Constants\ExpenseConstant;

class CreateExpensesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(ExpenseConstant::TABLE_NAME, function (Blueprint $table) {
            $table->id();
            $table->bigInteger(ExpenseConstant::USER_ID);
            $table->string(ExpenseConstant::TITLE);
            $table->integer(ExpenseConstant::MONEY);
            $table->date(ExpenseConstant::DATE);
            $table->string(ExpenseConstant::FROM);
            $table->string(ExpenseConstant::TO);
            $table->string(ExpenseConstant::MEMO);
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
        Schema::dropIfExists(ExpenseConstant::TABLE_NAME);
    }
}
