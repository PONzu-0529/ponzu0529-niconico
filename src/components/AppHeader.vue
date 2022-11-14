<template>
  <div class="app-header nav">
    <div class="nav-left-item">
      <b-button class="back-button" @click="changeHome">ホームに戻る</b-button>
    </div>
    <div class="nav-right-item">
      <login @openLoginForm="openLoginForm" />
      <login-form @closeLoginForm="closeLoginForm" />
      <login-modal />
    </div>
  </div>
</template>

<script lang="ts">
import Login from "@/components/Login.vue"
import LoginForm from "@/components/LoginForm.vue"

import LoginModal from '@/components/modal/LoginModal.vue'

import { Component, Vue } from "vue-property-decorator"

@Component({
  components: {
    Login,
    LoginForm,
    LoginModal,
  },
})
export default class AppHeader extends Vue {
  private openLoginForm() {
    this.$modal.show("login-form")
  }
  private closeLoginForm() {
    this.$modal.hide("login-form")
  }

  private changeHome(): void {
    this.$router.push('/')
  }
}
</script>

<style lang="scss">
.nav {
  height: 40px;
  position: relative;
}

.nav-left-item {
  position: absolute;
  top: 0;
}

.nav-right-item {
  position: absolute;
  top: 0;
  right: 0;
}
</style>
