<template>
  <input
    :placeholder="option.placeholder"
    :disabled="option.disabled ?? false"
    @input="option.handleInput"
  />
</template>

<script lang="ts">
import { Vue, Component, Prop } from 'vue-property-decorator';

@Component({})
export default class CustomInput extends Vue {
  @Prop()
  private option: CustomInputOption;
}

export interface CustomInputOption {
  placeholder: string;
  disabled?: boolean;
  handleInput: (event: InputEvent) => void;
}
</script>