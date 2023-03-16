<template>
  <div class="main">
    <div class="title">Mylist Assistant</div>
    <div class="content">
      <div class="upper-content">
        <div class="upper-left-content"></div>
        <div class="upper-right-content">
          <button
            @click="clickAdd"
            :disabled="!hasMasterEditAuth"
            class="btn-medium"
          >Add</button>
        </div>
      </div>
      <div class="main-content">
        <table>
          <thead>
            <tr>
              <th>ID</th>
              <th>Title</th>
              <th>Favorite</th>
              <th>Skip</th>
              <th>Option</th>
            </tr>
          </thead>
          <tbody>
            <template v-for="(music, index) in musicList">
              <tr :key="index">
                <td>
                  <a
                    :href="`https://www.nicovideo.jp/watch/${music.niconico_id}`"
                    target="_blank"
                    rel="noreferrer noopener"
                  >{{ music.niconico_id }}</a>
                </td>
                <td>{{ music.title }}</td>
                <td>{{ music.favorite === 1 }}</td>
                <td>{{ music.skip === 1 }}</td>
                <td>
                  <div class="flex">
                    <button
                      @click="clickEdit(index)"
                      :disabled="!hasEditAuth"
                      class="btn-medium"
                    >Edit</button>
                    <button
                      @click="clickDelete(music.music_id)"
                      :disabled="!hasMasterEditAuth"
                      class="btn-medium"
                    >Delete</button>
                  </div>
                </td>
              </tr>
            </template>
          </tbody>
        </table>
      </div>
    </div>
    <div
      v-if="isModalOpen"
      class="dialog"
    >
      <div class="dialog-title">Edit</div>
      <div class="dialog-content">
        <div class="dialog-main-content">
          <div class="field">
            <div class="field-lavel">ID</div>
            <input
              v-model="music.niconico_id"
              :disabled="music.music_id"
              class="field-content"
            />
          </div>
          <div class="field">
            <div class="field-lavel">Title</div>
            <input
              v-model="music.title"
              :disabled="!hasMasterEditAuth"
              class="field-content"
            />
          </div>
          <div class="field">
            <div class="field-lavel">Favorite</div>
            <input
              type="checkbox"
              v-model="music.favorite"
              class="field-content"
            />
          </div>
          <div class="field">
            <div class="field-lavel">Skip</div>
            <input
              type="checkbox"
              v-model="music.skip"
              class="field-content"
            />
          </div>
        </div>
        <div class="dialog-lower-content">
          <button
            @click="clickNowPlaying"
            :disabled="!hasMasterEditAuth"
            class="btn-medium"
          >GetNowPlaying</button>
          <button
            @click="clickGetInfo(music.niconico_id)"
            :disabled="!hasMasterEditAuth"
            class="btn-medium"
          >GetInfo</button>
          <button
            @click="clickDialogApply"
            class="btn-medium"
          >Apply</button>
          <button
            @click="clickDialogCancel"
            class="btn-medium"
          >Cancel</button>
        </div>
      </div>
    </div>
  </div>
</template>

<script lang="ts">
import { Vue, Component } from 'vue-property-decorator';
import Utils from '@/common/Utils';
import MylistAssistantHelper from '@/helpers/MylistAssistantHelper';
import { MusicStyle } from '@/models/MylistAssistantModel';

@Component({})
export default class MylistAssistant extends Vue {
  private musicList: Array<MusicStyle>;
  private music: MusicStyle;
  private isModalOpen: boolean;
  private hasEditAuth: boolean;
  private hasMasterEditAuth: boolean;

  constructor() {
    super();

    this.musicList = [];
    this.music = {
      title: '',
      niconico_id: '',
      favorite: false,
      skip: false
    };
    this.isModalOpen = false;
    this.hasEditAuth = false;
    this.hasMasterEditAuth = false;
  }

  private async mounted(): Promise<void> {
    if (!await MylistAssistantHelper.getAuthOfView()) {
      await Utils.changePage(this.$router, '/');
    }

    this.hasEditAuth = await MylistAssistantHelper.getAuthOfEdit();
    this.hasMasterEditAuth = await MylistAssistantHelper.getAuthOfMasterEdit();

    this.musicList = await MylistAssistantHelper.getAll();
  }

  private clickAdd(): void {
    if (!this.hasMasterEditAuth) return;

    this.music = {
      title: '',
      niconico_id: '',
      favorite: false,
      skip: false
    };
    this.isModalOpen = true;
  }

  private clickEdit(index: number): void {
    if (!this.hasEditAuth) return;

    this.music = this.musicList[index];
    this.isModalOpen = true;
  }

  private async clickDelete(index: number): Promise<void> {
    if (!this.hasMasterEditAuth) return;

    await MylistAssistantHelper.delete(index);
    this.musicList = await MylistAssistantHelper.getAll();
  }

  private async clickNowPlaying(): Promise<void> {
    if (!this.hasMasterEditAuth) return;

    const music = await MylistAssistantHelper.getNowPlayingInfo();
    this.music.niconico_id = music.video_id;
    this.music.title = music.title;
  }

  private async clickGetInfo(id: string): Promise<void> {
    if (!this.hasMasterEditAuth) return;

    const music = await MylistAssistantHelper.getNiconicoInfo(id);

    this.music.title = music.title;
  }

  private async clickDialogApply(): Promise<void> {
    this.music.favorite = [1, true].indexOf(this.music.favorite) !== -1;
    this.music.skip = [1, true].indexOf(this.music.skip) !== -1;
    if (this.music.music_id !== undefined) {
      if (!this.hasEditAuth) return;
      await MylistAssistantHelper.update(this.music.music_id, this.music);
    } else {
      if (!this.hasMasterEditAuth) return;
      await MylistAssistantHelper.add(this.music);
    }
    this.isModalOpen = false;
    this.musicList = await MylistAssistantHelper.getAll();
  }

  private clickDialogCancel(): void {
    this.isModalOpen = false;
  }
}
</script>
