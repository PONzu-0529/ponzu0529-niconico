import _ from 'lodash';
import dayjs from 'dayjs';
import { describe, test, expect } from '@jest/globals';
import AuthHelper from '@/Auth/AuthHelper';
import MoneyAssistantModel from '@/models/MoneyAssistantModel';

/**
 * @jest-environment jsdom
 * @jest-environment-options {"url": "http://localhost"}
 * 
 * Commentout \App\Http\Middleware\VerifyCsrfToken::class in app/Http/Kernel.php
 */
describe('MylistAssistantHelper', () => {
  const timeout = 30000;

  test('GetAllPayment', async () => {
    await AuthHelper.login('test1@sample.com', 'password');

    const results = await MoneyAssistantModel.getAllPayment();

    results.forEach(result => {
      expect(result).toHaveProperty('id');
      expect(result).toHaveProperty('title');
    });
  }, timeout);

  test('GetPaymentByID', async () => {
    await AuthHelper.login('test1@sample.com', 'password');

    const result = await MoneyAssistantModel.getPaymentById(1);

    expect(result).toHaveProperty('id');
    expect(result).toHaveProperty('title');
  }, timeout);

  test('GetPaymentByID_DoesntExist', async () => {
    await AuthHelper.login('test1@sample.com', 'password');

    try {
      await MoneyAssistantModel.getPaymentById(999);
    } catch (error) {
      expect(_.get(error, 'response.status')).toEqual(404);
      expect(_.get(error, 'response.data.message')).toEqual('This Data is Not Found.');
    }
  }, timeout);

  test('AddPayment', async () => {
    await AuthHelper.login('test1@sample.com', 'password');

    const title = 'TestPaymentTitle(Jest)';

    const index = await MoneyAssistantModel.addPayment({
      title: title
    });

    const result = _.last(await MoneyAssistantModel.getAllPayment());

    if (result === undefined) {
      throw new Error('failed');
    }

    expect(result.id).toEqual(index);
    expect(result.title).toEqual(title);
  }, timeout);

  test('UpdatePayment', async () => {
    await AuthHelper.login('test1@sample.com', 'password');

    let title = 'TestPaymentTitle(Jest)';

    const index = await MoneyAssistantModel.addPayment({
      title: title
    });

    title = 'TestPaymentTitle(Jest)_New';

    await MoneyAssistantModel.updatePayment(
      index,
      {
        title: title
      }
    );

    const result = await MoneyAssistantModel.getPaymentById(index);

    if (result === undefined) {
      throw new Error('failed');
    }

    expect(result).toHaveProperty('id');
    expect(result).toHaveProperty('title');
  }, timeout);

  test('DeletePayment', async () => {
    await AuthHelper.login('test1@sample.com', 'password');

    const title = 'TestPaymentTitle(Jest)';

    const index = await MoneyAssistantModel.addPayment({
      title: title
    });

    await MoneyAssistantModel.deletePayment(index);

    try {
      await MoneyAssistantModel.getPaymentById(index);
    } catch (error) {
      expect(_.get(error, 'response.status')).toEqual(404);
      expect(_.get(error, 'response.data.message')).toEqual('This Data is Not Found.');
    }
  }, timeout);

  test('GetAllExpense', async () => {
    await AuthHelper.login('test1@sample.com', 'password');

    const results = await MoneyAssistantModel.getAllExpense();

    results.forEach(result => {
      expect(result).toHaveProperty('id');
      expect(result).toHaveProperty('title');
    });
  }, timeout);

  test('GetExpenseByID', async () => {
    await AuthHelper.login('test1@sample.com', 'password');

    const result = await MoneyAssistantModel.getExpenseById(1);

    expect(result).toHaveProperty('id');
    expect(result).toHaveProperty('title');
  }, timeout);

  test('GetExpenseByID_DoesntExist', async () => {
    await AuthHelper.login('test1@sample.com', 'password');

    try {
      await MoneyAssistantModel.getExpenseById(999);
    } catch (error) {
      expect(_.get(error, 'response.status')).toEqual(404);
      expect(_.get(error, 'response.data.message')).toEqual('This Data is Not Found.');
    }
  }, timeout);

  test('AddExpense', async () => {
    await AuthHelper.login('test1@sample.com', 'password');

    const title = 'TestExpenseTitle(Jest)';
    const date = dayjs('2023/05/01');
    const to = 'TestExpenseTo(Jest)';
    const memo = 'TestExpenseMemo(Jest)';
    const items = [
      {
        title: 'TestItemTitle1(Jest)',
        money: 300,
        payment_id: 1
      },
      {
        title: 'TestItemTitle2(Jest)',
        money: 900,
        payment_id: 1
      },
      {
        title: 'TestItemTitle3(Jest)',
        money: 600,
        payment_id: 2
      }
    ];

    const index = await MoneyAssistantModel.addExpense({
      title: title,
      date: date.format('YYYY-MM-DD'),
      to: to,
      memo: memo,
      items: items
    });

    const result = await MoneyAssistantModel.getExpenseById(index);

    if (result === undefined) {
      throw new Error('failed');
    }

    expect(result.title).toEqual(title);
    expect(dayjs(result.date)).toEqual(date);
    expect(result.to).toEqual(to);
    expect(result.memo).toEqual(memo);

    result.items.forEach((item, index) => {
      expect(item.title).toEqual(items[index].title);
      expect(item.money).toEqual(items[index].money);
      expect(item.payment_id).toEqual(items[index].payment_id);
    });
  }, timeout);

  test('UpdateExpense', async () => {
    await AuthHelper.login('test1@sample.com', 'password');

    let title = 'TestExpenseTitle(Jest)';
    let date = dayjs('2023/05/01');
    let to = 'TestExpenseTo(Jest)';
    let memo = 'TestExpenseMemo(Jest)';
    let items = [
      {
        title: 'TestItemTitle1(Jest)',
        money: 300,
        payment_id: 1
      },
      {
        title: 'TestItemTitle2(Jest)',
        money: 900,
        payment_id: 1
      },
      {
        title: 'TestItemTitle3(Jest)',
        money: 600,
        payment_id: 2
      }
    ];

    const index = await MoneyAssistantModel.addExpense({
      title: title,
      date: date.format('YYYY-MM-DD'),
      to: to,
      memo: memo,
      items: items
    });

    title = 'TestExpenseTitle(Jest)_New';
    date = dayjs('2023/06/01');
    to = 'TestExpenseTo(Jest)_New';
    memo = 'TestExpenseMemo(Jest)_New';
    items = [
      {
        title: 'TestItemTitle1(Jest)_New',
        money: 3000,
        payment_id: 1
      },
      {
        title: 'TestItemTitle2(Jest)_New',
        money: 9000,
        payment_id: 1
      },
      {
        title: 'TestItemTitle3(Jest)_New',
        money: 6000,
        payment_id: 2
      }
    ];

    await MoneyAssistantModel.updateExpense(
      index,
      {
        title: title,
        date: date.format('YYYY-MM-DD'),
        to: to,
        memo: memo,
        items: items
      }
    );

    const result = await MoneyAssistantModel.getExpenseById(index);

    if (result === undefined) {
      throw new Error('failed');
    }

    expect(result.title).toEqual(title);
    expect(dayjs(result.date)).toEqual(date);
    expect(result.to).toEqual(to);
    expect(result.memo).toEqual(memo);

    result.items.forEach((item, index) => {
      expect(item.title).toEqual(items[index].title);
      expect(item.money).toEqual(items[index].money);
      expect(item.payment_id).toEqual(items[index].payment_id);
    });
  }, timeout);

  test('DeleteExpense', async () => {
    await AuthHelper.login('test1@sample.com', 'password');

    const title = 'TestExpenseTitle(Jest)';
    const date = dayjs('2023/05/01');
    const to = 'TestExpenseTo(Jest)';
    const memo = 'TestExpenseMemo(Jest)';
    const items = [
      {
        title: 'TestItemTitle1(Jest)',
        money: 300,
        payment_id: 1
      },
      {
        title: 'TestItemTitle2(Jest)',
        money: 900,
        payment_id: 1
      },
      {
        title: 'TestItemTitle3(Jest)',
        money: 600,
        payment_id: 2
      }
    ];

    const index = await MoneyAssistantModel.addExpense({
      title: title,
      date: date.format('YYYY-MM-DD'),
      to: to,
      memo: memo,
      items: items
    });

    await MoneyAssistantModel.deleteExpense(index);

    try {
      await MoneyAssistantModel.getExpenseById(index);
    } catch (error) {
      expect(_.get(error, 'response.status')).toEqual(404);
      expect(_.get(error, 'response.data.message')).toEqual('This Data is Not Found.');
    }
  }, timeout);
});
