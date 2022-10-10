<template>
  <div class="convert_transfer">
    <h1 class="title">乗り換え変換ツール</h1>
    <div>
      <textarea
        id="input"
        style="width: 500px; height: 200px"
        v-model="input"
      ></textarea>
    </div>
    <div>
      <b-button id="convert" @click="convert()">変換</b-button>
    </div>
    <div>
      <textarea
        id="output"
        style="width: 500px; height: 200px"
        v-model="output"
      ></textarea>
    </div>
  </div>
</template>

<script lang="ts">
import { Vue, Component } from "vue-property-decorator"

@Component
export default class ConvertTransfer extends Vue {
  private input = ""
  private output = ""

  private convert() {
    this.output = this.input
      .slice(this.input.indexOf("■"), this.input.indexOf("(運賃内訳)"))
      .replace("---\n", "")
  }
}
</script>
