<template>
  <div class="links">
    <ul>
      <li>
        <a href="/convert-transfers">乗り換え変換ツール</a>
      </li>
      <li>
        <a href="/create-bibliography">参考文献つくーる</a>
      </li>
      <li>
        <a href="/filter-in-pokemongo">ポケモンGO検索フィルターつくーる</a>
      </li>
      <li v-if="loginStatus">
        <a href="/niconico-custom-mylist">ニコ動カスタムマイリスト</a>
      </li>
      <li>
        <a href="/check-todofuken">都道府県確認</a>
      </li>
    </ul>
  </div>
</template>

<script lang="ts">
import { userModule } from '@/store/modules/User';
import { Component, Vue } from 'vue-property-decorator';

@Component
export default class Links extends Vue {
  private get loginStatus(): boolean {
    return userModule.loginStatus;
  }
}
</script>

<style lang="scss" scoped>
.links {
  text-align: left;
}
</style>
