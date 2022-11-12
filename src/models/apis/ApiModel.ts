import _ from 'lodash'
import axios from 'axios'

// Model
import { ResponseStyle } from '@/models/ResponseStyle'


export class ApiModel {
  public static getHost(): string {
    switch (process.env.NODE_ENV) {
      case 'development': {
        return 'http://127.0.0.1'
      }

      case 'production': {
        return 'https://dev-tools.ponzu0529.com'
      }

      default: {
        return 'http://127.0.0.1'
      }
    }
  }


  protected async callApi(callApiStyle: CallApiStyle): Promise<ResponseStyle> {
    try {
      const result = await axios.post(callApiStyle.url, callApiStyle.body)

      if (result.status !== 200) {
        throw new Error(result.statusText)
      }

      if (_.get(result.data, 'status', '') !== 'success') {
        return {
          status: 'failuer',
          data: _.get(result.data, 'body', '')
        }
      }

      return {
        status: 'success',
        data: _.get(result.data, 'body', null)
      }
    } catch (error) {
      return {
        status: 'failuer',
        data: String(error)
      }
    }
  }
}


export interface CallApiStyle {
  url: string,
  body: { [key: string]: string }
}
