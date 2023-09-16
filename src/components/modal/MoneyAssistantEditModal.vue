<template>
  <div class="modal-background">
    <div class="modal-base">
      <div class="l-money-assistant-edit-modal-option">
        <custom-button :option="closeModalButtonOption" />
      </div>
      <div class="l-money-assistant-edit-modal-main">
      </div>
    </div>
  </div>
</template>

<script lang="ts">
import { Component, Prop } from 'vue-property-decorator';
import BaseView from '@/views/BaseView.vue';
import CustomButton, { CustomButtonOption } from '@/components/CustomButton.vue';

@Component({
  components: {
    CustomButton
  }
})
export default class MoneyAssistantEditModal extends BaseView {
  @Prop()
  private option: MoneyAssistantEditModalOption;

  private closeModalButtonOption: CustomButtonOption = {
    label: '閉じる',
    click: this.clickCloseModalButton
  }

  private clickCloseModalButton(): void {
    this.option.clickCloseModalButton();
  }
}

export interface MoneyAssistantEditModalOption {
  clickCloseModalButton: () => void;
}
</script>
