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
    <br>
    <div>
      <custom-simple-table
        :option="simpleTableOption"
        @clickPage="clickSimpleTablePageClick"
      />
    </div>
  </div>
</template>

<script lang="ts">
import { Component } from 'vue-property-decorator';
import BaseView from '@/views/BaseView.vue';
import CustomButton, { CustomButtonOption } from '@/components/CustomButton.vue';
import CustomSelectBox, { CustomSelectBoxOption } from '@/components/CustomSelectBox.vue';
import CustomSimpleTable, { CustomTableOption } from '@/components/CustomSimpleTable.vue';

@Component({
  components: {
    CustomButton,
    CustomSelectBox,
    CustomSimpleTable
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

  private simpleTableOption: CustomTableOption = {
    head: [
      {
        value: 'Header1'
      },
      {
        value: 'Header2'
      },
      {
        value: 'Header3'
      }
    ],
    body: [
      [
        {
          value: 'Column1-1'
        },
        {
          value: 'Column1-2'
        },
        {
          button: {
            label: 'Column1',
            click: () => { return; }
          }
        }
      ],
      [
        {
          value: 'Column2-1'
        },
        {
          value: 'Column2-2'
        },
        {
          button: {
            label: 'Column2',
            click: () => { return; }
          }
        }
      ]
    ],
    currentPage: 5,
    pageList: [3, 4, 5, 6, 7]
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

  private clickSimpleTablePageClick(index: number): void {
    return;
  }
}
</script>
