<template>
  <div>
    <div style="overflow-y: scroll;">
      <table>
        <thead>
          <tr>
            <template v-for="(column, index) in option.column">
              <th
                :key="index"
                :width="column.width"
              >{{ column.head }}</th>
            </template>
          </tr>
        </thead>
        <tbody>
          <template v-for="(body, rowNumber) in option.body">
            <tr :key="rowNumber">
              <template v-for="(row, columnNumber) in body">
                <td :key="columnNumber">
                  <template v-if="['string', 'number'].includes(option.column[columnNumber].type)">
                    <template v-if="option.editable">
                      <template v-if="row.editing">
                        <template v-if="option.column[columnNumber].type === 'string'">
                          <custom-input :option="editingValueInputOption" />
                        </template>

                        <template v-else-if="option.column[columnNumber].type === 'number'">
                          <custom-input-number :option="editingNumberInputOption" />
                        </template>
                      </template>

                      <template v-else>
                        <template v-if="option.column[columnNumber].type === 'string'">
                          <a
                            href="#"
                            @click.prevent.stop="clickCell(rowNumber, columnNumber)"
                          >
                            {{ row.value }}
                          </a>
                        </template>

                        <template v-else-if="option.column[columnNumber].type === 'number'">
                          <a
                            href="#"
                            @click.prevent.stop="clickCell(rowNumber, columnNumber)"
                          >
                            {{ row.number }}
                          </a>
                        </template>
                      </template>
                    </template>

                    <template v-else>
                      {{ row.value }}
                    </template>
                  </template>

                  <template v-else-if="option.column[columnNumber].type === 'custom-button'">
                    <custom-button :option="row.button" />
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
import CustomInputNumber, { CustomInputNumberOption } from '@/components/CustomInputNumber.vue';

@Component({
  components: {
    CustomButton,
    CustomInput,
    CustomInputNumber,
  }
})
export default class CustomSimpleTable extends Vue {
  @Prop()
  private option: CustomTableOption;

  private editingValue: string | null = '';
  private editingNumber: number | null = 0;
  private editingRowNumber = 0;
  private editingColumnNumber = 0;

  private editingValueInputOption: CustomInputOption = {
    placeholder: '',
    autoFocus: true,
    handleInput: this.handleEditingInput,
    handleBlur: this.handleBlurInput,
  }

  private handleEditingInput(value: string): void {
    this.editingValue = value;
  }

  private handleBlurInput(): void {
    if (this.editingValue === '') return;

    this.option.body[this.editingRowNumber].splice(this.editingColumnNumber, 1, {
      value: this.editingValue ?? undefined
    });
  }

  private editingNumberInputOption: CustomInputNumberOption = {
    placeholder: '',
    autoFocus: true,
    handleInput: this.handleEditingNumberInput,
    handleBlur: this.handleBlurNumberInput,
  }

  private handleEditingNumberInput(value: number): void {
    this.editingNumber = value;
  }

  private handleBlurNumberInput(): void {
    this.option.body[this.editingRowNumber].splice(this.editingColumnNumber, 1, {
      number: this.editingNumber ?? undefined
    });
  }

  private get hasEditingOption(): boolean {
    return this.option.body.some(row => row.some(option => option.editing));
  }

  @Emit('clickPage')
  private clickPage(index: number): number {
    return index;
  }

  private mounted(): void {
    if (this.option.defaultRow) {
      this.option.body.splice(0, 1, this.option.defaultRow);
    }
  }

  private clickCell(row: number, column: number): void {
    if (this.hasEditingOption) return;

    this.editingValue = this.option.body[row][column].value ?? null;
    this.editingNumber = this.option.body[row][column].number ?? null;
    this.editingRowNumber = row;
    this.editingColumnNumber = column;

    this.editingValueInputOption.defaultValue = this.editingValue ?? undefined;
    this.editingNumberInputOption.defaultValue = this.editingNumber ?? undefined;

    this.option.body[row].splice(column, 1, {
      value: this.editingValue ?? undefined,
      number: this.editingNumber ?? undefined,
      editing: true,
    });
  }
}

export interface CustomTableOption {
  column: Array<CustomTableColumnOption>;
  body: Array<Array<CustomTableRowOption>>;
  currentPage: number;
  pageList: Array<number>;
  defaultRow?: Array<CustomTableRowOption>;
  editable?: boolean;
}

export interface CustomTableColumnOption {
  type: 'string' | 'number' | 'custom-button';
  head: string;
  width?: number
}

export interface CustomTableRowOption {
  value?: string;
  number?: number;
  button?: CustomButtonOption;
  editing?: boolean;
}
</script>
