<template>
  <div class="l-content half">
    <div
      class="l-half-left-title"
      @click="leftClick"
    >Before</div>
    <div
      class="l-half-right-title"
      @click="rightClick"
    >After</div>
    <template v-if="!(isSmartphone && !isLeft)">
      <div class="l-half-left-content">
        <div class="l-convert-transfers-content">
          <div class="l-convert-transfers-main">
            <textarea v-model="input"></textarea>
          </div>
          <div class="l-convert-transfers-option">
            <button
              class="btn-medium"
              @click="read"
            >Read</button>
            <button
              class="btn-medium"
              @click="convert"
            >Convert</button>
          </div>
        </div>
      </div>
    </template>
    <template v-if="!(isSmartphone && isLeft)">
      <div class="l-half-right-content">
        <div class="l-convert-transfers-content">
          <div class="l-convert-transfers-main">
            <textarea v-model="output"></textarea>
          </div>
          <div class="l-convert-transfers-option">
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
export default class ConvertTransfer extends BaseView {
  private input = '';
  private output = '';

  private convert() {
    this.output = this.input
      .slice(this.input.indexOf('■'), this.input.indexOf('(運賃内訳)'))
      .replace('---\n', '');
  }

  /**
   * 読み込み
   */
  private async read() {
    this.input = await navigator.clipboard.readText();
  }

  /**
   * コピー
   */
  private async copy() {
    await navigator.clipboard.writeText(this.output);
  }
}
</script>
