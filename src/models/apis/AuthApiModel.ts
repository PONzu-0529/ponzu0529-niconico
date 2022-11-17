import { ResponseStyle } from '@/models/ResponseStyle'

import { ApiModel } from '@/models/apis/ApiModel'

export class AuthApiModel extends ApiModel {
  public async getAccessTokenByEmail(email: string, password: string): Promise<ResponseStyle<string>> {
    const callApiResult = await this.callApi({
      url: `${ApiModel.getHost()}/api/v2/auth/get-access-token-by-email`,
      body: {
        email: email,
        password: password
      }
    })

    if (callApiResult.status !== 'success') {
      return {
        status: 'failuer',
        data: String(callApiResult.data)
      }
    }

    if (typeof callApiResult.data !== 'string') {
      return {
        status: 'failuer',
        data: ''
      }
    } else {
      return {
        status: 'success',
        data: callApiResult.data
      }
    }
  }


  public async checkAccessTokenByEmail(email: string, accessToken: string): Promise<ResponseStyle<boolean|string>> {
    const callApiResult = await this.callApi({
      url: `${ApiModel.getHost()}/api/v2/auth/check-access-token-by-email`,
      body: {
        email: email,
        accessToken: accessToken
      }
    })

    if (callApiResult.status !== 'success') {
      return {
        status: 'failuer',
        data: String(callApiResult.data)
      }
    } else {
      return {
        status: 'success',
        data: true
      }
    }
  }
}
