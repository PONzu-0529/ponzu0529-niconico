<template>
  <input
    ref="inputRef"
    type="date"
    :disabled="option.disabled ?? false"
    v-model="date"
    @input="handleInput"
    @blur="handleBlur"
  />
</template>

<script lang="ts">
import { Vue, Component, Prop } from 'vue-property-decorator';
import dayjs from 'dayjs';

@Component({})
export default class CustomInputDate extends Vue {
  @Prop()
  private option: CustomInputDateOption;

  private date: string;

  constructor() {
    super();

    this.date = dayjs().format('YYYY-MM-DD');
  }

  private mounted(): void {
    if (this.option.autoFocus) {
      (this.$refs.inputRef as HTMLElement).focus();
    }

    if (this.option.defaultValue) {
      this.date = dayjs(this.option.defaultValue).format('YYYY-MM-DD');
    }
  }

  private handleInput(event: InputEvent): void {
    this.option.handleInput(new Date((event.target as HTMLInputElement).value));
  }

  private handleBlur(): void {
    if (this.option.handleBlur) {
      this.option.handleBlur();
    }
  }
}

export interface CustomInputDateOption {
  defaultValue?: Date;
  autoFocus?: boolean;
  disabled?: boolean;
  handleInput: (date: Date) => void;
  handleBlur?: () => void;
}
</script>