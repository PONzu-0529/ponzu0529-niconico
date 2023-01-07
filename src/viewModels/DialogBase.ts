import { Component, Emit, Prop, Watch } from 'vue-property-decorator';
import Base from '@/viewModels/Base';

@Component({})
export class DialogBase extends Base {
  @Prop({ default: '' })
  protected dialogName: string

  @Prop({ default: false })
  protected isOpen: boolean;

  @Prop({ default: '' })
  protected message: string;

  @Emit('setIsDialog')
  protected setIsDialog(status: boolean): boolean {
    return status;
  }

  @Watch('isOpen')
  protected onChangeIsOpen(): void {
    this.isOpen ? this.$modal.show(this.dialogName) : this.$modal.hide(this.dialogName);
  }

  protected openDialog(): void {
    this.setIsDialog(true);
  }

  protected closeDialog(): void {
    this.setIsDialog(false);
  }
}
