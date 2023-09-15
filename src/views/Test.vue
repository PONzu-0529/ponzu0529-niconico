<template>
  <div class="l-content">
    <div>
      <custom-button :option="defaultButton" />
    </div>
    <div>
      <custom-button :option="disabledButton" />
    </div>
    <br>
    <div>
      DefaultSelectBox:
      <custom-select-box
        :option="defaultSelectBox"
        :selectedValue="defaultSelectBoxValue"
        @selected="handleDefaultSelectBoxValue"
      />
      : {{ defaultSelectBoxValue }}
    </div>
    <div>
      DisabledSelectBox:
      <custom-select-box
        :option="disabledSelectBox"
        :selectedValue="disabledSelectBoxValue"
        @selected="handleDisabledSelectBoxValue"
      />
      : {{ disabledSelectBoxValue }}
    </div>
  </div>
</template>

<script lang="ts">
import { Component } from 'vue-property-decorator';
import BaseView from '@/views/BaseView.vue';
import CustomButton, { CustomButtonOption } from '@/components/CustomButton.vue';
import CustomSelectBox, { CustomSelectBoxOption } from '@/components/CustomSelectBox.vue';

@Component({
  components: {
    CustomButton,
    CustomSelectBox
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

  private defaultSelectBoxValue: string;
  private defaultSelectBox: CustomSelectBoxOption = {
    name: 'DefaultSelectBox',
    size: 1,
    items: [
      {
        label: 'Option1'
      },
      {
        label: 'Option2'
      },
      {
        label: 'DisabledOption',
        disabled: true
      }
    ]
  }

  private disabledSelectBoxValue: string;
  private disabledSelectBox: CustomSelectBoxOption = {
    name: 'DisabledSelectBox',
    size: 1,
    items: [
      {
        label: 'Option1'
      },
      {
        label: 'Option2'
      },
      {
        label: 'DisabledOption',
        disabled: true
      }
    ],
    disabled: true
  }

  constructor() {
    super();

    this.defaultSelectBoxValue = '';
    this.disabledSelectBoxValue = '';
  }

  private handleDefaultSelectBoxValue(value: string): void {
    this.defaultSelectBoxValue = value;
  }

  private handleDisabledSelectBoxValue(value: string): void {
    this.disabledSelectBoxValue = value;
  }
}
</script>
