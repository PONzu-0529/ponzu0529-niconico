<template>
  <input
    ref="inputRef"
    :value="option.defaultValue"
    :placeholder="option.placeholder"
    type="number"
    :disabled="option.disabled ?? false"
    @input="handleInput"
    @blur="handleBlur"
  />
</template>

<script lang="ts">
import { Vue, Component, Prop } from 'vue-property-decorator';

@Component({})
export default class CustomInputNumber extends Vue {
  @Prop()
  private option: CustomInputNumberOption;

  private mounted(): void {
    if (this.option.autoFocus) {
      (this.$refs.inputRef as HTMLElement).focus();
    }
  }

  private handleInput(event: InputEvent): void {
    const numericValue = parseFloat((event.target as HTMLInputElement).value);

    if (!isNaN(numericValue)) {
      this.option.handleInput(numericValue);
    }
  }

  private handleBlur(): void {
    if (this.option.handleBlur) {
      this.option.handleBlur();
    }
  }
}

export interface CustomInputNumberOption {
  defaultValue?: number;
  placeholder: string;
  autoFocus?: boolean;
  disabled?: boolean;
  handleInput: (value: number) => void;
  handleBlur?: () => void;
}
</script>