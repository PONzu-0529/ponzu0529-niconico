<template>
  <div class="login">
    <p v-if="loginStatus">ログインしています</p>
    <p v-else>
      ログインしていません
      <b-button @click="openLoginForm">ログインする</b-button>
    </p>
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
