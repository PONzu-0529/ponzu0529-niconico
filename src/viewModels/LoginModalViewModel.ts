import { Component, Watch } from 'vue-property-decorator'
import ModalBase from '@/viewModels/ModalBase'
import { authModule } from '@/store/modules/AuthStore'

@Component({})
export class LoginModalViewModel extends ModalBase {
  protected email = '';
  protected password = '';
  protected lastAccessToken = '';
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

  protected async mounted(): Promise<void> {
    await this.checkAccessToken()
    this.reflectLoginStatus()
  }

  protected async loginAction(): Promise<void> {
    if (authModule.isLogin) {
      await this.logout()
      this.reflectLoginStatus()
    } else {
      this.openModal()
    }
  }

  protected async login(): Promise<void> {
    await authModule.login()

    if (!authModule.isLogin) {
      this.setIsDialog(true)
      this.dialogMessage = 'ログインに失敗しました。'
      return
    }

    this.closeModal()
    this.reflectLoginStatus()
  }

  protected async checkAccessToken(): Promise<void> {
    await authModule.checkAccessToken()
  }

  protected async logout(): Promise<void> {
    this.email = ''
    this.password = ''
    this.onChangeEmail()
    this.onChangePassword()
    await authModule.checkAccessToken()
  }

  protected reflectLoginStatus(): void {
    this.buttonLabel = !authModule.isLogin ? 'ログインする' : 'ログアウトする'
  }

  protected setIsDialog(status: boolean): void {
    this.isDialogOpen = status
  }
}
