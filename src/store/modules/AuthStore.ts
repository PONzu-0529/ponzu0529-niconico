import { Module as Mod } from 'vuex'
import { Module, VuexModule, Mutation, Action, getModule } from 'vuex-module-decorators'
import store from '@/store/index'
import { AuthModel } from '@/models/AuthModel'
import { ResponseStyle } from '@/models/ResponseStyle'

@Module({
  dynamic: true,
  store: store,
  name: 'User',
  namespaced: true,
})
export class AuthStore extends VuexModule {
  public auth: AuthModel

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

  @Action({ rawError: true })
  public async login(): Promise<ResponseStyle> {
    return await this.auth.login()
  }

  @Action({ rawError: true })
  public async checkAccessToken(): Promise<ResponseStyle<boolean | string>> {
    return await this.auth.checkAccessToken()
  }
}


export const authModule = getModule(AuthStore)
