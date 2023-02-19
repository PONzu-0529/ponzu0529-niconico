import { Module, VuexModule, Mutation, getModule } from 'vuex-module-decorators';
import store from '@/store/index';

@Module({
  dynamic: true,
  store: store,
  name: 'User',
  namespaced: true,
})
export default class User extends VuexModule {
  public loginStatus = false

  @Mutation
  public loginSuccess(): boolean {
    this.loginStatus = true;
    return this.loginStatus;
  }

  @Mutation
  public loginFailure(): boolean {
    this.loginStatus = false;
    return this.loginStatus;
  }
}

export const userModule = getModule(User);
