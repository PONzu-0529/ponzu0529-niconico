import Utils from '@/common/Utils';
import ApiHelper from '@/common/ApiHelper';

export default class SettingHelper {
  /**
   * Get Setting
   * @param key Key
   * @returns Value
   */
  public static async getSetting(key: string) {
    return await ApiHelper.post(`${Utils.getHostWithProtocol()}/api/setting`, {
      key: key
    });
  }
}
