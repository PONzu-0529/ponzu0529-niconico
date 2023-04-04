<template>
  <div
    id="app"
    class="l-app"
  >
    <!-- Navigator -->
    <app-navigator />

    <!-- Main -->
    <div class="l-main">
      <div
        id="ponzu-tools-title"
        class="l-title"
      >Top</div>

      <adsense
        :clientId="clientId"
        :isDev="isDev"
        :slotNum="slotNum1"
        v-if="!isSmartphone"
      />

      <router-view />

      <adsense
        :clientId="clientId"
        :isDev="isDev"
        :slotNum="slotNum2"
      />
    </div>

    <!-- Overlay -->
    <div
      class="overlay"
      style="display: none;"
    />
  </div>
</template>

<script lang="ts">
import AppNavigator from '@/Navigator/AppNavigator.vue';
import { Vue, Component } from 'vue-property-decorator';
import Adsense from '@/components/Adsense.vue';
import Utils from '@/common/Utils';
import SettingHelper from '@/helpers/SettingHelper';
import TitleHelper from '@/helpers/TitleHelper';

@Component({
  components: {
    Adsense,
    AppNavigator,
  },
})
export default class App extends Vue {
  private clientId: string;
  private slotNum1: string;
  private slotNum2: string;
  private isDev: boolean;

  public constructor() {
    super();

    this.clientId = '';
    this.slotNum1 = '';
    this.slotNum2 = '';
    this.isDev = true;
  }

  private async created(): Promise<void> {
    this.clientId = await SettingHelper.getSetting('ADSENCE_CLIENT_ID');
    this.slotNum1 = await SettingHelper.getSetting('ADSENCE_SLOT_NUM1');
    this.slotNum2 = await SettingHelper.getSetting('ADSENCE_SLOT_NUM2');
    this.isDev = Utils.getEnv() === 'development';
  }

  private mounted(): void {
    window.addEventListener('resize', () => {
      window.location.reload();
    });

    TitleHelper.setTitleByPath(location.pathname);
  }

  private get isSmartphone(): boolean {
    return Utils.isSmartphone();
  }

  private changeHome(): void {
    this.$router.push({
      path: '/'
    });
  }
}
</script>
