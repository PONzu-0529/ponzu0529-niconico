<template>
  <button
    class="btn-medium"
    :disabled="option.disabled"
    @click="option.click"
  >{{ option.label }}</button>
</template>

<script lang="ts">
import { Vue, Component, Emit, Prop } from 'vue-property-decorator';

@Component({})
export default class CustomButton extends Vue {
  @Prop({
    default: {
      label: '',
      disabled: false
    }
  })
  private option: CustomButtonOption;

  @Emit('clickEvent')
  private clickEvent(): void {
    return;
  }
}

export interface CustomButtonOption {
  label: string
  disabled?: boolean
  click: () => void;
}
</script>