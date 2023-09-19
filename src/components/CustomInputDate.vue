<template>
  <input
    type="date"
    :disabled="option.disabled ?? false"
    @input="handleInput"
  />
</template>

<script lang="ts">
import { Vue, Component, Prop } from 'vue-property-decorator';

@Component({})
export default class CustomInputDate extends Vue {
  @Prop()
  private option: CustomInputDateOption;

  private handleInput(event: InputEvent): void {
    this.option.handleInput(new Date((event.target as HTMLInputElement).value));
  }
}

export interface CustomInputDateOption {
  disabled?: boolean;
  handleInput: (date: Date) => void;
}
</script>