<template>
  <modal :name="dialogName" :draggable="true" :clickToClose="false">
    <div class="dialog">
      <div>{{ message }}</div>
      <b-button @click="closeDialog">{{ buttonLabel }}</b-button>
    </div>
  </modal>
</template>

<script lang="ts">
import { Component, Prop } from "vue-property-decorator"
import { DialogBase } from "@/viewModels/DialogBase"

@Component({})
export default class AlertDialog extends DialogBase {
  @Prop({ default: "OK" })
  protected buttonLabel: string;
}
</script>

<style lang="scss">
.dialog {
  padding: 10px;
}
</style>
