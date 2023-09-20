<template>
  <textarea
    :rows="option.rows ?? 5"
    :cols="option.cols ?? 30"
    :disabled="option.disabled ?? false"
    @input="handleInput"
    @blur="handleBlur"
  />
</template>

<script lang="ts">
import { Vue, Component, Prop } from 'vue-property-decorator';

@Component({})
export default class CustomTextarea extends Vue {
  @Prop()
  private option: CustomTextareaOption;

  private handleInput(event: InputEvent): void {
    this.option.handleInput((event.target as HTMLInputElement).value);
  }

  private handleBlur(): void {
    if (this.option.handleBlur) {
      this.option.handleBlur();
    }
  }
}

export interface CustomTextareaOption {
  defaultValue?: string;
  rows?: number;
  cols?: number;
  disabled?: boolean;
  handleInput: (value: string) => void;
  handleBlur?: () => void;
}
</script>