<template>
  <div class="filter-in-pokemongo">
    <h1 class="title">ポケモンGO検索フィルターつくーる</h1>
    <p>※非公式ツールです</p>
    <div class="flex-container">
      <div class="flex-item">
        <h2 class="subtitle">条件</h2>
        <div>
          <b-checkbox v-model="statusGroup" native-value="color">
            色違い
          </b-checkbox>
          <b-checkbox v-model="statusGroup" native-value="legend">
            伝説
          </b-checkbox>
          <b-checkbox v-model="statusGroup" native-value="date">
            日付
          </b-checkbox>
        </div>
        <div class="left">
          <b-field>
            <b-switch
              v-if="statusGroup.indexOf('color') !== -1"
              v-model="isColor"
            >
              色違い
            </b-switch>
          </b-field>
          <b-field>
            <b-switch
              v-if="statusGroup.indexOf('legend') !== -1"
              v-model="isLegend"
            >
              伝説
            </b-switch>
          </b-field>
          <b-field
            v-if="statusGroup.indexOf('date') !== -1"
            horizontal
            label="日付"
          >
            <b-input v-model="date" type="number" />
          </b-field>
        </div>
      </div>
      <div class="flex-item">
        <h2 class="subtitle">結果</h2>
        <b-field>
          <b-input type="textarea" v-model="output" />
        </b-field>
        <b-field>
          <b-button class="success-button" @click="copy">コピー</b-button>
        </b-field>
      </div>
    </div>
  </div>
</template>

<script lang="ts">
import { Vue, Component } from 'vue-property-decorator';

@Component
export default class FilterInPokemonGo extends Vue {
  private statusGroup: Array<string> = []
  private isColor = false
  private isLegend = false
  private date = 1

  private get output(): string {
    let options: Array<string> = [];

    if (this.statusGroup.indexOf('color') !== -1) {
      options.push(this.isColor ? '色違い' : '!色違い');
    }

    if (this.statusGroup.indexOf('legend') !== -1) {
      options.push(this.isLegend ? '伝説のポケモン' : '!伝説のポケモン');
    }

    if (this.statusGroup.indexOf('date') !== -1) {
      options.push(`日数-${this.date}`);
    }

    return options.join('&');
  }

  /**
   * コピー
   */
  private async copy() {
    await navigator.clipboard.writeText(this.output);
  }
}
</script>
