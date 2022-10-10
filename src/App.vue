<template>
  <div id="app">
    <login @openLoginForm="openLoginForm" />
    <login-form @closeLoginForm="closeLoginForm" />
    <router-view />
  </div>
</template>

<script lang="ts">
import Login from "@/components/Login.vue"
import LoginForm from "@/components/LoginForm.vue"
import { Vue, Component } from "vue-property-decorator"

@Component({
  components: {
    Login,
    LoginForm,
  },
})
export default class App extends Vue {
  private openLoginForm() {
    this.$modal.show("login-form")
  }

  private closeLoginForm() {
    this.$modal.hide("login-form")
  }
}
</script>

<style lang="scss">
$pc: 1024px; // PC
$tablet: 680px; // Tablet
$smartphone: 480px; // Smartphone

@mixin pc {
  @media (max-width: ($pc)) {
    @content;
  }
}

@mixin tablet {
  @media (max-width: ($tablet)) {
    @content;
  }
}

@mixin smartphone {
  @media (max-width: ($smartphone)) {
    @content;
  }
}

#app {
  font-family: Avenir, Helvetica, Arial, sans-serif;
  -webkit-font-smoothing: antialiased;
  -moz-osx-font-smoothing: grayscale;
  text-align: center;
  color: #2c3e50;
}

.flex-container {
  display: flex;
  justify-content: center;

  @include smartphone {
    display: block;
  }
}

.flex-item {
  margin: 0 auto;
  width: 500px;

  @include pc {
    width: 330px;
  }

  @include tablet {
    width: 230px;
  }

  @include smartphone {
    margin: 0 auto 50px;
  }
}

.normal-button {
  background-color: lime !important;
  margin: 10px !important;
}

.success-button {
  background-color: lightskyblue !important;
  margin: 10px !important;
}

.danger-button {
  background-color: lightcoral !important;
  margin: 10px !important;
}

.custom-modal {
  padding: 10px;
}

.vm--modal {
  height: initial !important;

  @include tablet {
    left: 0px !important;
    margin: auto;
    width: 480px !important;
  }

  @include smartphone {
    left: 0px !important;
    margin: auto;
    width: 100% !important;
  }
}
</style>
