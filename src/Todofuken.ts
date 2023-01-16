import _ from 'lodash';
import axios, { AxiosRequestConfig } from 'axios';

export default class Todofuken {
  private static get url(): string {
    switch (process.env.NODE_ENV) {
      case 'development': {
        return 'http://localhost';
      }

      case 'production': {
        return 'https://tools.ponzu0529.com';
      }

      default: {
        return 'http://localhost';
      }
    }
  }

  static async getTodofukenList(num: number): Promise<Array<todofuken> | boolean> {
    const options: AxiosRequestConfig = {
      url: `${this.url}/api/v1/get-todofuken-list`,
      method: 'POST',
      data: {
        num: num
      },
    };

    const result = await axios(options);

    if (_.get(result, 'data.status', '') !== 'success') {
      return false;
    }

    return _.get(result, 'data.todofulen_list', []);
  }
}

export interface todofuken {
  prefecture: string,
  capital: string,
  file: string
}
