import { describe, test, expect } from '@jest/globals';
import Utils from '@/common/Utils';

/**
 * @jest-environment jsdom
 * @jest-environment-options {"url": "http://localhost"}
 */
describe('Utils', () => {
  test('Get Environment', async () => {
    const env = Utils.getEnv();
    expect(env).toEqual('test');
  });
});
