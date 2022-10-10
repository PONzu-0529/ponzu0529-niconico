<template>
  <div class="niconico-custom-mylist">
    <h1 class="title">ニコ動カスタムマイリスト</h1>
    <niconico-form :video="video" :isUpdate="isUpdate" @closeNiconicoForm="closeNiconicoForm" @readAllVideos="readAllVideos" />
    <button @click="openCreateVideo">追加</button>
    <b-table :data="videoList" :bordered="true">
      <b-table-column
        field="video_id"
        label="ID"
        :centered="true"
        v-slot="props"
      >
        {{ props.row.video_id }}
      </b-table-column>
      <b-table-column
        field="title"
        label="タイトル"
        :centered="true"
        v-slot="props"
      >
        {{ props.row.title }}
      </b-table-column>
      <b-table-column
        field="favorite"
        label="お気に入り"
        :centered="true"
        v-slot="props"
      >
        {{ props.row.favorite }}
      </b-table-column>
      <b-table-column
        field="skip"
        label="スキップ"
        :centered="true"
        v-slot="props"
      >
        {{ props.row.skip }}
      </b-table-column>
      <b-table-column
        field="option"
        label="オプション"
        :centered="true"
        v-slot="props"
      >
        <button @click="openUpdateVideo(props.row)">詳細</button>
      </b-table-column>
    </b-table>
  </div>
</template>

<script lang="ts">
import _ from "lodash"
import NiconicoForm from "@/components/NiconicoForm.vue"
import { userModule } from "@/store/modules/User"
import User from "@/User"
import Niconico, { music } from "@/Niconico"
import { Vue, Component } from "vue-property-decorator"

@Component({
  components: {
    NiconicoForm,
  },
})
export default class NiconicoCustomMylist extends Vue {
  private videoList: Array<music> = [];
  private video: music = {
    video_id: '',
    title: '',
    favorite: false,
    skip: false
  };
  private isUpdate = false;

  private get loginStatus(): boolean {
    return userModule.loginStatus
  }

  private async created() {
    await User.checkAccessToken()
    if (!this.loginStatus) {
      this.$router.push("/")
    }
  }

  private async mounted() {
    await this.readAllVideos()
  }

  private async readAllVideos() {
    const result = await Niconico.readAllVideos()

    this.videoList = typeof result !== "boolean" ? result : []
  }

  private openNiconicoForm() {
    this.$modal.show("niconico-form")
  }

  private async closeNiconicoForm() {
    this.$modal.hide("niconico-form")
  }

  private openCreateVideo() {
    this.video = {
      video_id: '',
      title: '',
      favorite: false,
      skip: false
    }
    this.isUpdate = false
    this.openNiconicoForm()
  }

  private openUpdateVideo(music: music) {
    this.video = _.cloneDeep(music)
    console.log('DEBUG:::', this.video)
    this.isUpdate = true
    this.openNiconicoForm()
  }
}
</script>
