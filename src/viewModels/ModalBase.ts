import Base from '@/viewModels/Base';
import { Component } from 'vue-property-decorator';

@Component({})
export default class ModalBase extends Base {
  protected buttonLabel = '';
  protected modalName = '';

  protected openModal(): void {
    this.$modal.show(this.modalName);
  }

  protected closeModal(): void {
    this.$modal.hide(this.modalName);
  }
}
