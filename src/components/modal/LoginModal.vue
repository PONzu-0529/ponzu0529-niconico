<template>
  <div>
    <b-button @click="openModal">{{ buttonLabel }}</b-button>
    <modal :name="modalName">
      <div class="custom-modal">
        <h1 class="title">ログインフォーム</h1>
        <b-field horizontal label="ユーザー">
          <b-input custom-class="user" type="text" />
        </b-field>
        <b-field horizontal label="パスワード">
          <b-input custom-class="password" type="password" />
        </b-field>
        <b-field horizontal>
          <b-button>ログイン</b-button>
          <b-button @click="closeModal">閉じる</b-button>
        </b-field>
      </div>
    </modal>
  </div>
</template>

<script lang="ts">
import LoginModalViewModel from "@/viewModels/LoginModalViewModel"
import { Component } from "vue-property-decorator"

@Component({})
export default class LoginModal extends LoginModalViewModel {}
</script>
