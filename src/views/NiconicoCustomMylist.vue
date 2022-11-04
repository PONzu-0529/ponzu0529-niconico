<template>
  <div class="niconico-custom-mylist">
    <h1 class="title">ニコ動カスタムマイリスト</h1>
    <niconico-form
      :video="video"
      :isUpdate="isUpdate"
      @closeNiconicoForm="closeNiconicoForm"
      @readAllVideos="readAllVideos"
    />
    <b-field>
      <b-button class="normal-button" @click="openCreateVideo">追加</b-button>
    </b-field>
    <b-field style="padding: 10px">
      <b-table :data="videoList" :bordered="true">
        <b-table-column
          field="title"
          label="タイトル"
          :centered="true"
          v-slot="props"
        >
          {{ props.row.title }}
        </b-table-column>

        <b-table-column
          field="favorite_lank"
          label="ランク"
          :centered="true"
          v-slot="props"
        >
          {{ getFavoriteLank(props.row.favorite_lank) }}
        </b-table-column>

        <b-table-column
          field="option"
          label="オプション"
          :centered="true"
          v-slot="props"
        >
          <b-button class="normal-button" @click="openUpdateVideo(props.row)">詳細</b-button>
        </b-table-column>
      </b-table>
    </b-field>
  </div>
</template>

<script lang="ts">
import _ from "lodash"
import NiconicoForm from "@/components/NiconicoForm.vue"
import { userModule } from "@/store/modules/User"

import { ApiModel } from "@/models/ApiModel"
import { VocaloidMusicModel, VocaloidMusicStyle } from '@/models/VocaloidMusicModel'

import { Vue, Component } from "vue-property-decorator"

@Component({
  components: {
    NiconicoForm,
  },
})
export default class NiconicoCustomMylist extends Vue {
  private videoList: Array<VocaloidMusicStyle> = [];

  // Target Video
  private video: VocaloidMusicStyle;

  private isUpdate = false;

  private get loginStatus(): boolean {
    return userModule.loginStatus
  }

  private async created() {
    // await User.checkAccessToken()
    // if (!this.loginStatus) {
    //   this.$router.push("/")
    // }
  }

  private async mounted() {
    this.videoList = await this.getMusicList()
  }


  private async getMusicList(): Promise<Array<VocaloidMusicStyle>> {
    const callApiResult = await ApiModel.callApi({
      url: "http://127.0.0.1/api/v1/vocaloid-music/get-music-list",
      body: { accessToken: "test_access_token" },
    })

    if (callApiResult.status !== 'success') {
      console.error(callApiResult.body)
      return []
    }

    if (typeof callApiResult.body === 'string') {
      return []
    } else {
      return callApiResult.body
    }
  }


  private getFavoriteLank(favoriteLankNumber: number): string {
    return VocaloidMusicModel.getFavoriteLank(favoriteLankNumber)
  }

  private async readAllVideos() {
    await this.getMusicList()
  }

  private openNiconicoForm() {
    this.$modal.show("niconico-form")
  }

  private async closeNiconicoForm() {
    this.$modal.hide("niconico-form")
  }

  private openCreateVideo() {
    this.video = new VocaloidMusicModel()
    this.isUpdate = false
    this.openNiconicoForm()
  }

  private openUpdateVideo(music: VocaloidMusicStyle) {
    this.video = _.cloneDeep(music)
    this.isUpdate = true
    this.openNiconicoForm()
  }
}
</script>
