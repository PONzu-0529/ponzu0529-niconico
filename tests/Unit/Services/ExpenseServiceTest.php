<?php

namespace Tests\Unit\Services;

use Datetime;
use Exception;
use App\Models\Constants\ExpenseModelConstant;
use App\Models\Constants\ExpenseItemModelConstant;
use App\Models\Expense;
use App\Models\ExpenseItem;
use App\Services\ExpenseService;

class ExpenseServiceTest extends BaseServiceTest
{
    private ExpenseService $service;

    public function __construct()
    {
        parent::__construct();
        $this->service = new ExpenseService();
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
        $results = $this->service->getAll();

        foreach ($results as $result) {
            $this->assertArrayHasKey(ExpenseModelConstant::USER_ID, $result);
            $this->assertArrayHasKey(ExpenseModelConstant::TITLE, $result);
            $this->assertArrayHasKey(ExpenseModelConstant::DATE, $result);
            $this->assertArrayHasKey(ExpenseModelConstant::TO, $result);
            $this->assertArrayHasKey(ExpenseModelConstant::MEMO, $result);
            $this->assertArrayHasKey(ExpenseModelConstant::ITEMS, $result);

            foreach ($result[ExpenseModelConstant::ITEMS] as $item) {
                $this->assertArrayHasKey(ExpenseItemModelConstant::EXPENSES_ID, $item);
                $this->assertEquals($result[ExpenseModelConstant::ID], $item[ExpenseItemModelConstant::EXPENSES_ID]);
                $this->assertArrayHasKey(ExpenseItemModelConstant::TITLE, $item);
                $this->assertArrayHasKey(ExpenseItemModelConstant::MONEY, $item);
                $this->assertArrayHasKey(ExpenseItemModelConstant::PAYMENT_ID, $item);
                $this->assertArrayHasKey(ExpenseItemModelConstant::PAYMENT, $item);
            }
        }
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

        $this->assertArrayHasKey(ExpenseModelConstant::USER_ID, $result);
        $this->assertEquals(1, $result[ExpenseModelConstant::USER_ID]);
        $this->assertArrayHasKey(ExpenseModelConstant::TITLE, $result);
        $this->assertArrayHasKey(ExpenseModelConstant::DATE, $result);
        $this->assertArrayHasKey(ExpenseModelConstant::TO, $result);
        $this->assertArrayHasKey(ExpenseModelConstant::MEMO, $result);
        $this->assertArrayHasKey(ExpenseModelConstant::ITEMS, $result);

        foreach ($result[ExpenseModelConstant::ITEMS] as $item) {
            $this->assertArrayHasKey(ExpenseItemModelConstant::EXPENSES_ID, $item);
            $this->assertEquals($result[ExpenseModelConstant::ID], $item[ExpenseItemModelConstant::EXPENSES_ID]);
            $this->assertArrayHasKey(ExpenseItemModelConstant::TITLE, $item);
            $this->assertArrayHasKey(ExpenseItemModelConstant::MONEY, $item);
            $this->assertArrayHasKey(ExpenseItemModelConstant::PAYMENT_ID, $item);
            $this->assertArrayHasKey(ExpenseItemModelConstant::PAYMENT, $item);
        }
    }

    public function test_add_notLogin()
    {
        try {
            $this->service->add('', (new Datetime())->format('Y-m-d'), '', '', []);
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
            $this->service->add('', (new Datetime())->format('Y-m-d'), '', '', []);
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

        $title = 'TestExpenseTitle';
        $date = (new Datetime('2023-03-01'))->format('Y-m-d');
        $to = 'TestExpenseTo';
        $memo = 'TestExpenseMemo';
        $items = [
            [
                ExpenseItemModelConstant::TITLE => 'TestItemTitle1',
                ExpenseItemModelConstant::MONEY => 300,
                ExpenseItemModelConstant::PAYMENT_ID => 1
            ],
            [
                ExpenseItemModelConstant::TITLE => 'TestItemTitle2',
                ExpenseItemModelConstant::MONEY => 900,
                ExpenseItemModelConstant::PAYMENT_ID => 1
            ],
            [
                ExpenseItemModelConstant::TITLE => 'TestItemTitle3',
                ExpenseItemModelConstant::MONEY => 600,
                ExpenseItemModelConstant::PAYMENT_ID => 2
            ]
        ];

        $this->service->add($title, $date, $to, $memo, $items);

        $response = $this->service->getAll();
        $result = end($response);

        $this->assertEquals($result[ExpenseModelConstant::USER_ID], 1);
        $this->assertEquals($result[ExpenseModelConstant::TITLE], $title);
        $this->assertEquals($result[ExpenseModelConstant::DATE], $date);
        $this->assertEquals($result[ExpenseModelConstant::TO], $to);
        $this->assertEquals($result[ExpenseModelConstant::MEMO], $memo);

        foreach ($result[ExpenseModelConstant::ITEMS] as $index => $item) {
            $this->assertEquals($item[ExpenseItemModelConstant::EXPENSES_ID], $result[ExpenseModelConstant::ID]);
            $this->assertEquals($item[ExpenseItemModelConstant::TITLE], $items[$index][ExpenseItemModelConstant::TITLE]);
            $this->assertEquals($item[ExpenseItemModelConstant::MONEY], $items[$index][ExpenseItemModelConstant::MONEY]);
            $this->assertEquals($item[ExpenseItemModelConstant::PAYMENT_ID], $items[$index][ExpenseItemModelConstant::PAYMENT_ID]);
        }
    }

    public function test_update_notLogin()
    {
        try {
            $this->service->update(1, '', (new Datetime())->format('Y-m-d'), '', '', []);
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
            $this->service->update(1, '', (new Datetime())->format('Y-m-d'), '', '', []);
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
            $this->service->update(99, '', (new Datetime())->format('Y-m-d'), '', '', []);
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

        $title = 'TestExpenseTitle';
        $date = (new Datetime('2023-03-01'))->format('Y-m-d');
        $to = 'TestExpenseTo';
        $memo = 'TestExpenseMemo';
        $items = [
            [
                ExpenseItemModelConstant::TITLE => 'TestItemTitle1',
                ExpenseItemModelConstant::MONEY => 300,
                ExpenseItemModelConstant::PAYMENT_ID => 1
            ],
            [
                ExpenseItemModelConstant::TITLE => 'TestItemTitle2',
                ExpenseItemModelConstant::MONEY => 900,
                ExpenseItemModelConstant::PAYMENT_ID => 1
            ],
            [
                ExpenseItemModelConstant::TITLE => 'TestItemTitle3',
                ExpenseItemModelConstant::MONEY => 600,
                ExpenseItemModelConstant::PAYMENT_ID => 2
            ]
        ];

        $id = $this->service->add($title, $date, $to, $memo, $items);

        $title = 'TestExpenseTitle_New';
        $date = (new Datetime('2023-03-20'))->format('Y-m-d');
        $to = 'TestExpenseTo_New';
        $memo = 'TestExpenseMemo_New';
        $items = [
            [
                ExpenseItemModelConstant::TITLE => 'TestItemTitle1_New',
                ExpenseItemModelConstant::MONEY => 200,
                ExpenseItemModelConstant::PAYMENT_ID => 1
            ],
            [
                ExpenseItemModelConstant::TITLE => 'TestItemTitle2_New',
                ExpenseItemModelConstant::MONEY => 800,
                ExpenseItemModelConstant::PAYMENT_ID => 1
            ],
            [
                ExpenseItemModelConstant::TITLE => 'TestItemTitle3_New',
                ExpenseItemModelConstant::MONEY => 400,
                ExpenseItemModelConstant::PAYMENT_ID => 2
            ]
        ];

        $this->service->update($id, $title, $date, $to, $memo, $items);

        $response = $this->service->getAll();
        $result = end($response);

        $this->assertEquals($result[ExpenseModelConstant::USER_ID], 1);
        $this->assertEquals($result[ExpenseModelConstant::TITLE], $title);
        $this->assertEquals($result[ExpenseModelConstant::DATE], $date);
        $this->assertEquals($result[ExpenseModelConstant::TO], $to);
        $this->assertEquals($result[ExpenseModelConstant::MEMO], $memo);

        foreach ($result[ExpenseModelConstant::ITEMS] as $index => $item) {
            $this->assertEquals($item[ExpenseItemModelConstant::EXPENSES_ID], $result[ExpenseModelConstant::ID]);
            $this->assertEquals($item[ExpenseItemModelConstant::TITLE], $items[$index][ExpenseItemModelConstant::TITLE]);
            $this->assertEquals($item[ExpenseItemModelConstant::MONEY], $items[$index][ExpenseItemModelConstant::MONEY]);
            $this->assertEquals($item[ExpenseItemModelConstant::PAYMENT_ID], $items[$index][ExpenseItemModelConstant::PAYMENT_ID]);
        }
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

        $title = 'TestExpenseTitle';
        $date = (new Datetime('2023-03-01'))->format('Y-m-d');
        $to = 'TestExpenseTo';
        $memo = 'TestExpenseMemo';
        $items = [
            [
                ExpenseItemModelConstant::TITLE => 'TestItemTitle1',
                ExpenseItemModelConstant::MONEY => 300,
                ExpenseItemModelConstant::PAYMENT_ID => 1
            ],
            [
                ExpenseItemModelConstant::TITLE => 'TestItemTitle2',
                ExpenseItemModelConstant::MONEY => 900,
                ExpenseItemModelConstant::PAYMENT_ID => 1
            ],
            [
                ExpenseItemModelConstant::TITLE => 'TestItemTitle3',
                ExpenseItemModelConstant::MONEY => 600,
                ExpenseItemModelConstant::PAYMENT_ID => 2
            ]
        ];

        $id = $this->service->add($title, $date, $to, $memo, $items);

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
}
