<template>
  <div class="nav">
    <div class="nav-item">
      <p v-if="loginStatus">ログインしています</p>
      <p v-else>
        ログインしていません
        <button @click="openLoginForm">ログインする</button>
      </p>
    </div>
  </div>
</template>

<script lang="ts">
import { userModule } from "@/store/modules/User"
import User from "@/User"
import { Vue, Component, Emit } from "vue-property-decorator"

@Component
export default class Login extends Vue {
  private get loginStatus(): boolean {
    return userModule.loginStatus
  }

  @Emit("openLoginForm")
  private openLoginForm() {
    return
  }

  private async created() {
    await User.checkAccessToken()
  }
}
</script>

<style lang="scss">
.nav {
  height: 30px;
  position: relative;
}

.nav-item {
  position: absolute;
  right: 0;
}
</style>
