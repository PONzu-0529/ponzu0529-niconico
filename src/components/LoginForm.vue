<template>
  <modal name="login-form">
    <div class="custom-modal">
      <h1 class="title">ログインフォーム</h1>
      <form>
        <b-field horizontal label="ユーザー">
          <b-input custom-class="user" type="text" v-model="account.name"></b-input>
        </b-field>
        <b-field horizontal label="パスワード">
          <b-input custom-class="password" type="text" v-model="account.password"></b-input>
        </b-field>
        <b-field horizontal>
          <b-button @click="login">ログイン</b-button>
          <b-button @click="closeLoginForm">閉じる</b-button>
        </b-field>
      </form>
    </div>
  </modal>
</template>

<script lang="ts">
import _ from "lodash"
import axios, { AxiosRequestConfig } from "axios"
import User from "@/User"
import { Vue, Component, Emit } from "vue-property-decorator"

@Component
export default class Login extends Vue {
  @Emit("closeLoginForm")
  private closeLoginForm() {
    return
  }

  private account: AccountStyle = {
    name: "",
    password: "",
  };

  private get url(): string {
    switch (process.env.NODE_ENV) {
      case "development": {
        return "http://localhost"
      }

      case "production": {
        return "https://tools.ponzu0529.com"
      }

      default: {
        return "http://localhost"
      }
    }
  }

  private async login() {
    const options: AxiosRequestConfig = {
      url: `${this.url}/GetAccessToken.php`,
      method: "POST",
      data: {
        name: this.account.name,
        password: this.account.password,
      },
    }

    await axios(options)
      .then(async (res) => {
        const { data } = res

        if (_.get(data, "status", "") !== "success") {
          alert(_.get(data, "message", "Login failed."))
        }

        localStorage.setItem("accessToken", _.get(data, "access_token", ""))

        this.closeLoginForm()

        await User.checkAccessToken()
      })
      .catch((err) => {
        console.log("err:", err)
      })
  }
}

interface AccountStyle {
  name: string;
  password: string;
}
</script>
