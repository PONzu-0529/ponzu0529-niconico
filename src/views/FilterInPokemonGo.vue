<template>
  <div class="l-content half">
    <div
      class="l-half-left-title"
      @click="leftClick"
    >Condition</div>
    <div
      class="l-half-right-title"
      @click="rightClick"
    >Result</div>
    <template v-if="!(isSmartphone && !isLeft)">
      <div class="l-half-left-content">
        <div class="l-pokemongo-filter-content">
          <div class="l-pokemongo-filter-top">
            <div>
              <input
                type="checkbox"
                v-model="checkColor"
              >
              <label>色違い</label>
            </div>
            <div>
              <input
                type="checkbox"
                v-model="checkLegend"
              >
              <label>伝説</label>
            </div>
            <div>
              <input
                type="checkbox"
                v-model="checkDate"
              >
              <label>日付</label>
            </div>
          </div>
          <div class="l-pokemongo-filter-main left">
            <div
              class="l-pokemongo-filter-main-column"
              v-if="checkColor"
            >
              <div class="l-pokemongo-filter-main-key">色違い</div>
              <div class="l-pokemongo-filter-main-value">
                <input
                  type="checkbox"
                  v-model="isColor"
                >
              </div>
            </div>
            <div
              class="l-pokemongo-filter-main-column"
              v-if="checkLegend"
            >
              <div class="l-pokemongo-filter-main-key">伝説</div>
              <div class="l-pokemongo-filter-main-value">
                <input
                  type="checkbox"
                  v-model="isLegend"
                >
              </div>
            </div>
            <div
              class="l-pokemongo-filter-main-column"
              v-if="checkDate"
            >
              <div class="l-pokemongo-filter-main-key">Date</div>
              <div class="l-pokemongo-filter-main-value">
                <input
                  v-model="date"
                  type="number"
                >
              </div>
            </div>
          </div>
        </div>
      </div>
    </template>
    <template v-if="!(isSmartphone && isLeft)">
      <div class="l-half-right-content">
        <div class="l-pokemongo-filter-content">
          <div class="l-pokemongo-filter-main right">
            <textarea v-model="output"></textarea>
          </div>
          <div class="l-pokemongo-filter-option">
            <button
              class="btn-medium"
              @click="copy"
            >Copy</button>
          </div>
        </div>
      </div>
    </template>
  </div>
</template>

<script lang="ts">
import { Component } from 'vue-property-decorator';
import BaseView from '@/views/BaseView.vue';

@Component
export default class FilterInPokemonGo extends BaseView {
  private checkColor: boolean;
  private checkLegend: boolean;
  private checkDate: boolean;
  private isColor = false
  private isLegend = false
  private date = 1

  public constructor() {
    super();

    this.checkColor = false;
    this.checkLegend = false;
    this.checkDate = false;
  }

  private get output(): string {
    let options: Array<string> = [];

    if (this.checkColor) {
      options.push(this.isColor ? '色違い' : '!色違い');
    }

    if (this.checkLegend) {
      options.push(this.isLegend ? '伝説のポケモン' : '!伝説のポケモン');
    }

    if (this.checkDate) {
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
