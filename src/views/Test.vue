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
      DateInput:
      <custom-input-date :option="dateInputOption" />
      : {{ dateInputValue }}
    </div>
    <div>
      CustomDateInput:
      <custom-input-date :option="customDateInputValueOption" />
      : {{ customDateInputValue }}
    </div>

    <br>

    <div>
      DefaultTextarea:
      <custom-textarea :option="defaultTextareaOption" />
      : {{ defaultTextareaValue }}
    </div>

    <br>

    <div>
      SimpleTable:
      <custom-simple-table
        :option="simpleTableOption"
        @clickPage="clickSimpleTablePageClick"
      />
    </div>
    <div>
      EditableTable:
      <custom-simple-table
        :option="editableTalbeOption"
        @clickPage="clickEditableTablePageClick"
      />
    </div>
  </div>
</template>

<script lang="ts">
import { Component } from 'vue-property-decorator';
import _ from 'lodash';
import BaseView from '@/views/BaseView.vue';
import CustomButton, { CustomButtonOption } from '@/components/CustomButton.vue';
import CustomInput, { CustomInputOption } from '@/components/CustomInput.vue';
import CustomInputDate, { CustomInputDateOption } from '@/components/CustomInputDate.vue';
import CustomInputNumber, { CustomInputNumberOption } from '@/components/CustomInputNumber.vue';
import CustomSelectBox, { CustomSelectBoxOption } from '@/components/CustomSelectBox.vue';
import CustomSimpleTable, { CustomTableOption } from '@/components/CustomSimpleTable.vue';
import CustomTextarea, { CustomTextareaOption } from '@/components/CustomTextarea.vue';

@Component({
  components: {
    CustomButton,
    CustomInput,
    CustomInputDate,
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
    placeholder: 'DefaultInput',
    handleInput: this.handleDefaultInput
  }

  private disabledInputValue: string;
  private disabledInputOption: CustomInputOption = {
    placeholder: 'DefaultInput',
    disabled: true,
    handleInput: this.handleDefaultInput
  }

  private numberInputValue: number;
  private numberInputOption: CustomInputNumberOption = {
    placeholder: 'NumberIput',
    handleInput: this.handleNumberInput
  }

  private disabledNumberInputValue: number;
  private disabledNumberInputOption: CustomInputNumberOption = {
    placeholder: 'NumberIput',
    disabled: true,
    handleInput: this.handleNumberInput
  }

  private dateInputValue: Date;
  private dateInputOption: CustomInputDateOption = {
    handleInput: this.handleDateInput
  }

  private customDateInputValue: Date;
  private customDateInputValueOption: CustomInputDateOption = {
    defaultValue: new Date('2023-01-01'),
    handleInput: this.handleCustomDateInput,
  }

  private defaultTextareaValue: string;
  private defaultTextareaOption: CustomTextareaOption = {
    handleInput: this.handleDefaultTextare
  }

  private simpleTableOption: CustomTableOption = {
    column: [
      {
        type: 'string',
        head: 'Header1',
      },
      {
        type: 'string',
        head: 'Header2',
      },
      {
        type: 'custom-button',
        head: 'Header3',
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
            click: _.noop,
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
            click: _.noop,
          }
        }
      ]
    ],
    currentPage: 5,
    pageList: [3, 4, 5, 6, 7],
  }

  private editableTalbeOption: CustomTableOption = {
    column: [
      {
        type: 'string',
        head: 'Header1',
      },
      {
        type: 'string',
        head: 'Header2',
      },
      {
        type: 'number',
        head: 'Header3',
      },
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
          number: 10,
        },
      ],
      [
        {
          value: 'Column2-1'
        },
        {
          value: 'Column2-2'
        },
        {
          number: 20,
        },
      ]
    ],
    currentPage: 5,
    pageList: [3, 4, 5, 6, 7],
    editable: true,
  }

  constructor() {
    super();

    this.defaultSelectBoxValue = '';
    this.disabledSelectBoxValue = '';

    this.defaultInputValue = '';
    this.disabledInputValue = '';
    this.numberInputValue = 0;
    this.disabledNumberInputValue = 0;

    this.dateInputValue = new Date();
    this.customDateInputValue = new Date('2023-01-01');

    this.defaultTextareaValue = '';
  }

  private handleDefaultSelectBoxValue(value: string): void {
    this.defaultSelectBoxValue = value;
  }

  private handleDisabledSelectBoxValue(value: string): void {
    this.disabledSelectBoxValue = value;
  }

  private handleDefaultInput(value: string): void {
    this.defaultInputValue = value;
  }

  private handleNumberInput(value: number): void {
    this.numberInputValue = value;
  }

  private handleDateInput(date: Date): void {
    this.dateInputValue = date;
  }

  private handleCustomDateInput(date: Date): void {
    this.customDateInputValue = date;
  }

  private handleDefaultTextare(value: string): void {
    this.defaultTextareaValue = value;
  }

  private clickSimpleTablePageClick(index: number): void {
    _.noop();
  }

  private clickEditableTablePageClick(index: number): void {
    _.noop();
  }
}
</script>
