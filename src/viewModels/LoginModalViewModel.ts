import { Component, Watch } from 'vue-property-decorator'
import ModalBase from '@/viewModels/ModalBase'
import { authModule } from '@/store/modules/AuthStore'

@Component({})
export class LoginModalViewModel extends ModalBase {
  protected email = '';
  protected password = '';
  protected lastAccessToken = '';
  protected isLogin = false;
  protected modalName = 'login-modal';
  protected isDialogOpen = false
  protected dialogMessage = ''

  @Watch('email')
  protected onChangeEmail(): void {
    authModule.setEmail(this.email)
  }

  @Watch('password')
  protected onChangePassword(): void {
    authModule.setPassword(this.password)
  }

  @Watch('lastAccessToken')
  protected onChangeLastAccessToken(): void {
    authModule.setLastAccessToken(this.lastAccessToken)
  }

  @Watch('isLogin')
  protected onChangeIsLogin(): void {
    this.reflectLoginStatus()
  }

  protected async mounted(): Promise<void> {
    await this.checkAccessToken()
    this.reflectLoginStatus()
  }

  protected loginAction(): void {
    if (this.isLogin) {
      this.logout()
      this.reflectLoginStatus()
    } else {
      this.openModal()
    }
  }

  protected async login(): Promise<void> {
    const result = await authModule.login()

    if (result.status !== 'success') {
      this.setIsDialog(true)
      this.dialogMessage = 'ログインに失敗しました。'
      return
    }

    this.isLogin = true
    this.closeModal()
    this.reflectLoginStatus()
  }

  protected async checkAccessToken(): Promise<void> {
    const result = await authModule.checkAccessToken()

    if (result.status !== 'success') {
      this.isLogin = false
    } else {
      this.isLogin = true
    }
  }

  protected logout(): void {
    this.email = ''
    this.password = ''
    this.lastAccessToken = ''
    this.isLogin = false
  }

  protected reflectLoginStatus(): void {
    this.buttonLabel = !this.isLogin ? 'ログインする' : 'ログアウトする'
  }

  protected setIsDialog(status: boolean): void {
    this.isDialogOpen = status
  }
}
