<template>
  <div class="l-navigator">
    <div class="l-left-navigator">
      <button
        class="btn-medium"
        @click="clickHome"
      >Home</button>
    </div>

    <div class="l-right-navigator">
      <template v-if="isLogin">
        <button
          class="btn-medium"
          @click="clickLogout"
        >Logout</button>
      </template>
      <template v-else>
        <button
          class="btn-medium"
          @click="clickLogin"
        >Login</button>
        <button
          class="btn-medium"
          @click="clickRegister"
        >Register</button>
      </template>

      <form
        id="logout-form"
        :action="logoutActionPath"
        method="POST"
        class="d-none"
      >
        <input
          type="hidden"
          name="_token"
          :value="csrfToken"
        >
      </form>
    </div>
  </div>
</template>

<script lang="ts">
import { Component, Vue } from 'vue-property-decorator';
import AuthHelper from '@/Auth/AuthHelper';
import Utils from '@/common/Utils';

@Component({})
export default class AppNavigator extends Vue {
  private csrfToken: string;
  private userName: string;

  constructor() {
    super();

    this.csrfToken = '';
    this.userName = '';
  }

  private get isLogin(): boolean {
    return this.userName !== '';
  }

  private get logoutActionPath(): string {
    return `${Utils.getHostWithProtocol()}/logout`;
  }

  private async mounted(): Promise<void> {
    Utils.overlay();

    this.csrfToken = await AuthHelper.getCsrfToken();
    this.userName = await AuthHelper.getUserName();

    Utils.clearOverlay();
  }

  private async clickHome(): Promise<void> {
    await Utils.changePage(this.$router, '/');
  }

  private async clickLogin(): Promise<void> {
    await Utils.changePage(this.$router, '/login', false);
  }

  private async clickRegister(): Promise<void> {
    await Utils.changePage(this.$router, '/register', false);
  }

  private clickLogout(): void {
    (document.getElementById('logout-form') as HTMLFormElement).submit();
  }
}
</script>
