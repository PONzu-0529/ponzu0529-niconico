<template>
  <div class="l-content">
    <div
      class="dialog"
      v-if="isModalOpen"
    >
      <div class="dialog-title">Edit</div>
      <div class="dialog-content">
        <div class="l-mylist-assistant-dialog-main">
          <div class="l-mylist-assistant-dialog-main-column">
            <div class="l-mylist-assistant-dialog-main-key">ID</div>
            <div class="l-mylist-assistant-dialog-main-value">
              <input
                class="field-content"
                :disabled="music.music_id"
                v-model="music.niconico_id"
              >
            </div>
          </div>
          <div class="l-mylist-assistant-dialog-main-column">
            <div class="l-mylist-assistant-dialog-main-key">Title</div>
            <div class="l-mylist-assistant-dialog-main-value">
              <input
                class="field-content"
                :disabled="!hasMasterEditAuth"
                v-model="music.title"
              >
            </div>
          </div>
          <div class="l-mylist-assistant-dialog-main-column">
            <div class="l-mylist-assistant-dialog-main-key">Favorite</div>
            <div class="l-mylist-assistant-dialog-main-value">
              <input
                class="field-content"
                type="checkbox"
                v-model="music.favorite"
              >
            </div>
          </div>
          <div class="l-mylist-assistant-dialog-main-column">
            <div class="l-mylist-assistant-dialog-main-key">Skip</div>
            <div class="l-mylist-assistant-dialog-main-value">
              <input
                class="field-content"
                type="checkbox"
                v-model="music.skip"
              >
            </div>
          </div>
          <div class="l-mylist-assistant-dialog-main-l-column">
            <div class="l-mylist-assistant-dialog-main-key">Memo</div>
            <div class="l-mylist-assistant-dialog-main-l-value">
              <textarea v-model="music.memo"></textarea>
            </div>
          </div>
        </div>
        <div class="l-mylist-assistant-dialog-option">
          <button
            class="btn-medium"
            :disabled="!hasMasterEditAuth"
            @click="clickNowPlaying"
          >Kiite</button>
          <button
            class="btn-medium"
            :disabled="!hasMasterEditAuth"
            @click="clickGetInfo(music.niconico_id)"
          >Info</button>
          <button
            class="btn-medium"
            @click="clickDialogApply"
          >Apply</button>
          <button
            class="btn-medium"
            @click="clickDialogCancel"
          >Cancel</button>
        </div>
      </div>
    </div>

    <div
      class="dialog"
      v-if="isEditDialogOpen"
    >
      <div class="dialog-title">Create Mylist</div>
      <div class="dialog-content">
        <div>
          Email:
          <input
            class=""
            v-model="customMylistParameter.email"
          >
        </div>
        <div>
          Password:
          <input
            class=""
            v-model="customMylistParameter.password"
            type="password"
          >
        </div>
        <div>
          Mylist Title:
          <input
            class=""
            v-model="customMylistParameter.mylist_title"
          >
        </div>
        <div>
          Count:
          <input
            class=""
            v-model="customMylistParameter.count"
            type="number"
          >
        </div>
        <div>
          <button
            class="btn-medium"
            @click="clickCreate"
          >Create</button>
          <button
            class="btn-medium"
            @click="clickEditDialogCancel"
          >Cancel</button>
        </div>
      </div>
    </div>

    <div
      class="overlay"
      v-if="isDialogOpen"
    ></div>

    <div class="l-mylist-assistant-option">
      <button
        class="btn-medium"
        :disabled="!hasMasterEditAuth"
        @click="clickAdd"
      >Add</button>
      <button
        class="btn-medium"
        :disabled="!hasMasterEditAuth"
        @click="clickAuto"
      >Auto</button>
    </div>

    <div class="l-mylist-assistant-main">
      <table>
        <thead>
          <tr>
            <th class="id">ID</th>
            <th class="title">タイトル</th>
            <th class="status">お気に入り</th>
            <th class="status">スキップ</th>
            <th class="option">オプション</th>
          </tr>
        </thead>
        <tbody>
          <template v-for="(music, index) in musicList">
            <tr :key="index">
              <td class="id">
                <a
                  :href="`https://www.nicovideo.jp/watch/${music.niconico_id}`"
                  target="_blank"
                  rel="noreferrer noopener"
                >{{ music.niconico_id }}</a>
              </td>
              <td class="title">{{ music.title }}</td>
              <td class="status">{{ music.favorite === 1 }}</td>
              <td class="status">{{ music.skip === 1 }}</td>
              <td class="option">
                <button
                  class="btn-medium"
                  :disabled="!hasEditAuth"
                  @click="clickEdit(index)"
                >Edit</button>
                <button
                  class="btn-medium"
                  :disabled="!hasMasterEditAuth"
                  @click="clickDelete(music.music_id)"
                >Delete</button>
              </td>
            </tr>
          </template>
        </tbody>
      </table>
    </div>
  </div>
  <!-- <div class="main">
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
  </div> -->
</template>

<script lang="ts">
import { Component, Watch } from 'vue-property-decorator';
import Utils from '@/common/Utils';
import MylistAssistantHelper from '@/helpers/MylistAssistantHelper';
import { MusicStyle, CreateCustomMylistStyle } from '@/models/MylistAssistantModel';
import BaseView from '@/views/BaseView.vue';

@Component({})
export default class MylistAssistant extends BaseView {
  private musicList: Array<MusicStyle>;
  private music: MusicStyle;

  /** Parameter of Custom Mylist */
  private customMylistParameter: CreateCustomMylistStyle;

  private isModalOpen: boolean;

  /** Custom Mylist Dialog Open Flag */
  private isEditDialogOpen: boolean;

  private hasEditAuth: boolean;
  private hasMasterEditAuth: boolean;

  constructor() {
    super();

    this.musicList = [];
    this.music = {
      title: '',
      niconico_id: '',
      favorite: false,
      skip: false,
      memo: ''
    };
    this.customMylistParameter = {
      count: 100,
      email: '',
      password: '',
      mylist_title: 'CustomMylist'
    };
    this.isModalOpen = false;
    this.isEditDialogOpen = false;
    this.hasEditAuth = false;
    this.hasMasterEditAuth = false;
  }

  @Watch('music.niconico_id')
  private onChangeNiconicoId() {
    if (this.checkExist(this.music.niconico_id)) {
      this.music = this.musicList.filter(music => music.niconico_id === this.music.niconico_id)[0];
    }
  }

  /**
   * Get State of Dialog Open
   * @returns Is Dialog Open
   */
  private get isDialogOpen(): boolean {
    return this.isModalOpen || this.isEditDialogOpen;
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
      skip: false,
      memo: ''
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

  /**
   * Check Exist Music by NiconicoID
   * @param niconico_id NiconicoID
   * @returns Exist: true, Not Exist: false
   */
  private checkExist(niconico_id: string): boolean {
    return this.musicList.filter(music => music.niconico_id === niconico_id).length !== 0;
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

  /**
   * Click Auto Button
   */
  private clickAuto(): void {
    this.isEditDialogOpen = true;
  }

  /**
   * Click Create Button
   */
  private async clickCreate(): Promise<void> {
    MylistAssistantHelper.createCustomMylist(this.customMylistParameter);
  }

  /**
   * Click Cancel Button of Click Edit Dialog
   */
  private clickEditDialogCancel(): void {
    this.isEditDialogOpen = false;
  }
}
</script>
