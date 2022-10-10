<template>
  <div class="check-todofuken">
    <h1 class="title">都道府県確認</h1>
    <b-field>
      <b-button class="success-button" @click="updateTodofukenList">
        更新
      </b-button>
    </b-field>
    <b-field style="padding: 10px">
      <b-table :data="todofukenList" :bordered="true">
        <b-table-column
          field="image"
          label="図"
          :centered="true"
          v-slot="props"
        >
          <img :src="`/images/todofuken/${props.row.file}`" style="
            width: 100px;
          " />
        </b-table-column>
        <b-table-column
          field="prefecture"
          label="都道府県"
          :centered="true"
          v-slot="props"
        >
          {{ props.row.prefecture }}
        </b-table-column>
        <b-table-column
          field="capital"
          label="県庁所在地"
          :centered="true"
          v-slot="props"
        >
          {{ props.row.capital }}
        </b-table-column>
      </b-table>
    </b-field>
  </div>
</template>

<script lang="ts">
import { Vue, Component } from "vue-property-decorator"
import Todofuken, { todofuken } from "@/Todofuken"

@Component
export default class CheckTodofuken extends Vue {
  private todofukenList: Array<todofuken> = [];

  private async updateTodofukenList() {
    const result = await Todofuken.getTodofukenList(20)

    if (typeof result !== "boolean") {
      this.todofukenList = result
    }
  }
}
</script>
