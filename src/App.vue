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

      <div class="l-adsense-1">
        <adsense
          :clientId="clientId"
          :slotNum="slotNum1"
        />
      </div>

      <router-view />

      <div class="l-adsense-2">
        <adsense
          :clientId="clientId"
          :slotNum="slotNum2"
        />
      </div>
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

  public constructor() {
    super();

    this.clientId = '';
    this.slotNum1 = '';
    this.slotNum2 = '';
  }

  private async created(): Promise<void> {
    this.clientId = await SettingHelper.getSetting('ADSENCE_CLIENT_ID');
    this.slotNum1 = await SettingHelper.getSetting('ADSENCE_SLOT_NUM1');
    this.slotNum2 = await SettingHelper.getSetting('ADSENCE_SLOT_NUM2');
  }

  private mounted(): void {
    TitleHelper.setTitleByPath(location.pathname);
  }

  private changeHome(): void {
    this.$router.push({
      path: '/'
    });
  }
}
</script>

<style lang="scss">
$pc: 1024px; // PC
$tablet: 680px; // Tablet
$smartphone: 480px; // Smartphone

@mixin pc {
  @media (max-width: ($pc)) {
    @content;
  }
}

@mixin tablet {
  @media (max-width: ($tablet)) {
    @content;
  }
}

@mixin smartphone {
  @media (max-width: ($smartphone)) {
    @content;
  }
}

#app {
  margin: 10px;
}

#app-main {
  font-family: Avenir, Helvetica, Arial, sans-serif;
  -webkit-font-smoothing: antialiased;
  -moz-osx-font-smoothing: grayscale;
  text-align: center;
  color: #2c3e50;
}

.flex-container {
  display: flex;
  justify-content: center;

  @include smartphone {
    display: block;
  }
}

.flex-item {
  margin: 0 auto;
  width: 500px;

  @include pc {
    width: 330px;
  }

  @include tablet {
    width: 230px;
  }

  @include smartphone {
    margin: 0 auto 50px;
  }
}

.normal-button {
  background-color: lime !important;
  margin: 10px !important;
}

.success-button {
  background-color: lightskyblue !important;
  margin: 10px !important;
}

.danger-button {
  background-color: lightcoral !important;
  margin: 10px !important;
}

.custom-modal {
  padding: 10px;
}

.vm--modal {
  height: initial !important;

  @include tablet {
    left: 0px !important;
    margin: auto;
    width: 480px !important;
  }

  @include smartphone {
    left: 0px !important;
    margin: auto;
    width: 100% !important;
  }
}
</style>
