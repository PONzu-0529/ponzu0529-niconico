<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\Constants\ExpenseItemModelConstant;

class CreateExpenseItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(ExpenseItemModelConstant::TABLE_NAME, function (Blueprint $table) {
            $table->id();
            $table->bigInteger(ExpenseItemModelConstant::EXPENSES_ID);
            $table->string(ExpenseItemModelConstant::TITLE);
            $table->integer(ExpenseItemModelConstant::MONEY);
            $table->bigInteger(ExpenseItemModelConstant::PAYMENT_ID);
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
        Schema::dropIfExists(ExpenseItemModelConstant::TABLE_NAME);
    }
}
