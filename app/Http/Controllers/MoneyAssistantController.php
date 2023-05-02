<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Constants\ExpenseModelConstant;
use App\Models\Constants\PaymentModelConstant;
use App\Services\PaymentService;
use App\Services\ExpenseService;

class MoneyAssistantController extends Controller
{
    private PaymentService $payment_service;
    private ExpenseService $expense_service;

    public function __construct()
    {
        $this->payment_service = new PaymentService();
        $this->expense_service = new ExpenseService();
    }

    public function getAllPayment()
    {
        return $this->payment_service->getAll();
    }

    public function getPaymentById(int $id)
    {
        return $this->payment_service->getById($id);
    }

    public function addPayment(Request $request)
    {
        return $this->payment_service->add(
            $request->input(PaymentModelConstant::TITLE)
        );
    }

    public function updatePayment(Request $request, int $id)
    {
        return $this->payment_service->update(
            $id,
            $request->input(PaymentModelConstant::TITLE)
        );
    }

    public function deletePayment(int $id)
    {
        return $this->payment_service->delete($id);
    }

    public function getAllExpense()
    {
        return $this->expense_service->getAll();
    }

    public function getExpenseById(int $id)
    {
        return $this->expense_service->getById($id);
    }

    public function addExpense(Request $request)
    {
        return $this->expense_service->add(
            $request->input(ExpenseModelConstant::TITLE),
            $request->input(ExpenseModelConstant::DATE),
            $request->input(ExpenseModelConstant::TO),
            $request->input(ExpenseModelConstant::MEMO),
            $request->input(ExpenseModelConstant::ITEMS)
        );
    }

    public function updateExpense(Request $request, int $id)
    {
        return $this->expense_service->update(
            $id,
            $request->input(ExpenseModelConstant::TITLE),
            $request->input(ExpenseModelConstant::DATE),
            $request->input(ExpenseModelConstant::TO),
            $request->input(ExpenseModelConstant::MEMO),
            $request->input(ExpenseModelConstant::ITEMS)
        );
    }

    public function deleteExpense(int $id)
    {
        return $this->expense_service->delete($id);
    }
}
