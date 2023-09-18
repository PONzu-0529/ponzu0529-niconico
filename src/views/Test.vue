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
      DefaultInput:
      <custom-input :option="defaultInputOption" />
      : {{ defaultInputValue }}
    </div>
    <div>
      DisabledInput:
      <custom-input :option="disabledInputOption" />
      : {{ disabledInputValue }}
    </div>
    <div>
      NumberInput:
      <custom-input-number :option="numberInputOption" />
      : {{ numberInputValue }}
    </div>
    <div>
      DisabledNumberInput:
      <custom-input-number :option="disabledNumberInputOption" />
      : {{ disabledNumberInputValue }}
    </div>

    <br>

    <div>
      DefaultTextarea:
      <custom-textarea :option="defaultTextareaOption" />
      : {{ defaultTextareaValue }}
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
import CustomInput, { CustomInputOption } from '@/components/CustomInput.vue';
import CustomInputNumber, { CustomInputNumberOption } from '@/components/CustomInputNumber.vue';
import CustomSelectBox, { CustomSelectBoxOption } from '@/components/CustomSelectBox.vue';
import CustomSimpleTable, { CustomTableOption } from '@/components/CustomSimpleTable.vue';
import CustomTextarea, { CustomTextareaOption } from '@/components/CustomTextarea.vue';

@Component({
  components: {
    CustomButton,
    CustomInput,
    CustomInputNumber,
    CustomSelectBox,
    CustomSimpleTable,
    CustomTextarea,
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

  private defaultInputValue: string;
  private defaultInputOption: CustomInputOption = {
    value: '',
    placeholder: 'DefaultInput',
    handleInput: this.handleDefaultInput
  }

  private disabledInputValue: string;
  private disabledInputOption: CustomInputOption = {
    value: '',
    placeholder: 'DefaultInput',
    disabled: true,
    handleInput: this.handleDefaultInput
  }

  private numberInputValue: number;
  private numberInputOption: CustomInputNumberOption = {
    value: 0,
    placeholder: 'NumberIput',
    handleInput: this.handleNumberInput
  }

  private disabledNumberInputValue: number;
  private disabledNumberInputOption: CustomInputNumberOption = {
    value: 0,
    placeholder: 'NumberIput',
    disabled: true,
    handleInput: this.handleNumberInput
  }

  private defaultTextareaValue: string;
  private defaultTextareaOption: CustomTextareaOption = {
    handleInput: this.handleDefaultTextare
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
    pageList: [3, 4, 5, 6, 7],
    widthList: [200, 500, null],
  }

  constructor() {
    super();

    this.defaultSelectBoxValue = '';
    this.disabledSelectBoxValue = '';

    this.defaultInputValue = '';
    this.disabledInputValue = '';
    this.numberInputValue = 0;
    this.disabledNumberInputValue = 0;

    this.defaultTextareaValue = '';
  }

  private handleDefaultSelectBoxValue(value: string): void {
    this.defaultSelectBoxValue = value;
  }

  private handleDisabledSelectBoxValue(value: string): void {
    this.disabledSelectBoxValue = value;
  }

  private handleDefaultInput(event: InputEvent): void {
    this.defaultInputValue = (event.target as HTMLInputElement).value;
  }

  private handleNumberInput(event: InputEvent): void {
    const numericValue = parseFloat((event.target as HTMLInputElement).value);

    if (!isNaN(numericValue)) {
      this.numberInputValue = numericValue;
    } else {
      this.numberInputValue = 0;
    }
  }

  private handleDefaultTextare(event: InputEvent): void {
    this.defaultTextareaValue = (event.target as HTMLInputElement).value;
  }

  private clickSimpleTablePageClick(index: number): void {
    return;
  }
}
</script>
