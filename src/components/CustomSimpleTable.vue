<template>
  <div>
    <div style="overflow-y: scroll;">
      <table>
        <thead>
          <tr>
            <template v-for="(head, index) in option.head">
              <th
                :key="index"
                :width="option.widthList ? option.widthList[index] : null"
              >{{ head.value }}</th>
            </template>
          </tr>
        </thead>
        <tbody>
          <template v-for="(body, rowNumber) in option.body">
            <tr :key="rowNumber">
              <template v-for="(row, columnNumber) in body">
                <td :key="columnNumber">
                  <template v-if="row.button">
                    <custom-button :option="row.button" />
                  </template>
                  <template v-else-if="row.input">
                    <custom-input
                      :option="row.input"
                      ref="childRef"
                    />
                  </template>
                  <template v-else-if="row.value">
                    <template v-if="option.editable">
                      <a
                        href="#"
                        @click.prevent.stop="clickCell(rowNumber, columnNumber)"
                      >
                        {{ row.value }}
                      </a>
                    </template>
                    <template v-else>
                      {{ row.value }}
                    </template>
                  </template>
                </td>
              </template>
            </tr>
          </template>
        </tbody>
      </table>
    </div>
    <div class="table-footer">
      <template v-for="(index) in option.pageList">
        <a
          href="#"
          :key="index"
          @click.prevent.stop="clickPage(index)"
        >
          {{ index }}
        </a>
      </template>
    </div>
  </div>
</template>

<script lang="ts">
import { Vue, Component, Prop, Emit } from 'vue-property-decorator';
import CustomButton, { CustomButtonOption } from '@/components/CustomButton.vue';
import CustomInput, { CustomInputOption } from '@/components/CustomInput.vue';

@Component({
  components: {
    CustomButton,
    CustomInput,
  }
})
export default class CustomSimpleTable extends Vue {
  @Prop()
  private option: CustomTableOption;

  private editingValue: string;
  private editingRowNumber: number;
  private editingColumnNumber: number;

  @Emit('clickPage')
  private clickPage(index: number): number {
    return index;
  }

  constructor() {
    super();

    this.editingRowNumber = 0;
    this.editingColumnNumber = 0;
  }

  private mounted(): void {
    if (this.option.defaultRow) {
      this.option.body.push(this.option.defaultRow);
    }
  }

  private clickCell(row: number, column: number): void {
    this.editingValue = this.option.body[row][column].value ?? '';
    this.editingRowNumber = row;
    this.editingColumnNumber = column;

    this.option.body[row].splice(column, 1, {
      input: {
        defaultValue: this.editingValue,
        placeholder: '',
        autoFocus: true,
        handleInput: this.handleEditingInput,
        handleBlur: this.handleBlurInput,
      }
    });
  }

  private handleEditingInput(value: string): void {
    this.editingValue = value;
  }

  private handleBlurInput(): void {
    this.option.body[this.editingRowNumber].splice(this.editingColumnNumber, 1, {
      value: this.editingValue
    });
  }
}

export interface CustomTableOption {
  head: Array<CustomTableRowOption>;
  body: Array<Array<CustomTableRowOption>>;
  currentPage: number;
  pageList: Array<number>;
  defaultRow?: Array<CustomTableRowOption>;
  editable?: boolean;
  widthList?: Array<number | null>;
}

export interface CustomTableRowOption {
  value?: string;
  button?: CustomButtonOption;
  input?: CustomInputOption;
}
</script>
