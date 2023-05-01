<?php

namespace App\Services;

use Auth;
use App\Constants\AuthenticationLevelConstant;
use App\Constants\PaymentConstant;
use App\Models\Payment;
use App\Models\Constants\AuthenticationConstant;
use App\Models\Constants\PaymentModelConstant;
use App\Helpers\AuthenticationHelper;

class PaymentService
{
    /**
     * Get ALL
     *
     * @return array
     */
    public function getAll(): array
    {
        $this->checkAuthorize(AuthenticationLevelConstant::VIEW);

        return Payment::where([
            PaymentModelConstant::USER_ID => Auth::user()[AuthenticationConstant::ID]
        ])
            ->get()
            ->toArray();
    }

    /**
     * Get By ID
     *
     * @param integer $id
     * @return Payment
     */
    public function getById(int $id): Payment
    {
        $this->checkAuthorize(AuthenticationLevelConstant::VIEW);

        $this->checkIdExistence($id);

        return Payment::where([
            PaymentModelConstant::USER_ID => Auth::user()[AuthenticationConstant::ID],
            PaymentModelConstant::ID => $id
        ])
            ->first();
    }

    /**
     * Add
     *
     * @param string $title
     * @return integer
     */
    public function add(string $title): int
    {
        $this->checkAuthorize(AuthenticationLevelConstant::EDIT);

        $model = new Payment();

        $model[PaymentModelConstant::USER_ID] = Auth::user()[AuthenticationConstant::ID];
        $model[PaymentModelConstant::TITLE] = $title;

        $model->save();

        return $model[PaymentModelConstant::ID];
    }

    /**
     * Update
     *
     * @param integer $id
     * @param string $title
     * @return void
     */
    public function update(int $id, string $title): void
    {
        $this->checkAuthorize(AuthenticationLevelConstant::EDIT);

        $this->checkIdExistence($id);

        $model = Payment::where([
            PaymentModelConstant::USER_ID => Auth::user()[AuthenticationConstant::ID],
            PaymentModelConstant::ID => $id
        ])
            ->first();

        $model[PaymentModelConstant::USER_ID] = Auth::user()[AuthenticationConstant::ID];
        $model[PaymentModelConstant::TITLE] = $title;

        $model->save();
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

        Payment::where(PaymentModelConstant::ID, $id)
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
                PaymentConstant::FUNCTION_ID,
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
            Payment::where([
                PaymentModelConstant::USER_ID => Auth::user()[AuthenticationConstant::ID],
                PaymentModelConstant::ID => $id
            ])->doesntExist()
        ) {
            abort(404, 'This Data is Not Found.');
        }
    }
}
