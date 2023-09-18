<template>
  <div class="modal-background">
    <div class="l-money-assistant-edit-modal modal-base">
      <div>
        <custom-input :option="titleInputOption" />
        日付:
      </div>
      <div>
        支払先:
        <custom-select-box
          :selectedValue="to"
          :option="toSelectBoxOption"
          @selected="handleToSelectBoxValue"
        />
        支払元:
        <custom-select-box
          :selectedValue="from"
          :option="fromSelectBoxOption"
          @selected="handleFromSelectBoxValue"
        />
      </div>
      <div>
        メモ:
      </div>
      <div class="l-table">
        <custom-simple-table
          :option="expenseItemTableOption"
          @clickPage="clickPage"
        />
      </div>
      <div class="l-option">
        <custom-button :option="registerButtonOption" />
        <custom-button :option="closeModalButtonOption" />
      </div>
    </div>
  </div>
</template>

<script lang="ts">
import { Component, Prop } from 'vue-property-decorator';
import _ from 'lodash';
import BaseView from '@/views/BaseView.vue';
import CustomButton, { CustomButtonOption } from '@/components/CustomButton.vue';
import CustomInput, { CustomInputOption } from '@/components/CustomInput.vue';
import CustomSelectBox, { CustomSelectBoxOption } from '@/components/CustomSelectBox.vue';
import CustomSimpleTable, { CustomTableOption } from '@/components/CustomSimpleTable.vue';

@Component({
  components: {
    CustomButton,
    CustomInput,
    CustomSelectBox,
    CustomSimpleTable
  }
})
export default class MoneyAssistantEditModal extends BaseView {
  @Prop()
  private option: MoneyAssistantEditModalOption;

  private title: string;
  private titleInputOption: CustomInputOption = {
    value: '',
    placeholder: 'タイトル',
    handleInput: this.handleTitleInput
  }

  private date: Date;

  private to: string;
  private toSelectBoxOption: CustomSelectBoxOption = {
    name: 'ToSelectBox',
    size: 1,
    items: [
      {
        label: 'To1'
      },
      {
        label: 'To2'
      }
    ]
  }

  private from: string;
  private fromSelectBoxOption: CustomSelectBoxOption = {
    name: 'FromSelectBox',
    size: 1,
    items: [
      {
        label: 'From1'
      },
      {
        label: 'From2'
      }
    ]
  }

  private memo: string;

  private registerButtonOption: CustomButtonOption = {
    label: '更新',
    click: this.clickRegisterButton
  }

  private closeModalButtonOption: CustomButtonOption = {
    label: '閉じる',
    click: this.clickCloseModalButton
  }

  private expenseItemTableOption: CustomTableOption = {
    head: [
      {
        value: '名称'
      },
      {
        value: 'ジャンル'
      },
      {
        value: '金額'
      },
    ],
    body: [[]],
    currentPage: 1,
    pageList: [],
    widthList: [300, 200, 200],
  }

  constructor() {
    super();

    this.title = '';
    this.date = new Date();
    this.to = '';
    this.from = '';
    this.memo = '';
  }

  private async mounted(): Promise<void> {
    this.clickPage(1);
  }

  private handleTitleInput(event: InputEvent): void {
    this.title = (event.target as HTMLInputElement).value;
  }

  private handleToSelectBoxValue(value: string): void {
    this.to = value;
  }

  private handleFromSelectBoxValue(value: string): void {
    this.from = value;
  }

  private clickPage(index: number): void {
    _.noop();
  }

  private clickRegisterButton(): void {
    this.option.clickCloseModalButton();
  }

  private clickCloseModalButton(): void {
    this.option.clickCloseModalButton();
  }
}

export interface MoneyAssistantEditModalOption {
  clickCloseModalButton: () => void;
}
</script>
