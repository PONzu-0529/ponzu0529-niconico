<template>
  <div class="home">
    <h1 class="title is-1">{{ TITLE }}</h1>
    <div class="button-container">
      <div
        class="button-area"
        v-for="(item, index) in BUTTON_ITEM_LIST"
        :key="index"
      >
        <div
          class="button-item"
          @click="changePage(item.url)"
        >
          <div>
            <font-awesome-icon
              class="icon-size"
              :icon="['fa-solid', item.icon]"
            />
          </div>
          <br />
          <div class="subtitle is-4">{{ item.title }}</div>
          <div>{{ item.description }}</div>
        </div>
      </div>
    </div>
  </div>
</template>

<script lang="ts">
import _ from 'lodash';
import axios from 'axios';
import { Component, Vue } from 'vue-property-decorator';

@Component({})
export default class Home extends Vue {
  private TITLE = 'PONずの便利ツール箱';

  private BUTTON_ITEM_LIST: Array<ButtonItemStyle> = [
    {
      title: '乗り換え変換ツール',
      description: 'Yahooの乗り換えをコピペしやすい形に変換します。',
      icon: 'fa-train-subway',
      url: '/convert-transfers',
    },
    {
      title: '参考文献つくーる',
      description: '参考文献を作ります。',
      icon: 'fa-book',
      url: '/create-bibliography',
    },
    {
      title: 'ポケモンGO検索フィルターつくーる',
      description:
        'ポケモンGOのボックス内のポケモンを検索するフィルターを作ります。',
      icon: 'fa-gamepad',
      url: '/filter-in-pokemongo',
    },
    // {
    //   title: "ニコ動カスタムマイリスト",
    //   description: "ニコニコ動画のお気に入りの動画を確認できます。",
    //   icon: "fa-music",
    //   url: "/niconico-custom-mylist",
    // },
  ];

  private changePage(url: string): void {
    this.$router.push({
      path: url
    });
  }

  private async mounted() {
    await this.auth();
  }

  private async auth(): Promise<void> {
    const result = await axios({
      url: 'http://localhost/api/get-user-name',
      method: 'GET',
      headers: {
        Accept: 'application/json'
      }
    });

    const auth = _.get(result, 'data', '');
  }
}

interface ButtonItemStyle {
  title: string;
  description: string;
  icon: string;
  url: string;
}
</script>

<style lang="scss">
$pc: 1024px; // PC
$smartphone: 480px; // Smartphone

@mixin pc {
  @media (max-width: ($pc)) {
    @content;
  }
}

@mixin smartphone {
  @media (max-width: ($smartphone)) {
    @content;
  }
}

.button-container {
  display: flex;
  flex-wrap: wrap;
  margin-left: auto;
  margin-right: auto;
  width: 1024px;

  @include pc {
    width: auto;
  }
}

.button-area {
  width: 25%;

  @include pc {
    width: 33%;
  }

  @include smartphone {
    width: 50%;
  }
}

.button-item {
  background-color: lightcyan;
  cursor: pointer;
  margin: 10px;
}

.icon-size {
  font-size: 2.5em;
}
</style>
