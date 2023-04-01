import { describe, test, expect } from '@jest/globals';
import AuthHelper from '@/Auth/AuthHelper';

/**
 * @jest-environment jsdom
 * @jest-environment-options {"url": "http://localhost"}
 * 
 * Commentout \App\Http\Middleware\VerifyCsrfToken::class in app/Http/Kernel.php
 */
describe('AuthHelper', () => {
  test('Get Guest UserName', async () => {
    const userName = await AuthHelper.getUserName();
    expect(userName).toEqual('');
  });

  test('Get User1 UserName', async () => {
    await AuthHelper.login('test1@sample.com', 'password');
    const userName = await AuthHelper.getUserName();
    expect(userName).toEqual('User1');
  });
});
