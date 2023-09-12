<template>
  <div>
    <div>
      <custom-button
        :option="defaultButton"
        @clickEvent="() => {}"
      />
    </div>
    <div>
      <custom-button
        :option="disabledButton"
        @clickEvent="() => {}"
      />
    </div>
  </div>
</template>

<script lang="ts">
import { Component } from 'vue-property-decorator';
import BaseView from '@/views/BaseView.vue';
import CustomButton, { CustomButtonOption } from '@/components/CustomButton.vue';

@Component({
  components: {
    CustomButton
  }
})
export default class Test extends BaseView {
  private defaultButton: CustomButtonOption = {
    label: 'DefaultButton',
    click: () => { alert('Clicked!!!'); }
  }

  private disabledButton: CustomButtonOption = {
    label: 'DisabledButton',
    disabled: true,
    click: () => { return; }
  }
}
</script>
