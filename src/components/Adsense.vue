<template>
  <div class="l-adsense">
    <template v-if="!isDev">
      <component
        :is="'script'"
        async
        :src="`https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=${clientId}`"
        crossorigin="anonymous"
      ></component>
      <ins
        class="adsbygoogle"
        style="display:block"
        :data-ad-client="clientId"
        :data-ad-slot="slotNum"
        data-ad-format="auto"
        data-full-width-responsive="true"
      ></ins>
      <component :is="'script'">
        (adsbygoogle = window.adsbygoogle || []).push({});
      </component>
    </template>
  </div>
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
  private isDev: boolean;

  @Prop({
    default: ''
  })
  private slotNum: string;
}
</script>