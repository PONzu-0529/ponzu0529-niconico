<template>
  <ins
    class="adsbygoogle"
    style="display:block"
    :data-ad-client="clientId"
    :data-ad-slot="slotNum"
    data-ad-format="auto"
    data-full-width-responsive="true"
  ></ins>
</template>

<script lang="ts">
import { Vue, Component, Prop } from 'vue-property-decorator';

@Component({})
export default class Adsense extends Vue {
  @Prop({
    default: ''
  })
  private clientId: string;

  @Prop({
    default: ''
  })
  private slotNum: string;
}
</script>