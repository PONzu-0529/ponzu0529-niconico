import _ from 'lodash';
import axios, { AxiosRequestConfig } from 'axios';
import { userModule } from '@/store/modules/User';

export default class User {
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

  static async checkAccessToken(): Promise<boolean> {
    const accessToken = localStorage.getItem('accessToken');

    if (accessToken) {
      const options: AxiosRequestConfig = {
        url: `${this.url}/api/check-access-token`,
        method: 'POST',
        data: {
          accessToken: accessToken,
        },
      };

      await axios(options)
        .then((res) => {
          const { data } = res;

          if (_.get(data, 'status', '') === 'success') {
            userModule.loginSuccess();
            return true;
          }
          
          return false;
        })
        .catch((err) => {
          console.log('err:', err);
          return false;
        });
    }

    return false;
  }
}
