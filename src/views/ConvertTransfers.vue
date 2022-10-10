<template>
  <div class="convert_transfer">
    <h1 class="title">乗り換え変換ツール</h1>
    <div class="flex-container">
      <div class="flex-item">
        <b-field>
          <b-input id="input" type="textarea" v-model="input"></b-input>
        </b-field>
        <b-field>
          <div>
            <b-button class="normal-button" @click="read">読み込み</b-button>
            <b-button class="success-button" @click="convert">変換</b-button>
          </div>
        </b-field>
      </div>
      <div class="flex-item">
        <b-field>
          <b-input id="output" type="textarea" v-model="output"></b-input>
        </b-field>
        <b-field>
          <b-button class="success-button" @click="copy">コピー</b-button>
        </b-field>
      </div>
    </div>
  </div>
</template>

<script lang="ts">
import { Vue, Component } from "vue-property-decorator"

@Component
export default class ConvertTransfer extends Vue {
  private input = "";
  private output = "";

  private convert() {
    this.output = this.input
      .slice(this.input.indexOf("■"), this.input.indexOf("(運賃内訳)"))
      .replace("---\n", "")
  }

  /**
   * 読み込み
   */
  private async read() {
    this.input = await navigator.clipboard.readText()
  }

  /**
   * コピー
   */
  private async copy() {
    await navigator.clipboard.writeText(this.output)
  }
}
</script>
