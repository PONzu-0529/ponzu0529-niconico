import { Module as Mod } from 'vuex';
import { Module, VuexModule, Mutation, Action, getModule } from 'vuex-module-decorators';
import store from '@/store/index';
import { AuthModel } from '@/models/AuthModel';

@Module({
  dynamic: true,
  store: store,
  name: 'AuthStore',
  namespaced: true,
})
export class AuthStore extends VuexModule {
  public auth: AuthModel
  public isLogin = false

  /* eslint-disable */
  constructor(module: Mod<ThisType<any>, any>) {
    super(module)
    this.auth = new AuthModel()
  }

  @Mutation
  public setEmail(email: string): void {
    this.auth.email = email
  }

  @Mutation
  public setPassword(password: string): void {
    this.auth.password = password
  }

  @Mutation
  public setLastAccessToken(lastAccessToken: string): void {
    this.auth.lastAccessToken = lastAccessToken
  }

  @Mutation
  private setIsLogin(status: boolean): void {
    this.isLogin = status
  }

  @Action({ rawError: true })
  public async login(): Promise<void> {
    const result = await this.auth.login()

    if (result.status !== 'success') {
      this.setIsLogin(false)
    } else {
      this.setIsLogin(true)
    }
  }

  @Action({ rawError: true })
  public async checkAccessToken(): Promise<void> {
    const result = await this.auth.checkAccessToken()

    if (result.status !== 'success') {
      this.setIsLogin(false)
    } else {
      this.setIsLogin(true)
    }
  }
}


export const authModule = getModule(AuthStore)
