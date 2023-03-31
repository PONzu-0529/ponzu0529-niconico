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
      <div class="l-half-left-content"></div>
    </template>
    <template v-if="!(isSmartphone && isLeft)">
      <div class="l-half-right-content"></div>
    </template>
  </div>
</template>

<script lang="ts">
import { Vue, Component } from 'vue-property-decorator';

@Component({})
export default class BaseView extends Vue {
  protected isLeft: boolean;

  public constructor() {
    super();

    this.isLeft = true;
  }

  protected get isSmartphone(): boolean {
    return document.body.clientWidth < 480;
  }

  protected leftClick(): void {
    this.isLeft = true;
  }

  protected rightClick(): void {
    this.isLeft = false;
  }
}
</script>