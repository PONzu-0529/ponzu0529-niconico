import ApiHelper from '@/common/ApiHelper';
import Utils from '@/common/Utils';

export default class AuthHelper {
  private static host = Utils.getHostWithProtocol();

  /**
   * Get UserName
   * @returns UserName
   */
  public static async getUserName(): Promise<string> {
    const result = await ApiHelper.get(`${this.host}/api/get-user-name`);

    return result ?? '';
  }

  /**
   * Get CsrfToken
   * @returns CsrfToken
   */
  public static async getCsrfToken(): Promise<string> {
    const result = await ApiHelper.get(`${this.host}/api/get-csrf-token`);

    return result ?? '';
  }
}
