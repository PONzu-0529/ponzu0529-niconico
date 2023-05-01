<?php

namespace App\Services;

use Auth;
use DateTime;
use App\Constants\AuthenticationLevelConstant;
use App\Constants\ExpenseConstant;
use App\Models\Expense;
use App\Models\ExpenseItem;
use App\Models\Constants\AuthenticationConstant;
use App\Models\Constants\ExpenseModelConstant;
use App\Models\Constants\ExpenseItemModelConstant;
use App\Helpers\AuthenticationHelper;

class ExpenseService
{
    /**
     * Get ALL
     *
     * @return array
     */
    public function getAll(): array
    {
        $this->checkAuthorize(AuthenticationLevelConstant::VIEW);

        $expenses = Expense::where([
            ExpenseModelConstant::USER_ID => Auth::user()[AuthenticationConstant::ID]
        ])
            ->get()
            ->toArray();

        return array_map(
            function ($expense) {
                $id = $expense[ExpenseModelConstant::ID];
                $expense[ExpenseModelConstant::ITEMS] = ExpenseItem::where([
                    ExpenseItemModelConstant::EXPENSES_ID => $id
                ])
                    ->get()
                    ->toArray();
                return $expense;
            },
            $expenses
        );
    }

    /**
     * Get By ID
     *
     * @param integer $id
     * @return Expense
     */
    public function getById(int $id): Expense
    {
        $this->checkAuthorize(AuthenticationLevelConstant::VIEW);

        $this->checkIdExistence($id);

        $expense = Expense::where([
            ExpenseModelConstant::USER_ID => Auth::user()[AuthenticationConstant::ID],
            ExpenseModelConstant::ID => $id
        ])
            ->first();


        $id = $expense[ExpenseModelConstant::ID];
        $expense[ExpenseModelConstant::ITEMS] = ExpenseItem::where([
            ExpenseItemModelConstant::EXPENSES_ID => $id
        ])
            ->get()
            ->toArray();

        return $expense;
    }

    /**
     * Add
     *
     * @param string $title
     * @return integer
     */
    public function add(string $title, DateTime $date, string $to, string $memo, array $items): int
    {
        $this->checkAuthorize(AuthenticationLevelConstant::EDIT);

        $model = new Expense();

        $model[ExpenseModelConstant::USER_ID] = Auth::user()[AuthenticationConstant::ID];
        $model[ExpenseModelConstant::TITLE] = $title;
        $model[ExpenseModelConstant::DATE] = $date->format('Y-m-d');
        $model[ExpenseModelConstant::TO] = $to;
        $model[ExpenseModelConstant::MEMO] = $memo;

        $model->save();
        $id = $model[ExpenseModelConstant::ID];

        foreach ($items as $item) {
            $model = new ExpenseItem();

            $model[ExpenseItemModelConstant::EXPENSES_ID] = $id;
            $model[ExpenseItemModelConstant::TITLE] = $item[ExpenseItemModelConstant::TITLE];
            $model[ExpenseItemModelConstant::MONEY] = $item[ExpenseItemModelConstant::MONEY];
            $model[ExpenseItemModelConstant::PAYMENT_ID] = $item[ExpenseItemModelConstant::PAYMENT_ID];

            $model->save();
        }

        return $id;
    }

    /**
     * Update
     *
     * @param integer $id
     * @param string $title
     * @return void
     */
    public function update(int $id, string $title, DateTime $date, string $to, string $memo, array $items): void
    {
        $this->checkAuthorize(AuthenticationLevelConstant::EDIT);

        $this->checkIdExistence($id);

        $model = Expense::where([
            ExpenseModelConstant::USER_ID => Auth::user()[AuthenticationConstant::ID],
            ExpenseModelConstant::ID => $id
        ])
            ->first();

        $model[ExpenseModelConstant::USER_ID] = Auth::user()[AuthenticationConstant::ID];
        $model[ExpenseModelConstant::TITLE] = $title;
        $model[ExpenseModelConstant::DATE] = $date->format('Y-m-d');
        $model[ExpenseModelConstant::TO] = $to;
        $model[ExpenseModelConstant::MEMO] = $memo;

        $model->save();
        $id = $model[ExpenseModelConstant::ID];

        ExpenseItem::where(ExpenseItemModelConstant::EXPENSES_ID, $id)
            ->delete();

        foreach ($items as $item) {
            $model = new ExpenseItem();

            $model[ExpenseItemModelConstant::EXPENSES_ID] = $id;
            $model[ExpenseItemModelConstant::TITLE] = $item[ExpenseItemModelConstant::TITLE];
            $model[ExpenseItemModelConstant::MONEY] = $item[ExpenseItemModelConstant::MONEY];
            $model[ExpenseItemModelConstant::PAYMENT_ID] = $item[ExpenseItemModelConstant::PAYMENT_ID];

            $model->save();
        }
    }

    /**
     * Delete
     *
     * @param integer $id
     * @return void
     */
    public function delete(int $id): void
    {
        $this->checkAuthorize(AuthenticationLevelConstant::EDIT);

        $this->checkIdExistence($id);

        Expense::where(ExpenseModelConstant::ID, $id)
            ->delete();
    }

    /**
     * Check Authorize
     *
     * @param string $authorizeLevel
     * @return void
     */
    private function checkAuthorize(string $authorizeLevel): void
    {
        if (
            !AuthenticationHelper::checkAuthentication(
                ExpenseConstant::FUNCTION_ID,
                $authorizeLevel
            )
        ) {
            abort(401, 'This User is Unauthorized.');
        }
    }

    /**
     * Check ID Existence
     *
     * @param integer $id
     * @return void
     */
    private function checkIdExistence(int $id): void
    {
        if (
            Expense::where([
                ExpenseModelConstant::USER_ID => Auth::user()[AuthenticationConstant::ID],
                ExpenseModelConstant::ID => $id
            ])->doesntExist()
        ) {
            abort(404, 'This Data is Not Found.');
        }
    }
}
