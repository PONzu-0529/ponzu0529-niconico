<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\Constants\ExpenseModelConstant;

class CreateExpensesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(ExpenseModelConstant::TABLE_NAME, function (Blueprint $table) {
            $table->id();
            $table->bigInteger(ExpenseModelConstant::USER_ID);
            $table->string(ExpenseModelConstant::TITLE);
            $table->date(ExpenseModelConstant::DATE);
            $table->string(ExpenseModelConstant::TO);
            $table->string(ExpenseModelConstant::MEMO);
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
        Schema::dropIfExists(ExpenseModelConstant::TABLE_NAME);
    }
}
