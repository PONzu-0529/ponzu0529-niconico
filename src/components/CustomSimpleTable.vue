<template>
  <div>
    <div style="overflow-y: scroll;">
      <table>
        <thead>
          <tr>
            <template v-for="(head, index) in option.head">
              <th :key="index">{{ head.value }}</th>
            </template>
          </tr>
        </thead>
        <tbody>
          <template v-for="(body, index) in option.body">
            <tr :key="index">
              <template v-for="(row, index) in body">
                <td :key="index">
                  <template v-if="row.button">
                    <custom-button :option="row.button" />
                  </template>
                  <template v-else-if="row.value">
                    {{ row.value }}
                  </template>
                </td>
              </template>
            </tr>
          </template>
        </tbody>
      </table>
    </div>
    <div class="table-footer">
      <template v-for="(index) in option.pageList">
        <a
          href="#"
          :key="index"
          @click.prevent.stop="clickPage(index)"
        >{{ index }}</a>
      </template>
    </div>
  </div>
</template>

<script lang="ts">
import { Vue, Component, Prop, Emit } from 'vue-property-decorator';
import CustomButton, { CustomButtonOption } from '@/components/CustomButton.vue';

@Component({
  components: {
    CustomButton
  }
})
export default class CustomSimpleTable extends Vue {
  @Prop()
  private option: CustomTableOption

  @Emit('clickPage')
  private clickPage(index: number): number {
    return index;
  }
}

export interface CustomTableOption {
  head: Array<CustomTableRowOption>;
  body: Array<Array<CustomTableRowOption>>;
  currentPage: number;
  pageList: Array<number>;
}

export interface CustomTableRowOption {
  value?: string
  button?: CustomButtonOption
}
</script>
