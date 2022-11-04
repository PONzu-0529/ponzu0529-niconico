import _ from 'lodash'
import axios from 'axios'

import ResponseModel from '@/models/ResponseModel'


export class ApiModel {
  public static get_host(): string {
    switch (process.env.NODE_ENV) {
      case "development": {
        return "http://127.0.0.1"
      }

      case "production": {
        return "https://dev-tools.ponzu0529.com"
      }

      default: {
        return "http://127.0.0.1"
      }
    }
  }


  public static async callApi(callApiStyle: CallApiStyle): Promise<ResponseModel> {
    try {
      const result = await axios.post(callApiStyle.url, callApiStyle.body)

      if (result.status !== 200) {
        throw new Error(result.statusText)
      }

      if (_.get(result.data, 'status', '') !== 'success') {
        return {
          status: 'failuer',
          body: _.get(result.data, 'body', '')
        }
      }

      return {
        status: 'success',
        body: _.get(result.data, 'body', null)
      }
    } catch (error) {
      return {
        status: 'failuer',
        body: String(error)
      }
    }
  }
}


export interface CallApiStyle {
  url: string,
  body: { [key: string]: string }
}
