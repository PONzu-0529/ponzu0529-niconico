import ModalBase from '@/viewModels/ModalBase'
import { Component, Watch } from 'vue-property-decorator'

@Component({})
export default class LoginModalViewModel extends ModalBase {
  protected isLogin = false;
  protected modalName = 'login-modal';

  @Watch('isLogin')
  protected onChangeIsLogin(): void {
    this.reflectLoginStatus()
  }

  protected mounted(): void {
    this.reflectLoginStatus()
  }

  protected reflectLoginStatus(): void {
    this.buttonLabel = !this.isLogin ? 'ログインする' : 'ログアウトする'
  }
}
