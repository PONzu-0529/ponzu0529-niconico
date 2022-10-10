<template>
  <modal name="niconico-form">
    <div class="custom-modal">
      <h1 class="title">{{ isUpdate ? "詳細" : "追加" }}</h1>
      <form>
        <b-field horizontal label="ID">
          <b-input type="text" v-model="video.video_id"></b-input>
        </b-field>
        <b-field horizontal label="タイトル">
          <b-input type="text" v-model="video.title"></b-input>
        </b-field>
        <b-field>
          <b-switch v-model="video.favorite"> お気に入り </b-switch>
        </b-field>
        <b-field>
          <b-switch v-model="video.skip"> スキップ </b-switch>
        </b-field>
        <b-field horizontal>
          <b-button class="normal-button" @click="getOfficialInfo">取得</b-button>
          <b-button class="success-button" @click="changeVideo">
            {{ isUpdate ? "更新" : "登録" }}
          </b-button>
          <b-button class="danger-button" @click="closeNiconicoForm">閉じる</b-button>
        </b-field>
      </form>
    </div>
  </modal>
</template>

<script lang="ts">
import Niconico, { music } from "@/Niconico"
import { Vue, Component, Emit, Prop } from "vue-property-decorator"

@Component
export default class NiconicoForm extends Vue {
  @Emit("closeNiconicoForm")
  private closeNiconicoForm() {
    return
  }

  @Emit("readAllVideos")
  private readAllVideos() {
    return
  }

  @Prop({
    default: {
      video_id: "",
      title: "",
      favorite: false,
      skip: false,
    },
  })
  private video: music;

  @Prop({ default: false })
  private isUpdate: boolean;

  private async getOfficialInfo() {
    if (this.video === null || this.video.video_id === "") return

    const result = await Niconico.getOfficialInfo(this.video.video_id)

    if (result === false) alert("失敗")

    alert(typeof result === "string" && result !== "" ? "成功" : "失敗")

    if (typeof result === "string") this.video.title = result
  }

  private async changeVideo() {
    if (this.video === null) return

    if (this.isUpdate) {
      const result = await Niconico.updateVideo(this.video)
      alert(`${result ? "成功" : "失敗"}`)
    } else {
      const result = await Niconico.createVideo(this.video)
      alert(`${result ? "成功" : "失敗"}`)
    }

    this.closeNiconicoForm()
    this.readAllVideos()
  }
}
</script>
