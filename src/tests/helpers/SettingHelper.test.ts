import { describe, test, expect } from '@jest/globals';
import SettingHelper from '@/helpers/SettingHelper';

/**
 * @jest-environment jsdom
 * @jest-environment-options {"url": "http://localhost"}
 * 
 * Commentout \App\Http\Middleware\VerifyCsrfToken::class in app/Http/Kernel.php
 */
describe('AuthHelper', () => {
  test('Get Setting Value', async () => {
    const value = await SettingHelper.getSetting('ADSENCE_CLIENT_ID');
    expect(value).toEqual('ca-pub-1234567890123456');
  });

  test('Get Setting Undefined Value', async () => {
    const value = await SettingHelper.getSetting('UNDEFINED');
    expect(value).toEqual('');
  });
});
