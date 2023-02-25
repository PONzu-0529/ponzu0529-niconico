import _ from 'lodash';
import axios from 'axios';

export default class ApiHelper {
  /**
   * Get
   * @param url URL
   * @returns Result
   */
  public static async get(url: string): Promise<any> {
    const result = await axios({
      url: url,
      method: 'GET'
    });

    return _.get(result, 'data', null);
  }

  /**
   * Post
   * @param url URL
   * @param data Post Data
   * @returns Result
   */
  public static async post(url: string, data?: any): Promise<any> {
    const result = await axios({
      url: url,
      method: 'POST',
      data: data,
    });

    return _.get(result, 'data', null);
  }
}
