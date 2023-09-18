<template>
  <input
    :placeholder="option.placeholder"
    type="number"
    :disabled="option.disabled ?? false"
    @input="option.handleInput"
  />
</template>

<script lang="ts">
import { Vue, Component, Prop } from 'vue-property-decorator';

@Component({})
export default class CustomInputNumber extends Vue {
  @Prop()
  private option: CustomInputNumber;
}

export interface CustomInputNumberOption {
  placeholder: string;
  disabled?: boolean;
  handleInput: (event: InputEvent) => void;
}
</script>