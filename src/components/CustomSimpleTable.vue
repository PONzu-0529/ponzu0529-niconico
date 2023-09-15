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
      <template v-for="(index) in pageList">
        <a
          :key="index"
          href=""
        >{{ index }}</a>
      </template>
    </div>
  </div>
</template>

<script lang="ts">
import { Vue, Component, Prop } from 'vue-property-decorator';
import CustomButton, { CustomButtonOption } from '@/components/CustomButton.vue';

@Component({
  components: {
    CustomButton
  }
})
export default class CustomSimpleTable extends Vue {
  @Prop()
  private option: CustomTableOption

  private pageList: Array<number>;

  constructor() {
    super();

    this.pageList = [];
  }

  private mounted(): void {
    this.pageList.push(
      this.option.page - 2, this.option.page - 1, this.option.page);
    const minPage = Math.max(1, this.option.page - 2);
    const maxPage = Math.max(minPage, this.option.page + 2);

    this.pageList = Array.from({ length: maxPage - minPage + 1 }, (_, index) => minPage + index);
  }
}

export interface CustomTableOption {
  head: Array<CustomTableRowOption>
  body: Array<Array<CustomTableRowOption>>
  page: number
}

export interface CustomTableRowOption {
  value?: string
  button?: CustomButtonOption
}
</script>
