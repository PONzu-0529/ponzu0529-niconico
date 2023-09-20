<template>
  <input
    ref="inputRef"
    :value="option.defaultValue"
    :placeholder="option.placeholder"
    :disabled="option.disabled ?? false"
    @input="handleInput"
    @blur="handleBlur"
  />
</template>

<script lang="ts">
import { Vue, Component, Prop } from 'vue-property-decorator';

@Component({})
export default class CustomInput extends Vue {
  @Prop()
  private option: CustomInputOption;

  private mounted(): void {
    if (this.option.autoFocus) {
      (this.$refs.inputRef as HTMLElement).focus();
    }
  }

  private handleInput(event: InputEvent): void {
    this.option.handleInput((event.target as HTMLInputElement).value);
  }

  private handleBlur(): void {
    if (this.option.handleBlur) {
      this.option.handleBlur();
    }
  }
}

export interface CustomInputOption {
  defaultValue?: string;
  placeholder: string;
  autoFocus?: boolean;
  disabled?: boolean;
  handleInput: (value: string) => void;
  handleBlur?: () => void;
}
</script>