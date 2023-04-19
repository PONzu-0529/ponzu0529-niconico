import _ from 'lodash';
import { describe, test, expect } from '@jest/globals';
import MylistAssistantHelper from '@/helpers/MylistAssistantHelper';
import AuthHelper from '@/Auth/AuthHelper';

/**
 * @jest-environment jsdom
 * @jest-environment-options {"url": "http://localhost"}
 * 
 * Commentout \App\Http\Middleware\VerifyCsrfToken::class in app/Http/Kernel.php
 */
describe('MylistAssistantHelper', () => {
  test('GetAll', async () => {
    await AuthHelper.login('test1@sample.com', 'password');

    const result = await MylistAssistantHelper.getAll();

    expect(result[0]).toHaveProperty('music_id');
    expect(result[0]).toHaveProperty('title');
    expect(result[0]).toHaveProperty('niconico_id');
    expect(result[0]).toHaveProperty('user_id');
    expect(result[0]).toHaveProperty('favorite');
    expect(result[0]).toHaveProperty('skip');
    expect(result[0]).toHaveProperty('memo');
  });

  test('GetById', async () => {
    await AuthHelper.login('test1@sample.com', 'password');

    const result = await MylistAssistantHelper.getById(1);

    expect(result).toHaveProperty('music_id');
    expect(result).toHaveProperty('title');
    expect(result).toHaveProperty('niconico_id');
    expect(result).toHaveProperty('user_id');
    expect(result).toHaveProperty('favorite');
    expect(result).toHaveProperty('skip');
    expect(result).toHaveProperty('memo');
  }, 30000);

  test('Add', async () => {
    await AuthHelper.login('test1@sample.com', 'password');

    const title = 'TEST_TITLE';
    const niconico_id = `TEST_NICONICO_ID_${Date.now()}`;
    const memo = 'TEST_MEMO';

    await MylistAssistantHelper.add({
      title: title,
      niconico_id: niconico_id,
      favorite: true,
      skip: false,
      memo: memo
    });

    const result = _.last(await MylistAssistantHelper.getAll());

    if (result === undefined) {
      throw new Error('failed');
    }

    expect(result.title).toEqual(title);
    expect(result.niconico_id).toEqual(niconico_id);
    expect(result.favorite).toEqual(1);
    expect(result.skip).toEqual(0);
    expect(result.memo).toEqual(memo);
  }, 30000);

  test('Update', async () => {
    await AuthHelper.login('test1@sample.com', 'password');

    let title = 'TEST_TITLE';
    let niconico_id = `TEST_NICONICO_ID_UPDATE_${Date.now()}`;
    let memo = 'TEST_MEMO';

    const index = await MylistAssistantHelper.add({
      title: title,
      niconico_id: niconico_id,
      favorite: false,
      skip: true,
      memo: memo
    });

    title = 'TEST_TITLE_NEW';
    niconico_id = `TEST_NICONICO_ID_UPDATE_NEW_${Date.now()}`;
    memo = 'TEST_MEMO_NEW';

    await MylistAssistantHelper.update(
      index,
      {
        title: title,
        niconico_id: niconico_id,
        favorite: true,
        skip: false,
        memo: memo
      }
    );

    const result = _.last(await MylistAssistantHelper.getAll());

    if (result === undefined) {
      throw new Error('failed');
    }

    expect(result.title).toEqual(title);
    expect(result.niconico_id).toEqual(niconico_id);
    expect(result.favorite).toEqual(1);
    expect(result.skip).toEqual(0);
    expect(result.memo).toEqual(memo);
  }, 30000);
});
