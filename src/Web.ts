import _ from "lodash"
import axios, { AxiosRequestConfig } from "axios"

export default class Web {
  private static get url(): string {
    switch (process.env.NODE_ENV) {
      case "development": {
        return "http://localhost"
      }

      case "production": {
        return "https://tools.ponzu0529.com"
      }

      default: {
        return "http://localhost"
      }
    }
  }

  static async getWebInfo(target_url: string): Promise<string | boolean> {
    const options: AxiosRequestConfig = {
      url: `${this.url}/api/get-web-info`,
      method: "POST",
      data: {
        url: target_url
      },
    }

    const result = await axios(options)

    if (_.get(result, 'data.status', '') !== 'success') {
      return false
    }

    return _.get(result, 'data.title', '')
  }
}
