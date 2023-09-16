<template>
  <select
    :name="option.name"
    :size="option.size"
    :disabled="option.disabled"
    v-model="selectedValueInternal"
    @change="emitSelectedValue"
  >
    <template v-for="(item, index) in option.items">
      <option
        :key="index"
        :value="item.value ?? item.label"
        :selected="item.selected"
        :disabled="item.disabled"
      >{{ item.label }}</option>
    </template>
  </select>
</template>

<script lang="ts">
import { Vue, Component, Emit, Prop } from 'vue-property-decorator';

@Component({})
export default class CustomSelectBox extends Vue {
  @Prop({
    default: {
      name: '',
      size: 1,
      multiple: false,
      items: [],
      disabled: false
    } as CustomSelectBoxOption
  })
  private option: CustomSelectBoxOption;

  @Prop({
    default: ''
  })
  private selectedValue: string;

  private selectedValueInternal: string;

  @Emit('selected')
  private emitSelectedValue() {
    return this.selectedValueInternal;
  }

  constructor() {
    super();

    this.selectedValueInternal = '';
  }

  private mounted(): void {
    this.selectedValueInternal = this.selectedValue;
  }
}

export interface CustomSelectBoxOption {
  name: string;
  size?: number;
  items: Array<CustomSelectBoxItemOption>;
  disabled?: boolean;
}

export interface CustomSelectBoxItemOption {
  label: string;
  value?: string | number;
  disabled?: boolean;
}
</script>