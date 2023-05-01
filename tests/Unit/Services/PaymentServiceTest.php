<?php

namespace Tests\Unit\Services;

use App\Models\Constants\PaymentModelConstant;
use App\Models\Payment;
use Auth, Exception;
use Tests\TestCase;
use App\Services\PaymentService;

class PaymentServiceTest extends TestCase
{
    private PaymentService $service;

    public function __construct()
    {
        parent::__construct();
        $this->service = new PaymentService();
    }

    public function test_getAll_notLogin()
    {
        try {
            $this->service->getAll();
        } catch (Exception $ex) {
            $this->assertEquals(
                $ex->getMessage(),
                'This User is Unauthorized.'
            );
        }
    }

    public function test_getAll_unauthorized()
    {
        try {
            $this->login_user3();
            $this->service->getAll();
        } catch (Exception $ex) {
            $this->assertEquals(
                $ex->getMessage(),
                'This User is Unauthorized.'
            );
        }
    }

    public function test_getAll()
    {
        $this->login_user1();
        $result = $this->service->getAll();

        $this->assertArrayHasKey('title', $result[0]);
    }

    public function test_getById_notLogin()
    {
        try {
            $this->service->getById(1);
        } catch (Exception $ex) {
            $this->assertEquals(
                $ex->getMessage(),
                'This User is Unauthorized.'
            );
        }
    }

    public function test_getById_unauthorized()
    {
        try {
            $this->login_user3();
            $this->service->getById(1);
        } catch (Exception $ex) {
            $this->assertEquals(
                $ex->getMessage(),
                'This User is Unauthorized.'
            );
        }
    }

    public function test_getById_doesntExist()
    {
        try {
            $this->login_user1();
            $this->service->getById(99);
        } catch (Exception $ex) {
            $this->assertEquals(
                $ex->getMessage(),
                'This Data is Not Found.'
            );
        }
    }

    public function test_getById()
    {
        $this->login_user1();
        $result = $this->service->getById(1);

        $this->assertArrayHasKey(PaymentModelConstant::USER_ID, $result);
        $this->assertEquals(1, $result[PaymentModelConstant::USER_ID]);
        $this->assertArrayHasKey(PaymentModelConstant::TITLE, $result);
    }

    public function test_add_notLogin()
    {
        try {
            $this->service->add('');
        } catch (Exception $ex) {
            $this->assertEquals(
                $ex->getMessage(),
                'This User is Unauthorized.'
            );
        }
    }

    public function test_add_unauthorized()
    {
        try {
            $this->login_user2();
            $this->service->add('');
        } catch (Exception $ex) {
            $this->assertEquals(
                $ex->getMessage(),
                'This User is Unauthorized.'
            );
        }
    }

    public function test_add()
    {
        $this->login_user1();

        $title = 'TestPaymentTitle';

        $this->service->add($title);

        $response = $this->service->getAll();
        $result = end($response);

        $this->assertEquals($result[PaymentModelConstant::USER_ID], 1);
        $this->assertEquals($result[PaymentModelConstant::TITLE], $title);
    }

    public function test_update_notLogin()
    {
        try {
            $this->service->update(1, '');
        } catch (Exception $ex) {
            $this->assertEquals(
                $ex->getMessage(),
                'This User is Unauthorized.'
            );
        }
    }

    public function test_update_unauthorized()
    {
        try {
            $this->login_user2();
            $this->service->update(1, '');
        } catch (Exception $ex) {
            $this->assertEquals(
                $ex->getMessage(),
                'This User is Unauthorized.'
            );
        }
    }

    public function test_update_doesntExist()
    {
        try {
            $this->login_user1();
            $this->service->update(99, '');
        } catch (Exception $ex) {
            $this->assertEquals(
                $ex->getMessage(),
                'This Data is Not Found.'
            );
        }
    }

    public function test_update()
    {
        $this->login_user1();

        $title = 'TestPaymentTitle';

        $id = $this->service->add($title);

        $title = 'TestPaymentTitle_New';

        $this->service->update($id, $title);

        $response = $this->service->getAll();
        $result = end($response);

        $this->assertEquals($result[PaymentModelConstant::USER_ID], 1);
        $this->assertEquals($result[PaymentModelConstant::TITLE], $title);
    }

    public function test_delete_notLogin()
    {
        try {
            $this->service->delete(1);
        } catch (Exception $ex) {
            $this->assertEquals(
                $ex->getMessage(),
                'This User is Unauthorized.'
            );
        }
    }

    public function test_delete_unauthorized()
    {
        try {
            $this->login_user2();
            $this->service->delete(1);
        } catch (Exception $ex) {
            $this->assertEquals(
                $ex->getMessage(),
                'This User is Unauthorized.'
            );
        }
    }

    public function test_delete_doesntExist()
    {
        try {
            $this->login_user1();
            $this->service->delete(99);
        } catch (Exception $ex) {
            $this->assertEquals(
                $ex->getMessage(),
                'This Data is Not Found.'
            );
        }
    }

    public function test_delete()
    {
        $this->login_user1();

        $title = 'TestPaymentTitle';

        $id = $this->service->add($title);

        $title = 'TestPaymentTitle_New';

        $this->service->delete($id);

        try {
            $this->service->getById($id);
        } catch (Exception $ex) {
            $this->assertEquals(
                $ex->getMessage(),
                'This Data is Not Found.'
            );
        }
    }

    private function login_user1(): void
    {
        Auth::attempt(
            [
                'email' => 'test1@sample.com',
                'password' => 'password'
            ]
        );
    }

    private function login_user2(): void
    {
        Auth::attempt(
            [
                'email' => 'test2@sample.com',
                'password' => 'password'
            ]
        );
    }

    private function login_user3(): void
    {
        Auth::attempt(
            [
                'email' => 'test3@sample.com',
                'password' => 'password'
            ]
        );
    }
}
