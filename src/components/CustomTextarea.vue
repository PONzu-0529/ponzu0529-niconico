<template>
  <textarea
    :value="option.value"
    :rows="option.rows ?? 5"
    :cols="option.cols ?? 30"
    :disabled="option.disabled ?? false"
    @input="option.handleInput"
  />
</template>

<script lang="ts">
import { Vue, Component, Prop } from 'vue-property-decorator';

@Component({})
export default class CustomTextarea extends Vue {
  @Prop()
  private option: CustomTextareaOption;
}

export interface CustomTextareaOption {
  value: string;
  rows?: number;
  cols?: number;
  disabled?: boolean;
  handleInput: (event: InputEvent) => void;
}
</script>