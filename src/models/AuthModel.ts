import { AuthApiModel } from '@/models/apis/AuthApiModel';
import { ResponseStyle } from '@/models/ResponseStyle';


export class AuthModel implements AuthStyle {
  public name = ''
  public email = ''
  public password = ''
  public lastAccessToken = ''
  private authApiModel: AuthApiModel


  public constructor() {
    this.authApiModel = new AuthApiModel();
  }


  public async login(): Promise<ResponseStyle<string>> {
    const result = await this.authApiModel.getAccessTokenByEmail(this.email, this.password);

    if (result.status !== 'success') {
      return {
        status: 'failuer',
        data: result.data
      };
    }

    this.lastAccessToken = result.data;

    return {
      status: 'success',
      data: ''
    };
  }


  public async checkAccessToken(): Promise<ResponseStyle<boolean | string>> {
    return await this.authApiModel.checkAccessTokenByEmail(this.email, this.lastAccessToken);
  }
}

export interface AuthStyle {
  name?: string
  email: string
  password: string
  lastAccessToken: string
}
