<template>
  <div>
    <b-button @click="loginAction">{{ buttonLabel }}</b-button>
    <modal :name="modalName">
      <div class="custom-modal">
        <h1 class="title">ログインフォーム</h1>
        <b-field horizontal label="ユーザー">
          <b-input custom-class="user" type="text" v-model="email" />
        </b-field>
        <b-field horizontal label="パスワード">
          <b-input custom-class="password" type="password" v-model="password" />
        </b-field>
        <b-field horizontal>
          <b-button @click="login">ログイン</b-button>
          <b-button @click="closeModal">閉じる</b-button>
        </b-field>
      </div>
    </modal>
    <alert-dialog
      dialogName="login-result"
      :isOpen="isDialogOpen"
      :message="dialogMessage"
      @setIsDialog="setIsDialog"
    />
  </div>
</template>

<script lang="ts">
import { Component } from "vue-property-decorator"
import AlertDialog from "@/components/dialogs/AlertDialog.vue"
import { LoginModalViewModel } from "@/viewModels/LoginModalViewModel"

@Component({
  components: {
    AlertDialog,
  },
})
export default class LoginModal extends LoginModalViewModel {}
</script>
