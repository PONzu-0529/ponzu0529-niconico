<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\Constants\ExpenseItemConstant;

class CreateExpenseItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(ExpenseItemConstant::TABLE_NAME, function (Blueprint $table) {
            $table->id();
            $table->bigInteger(ExpenseItemConstant::EXPENSES_ID);
            $table->string(ExpenseItemConstant::TITLE);
            $table->integer(ExpenseItemConstant::MONEY);
            $table->bigInteger(ExpenseItemConstant::PAYMENT_ID);
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
        Schema::dropIfExists(ExpenseItemConstant::TABLE_NAME);
    }
}
