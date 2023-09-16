<template>
  <div class="l-content">
    <money-assistant-edit-modal
      v-show="editModalOpen"
      :option="editModalOption"
    />
    <div class="l-money-assistant-option">
      <custom-button :option="addRecordButtonOption" />
    </div>
    <div class="l-money-assistant-main">
    </div>
  </div>
</template>

<script lang="ts">
import { Component } from 'vue-property-decorator';
import BaseView from '@/views/BaseView.vue';
import CustomButton, { CustomButtonOption } from '@/components/CustomButton.vue';
import MoneyAssistantEditModal, { MoneyAssistantEditModalOption } from '@/components/modal/MoneyAssistantEditModal.vue';

@Component({
  components: {
    CustomButton,
    MoneyAssistantEditModal
  }
})
export default class MoneyAssistant extends BaseView {
  private editModalOpen: boolean;

  private editModalOption: MoneyAssistantEditModalOption = {
    clickCloseModalButton: this.clickCloseModalButton
  }

  private addRecordButtonOption: CustomButtonOption = {
    label: '追加',
    click: this.clickAddRecordButton
  }

  constructor() {
    super();

    this.editModalOpen = false;
  }

  private clickCloseModalButton(): void {
    this.editModalOpen = false;
  }

  private async clickAddRecordButton(): Promise<void> {
    this.editModalOpen = true;
  }
}
</script>
