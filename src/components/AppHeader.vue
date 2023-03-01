<template>
  <div class="app-header nav">
    <div class="nav-left-item">
      <b-button class="back-button" @click="changeHome">ホームに戻る</b-button>
    </div>
    <div class="nav-right-item">
      <login-modal />
    </div>
  </div>
</template>

<script lang="ts">
import { Component, Vue } from 'vue-property-decorator';
import LoginModal from '@/components/modal/LoginModal.vue';

@Component({
  components: {
    LoginModal
  }
})
export default class AppHeader extends Vue {
  private changeHome(): void {
    this.$router.push('/');
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
