<template>
  <div class="mylist-assistant">
    <div class="title">Mylist Assistant</div>
    <div class="content">
      <div class="upper-content">
        <div class="upper-left-content"></div>
        <div class="upper-right-content">
          <button
            @click="clickAdd"
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
                <td>{{ music.niconico_id }}</td>
                <td>{{ music.title }}</td>
                <td>{{ music.favorite === 1 }}</td>
                <td>{{ music.skip === 1 }}</td>
                <td>
                  <button
                    @click="clickEdit(index)"
                    class="btn-medium"
                  >Edit</button>
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
              class="field-content"
            />
          </div>
          <div class="field">
            <div class="field-lavel">Title</div>
            <input
              v-model="music.title"
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
import { MusicStyle } from '@/models/MylistAssistantModel';
import MylistAssistantHelper from '@/helpers/MylistAssistantHelper';

@Component({})
export default class MylistAssistant extends Vue {
  private musicList: Array<MusicStyle>;
  private music: MusicStyle;
  private isModalOpen: boolean;

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
  }

  private async mounted(): Promise<void> {
    this.musicList = await MylistAssistantHelper.getAll();
  }

  private clickAdd(): void {
    this.music = {
      title: '',
      niconico_id: '',
      favorite: false,
      skip: false
    };
    this.isModalOpen = true;
  }

  private clickEdit(index: number): void {
    this.music = this.musicList[index];
    this.isModalOpen = true;
  }

  private async clickDialogApply(): Promise<void> {
    this.music.favorite = [1, true].indexOf(this.music.favorite) !== -1;
    this.music.skip = [1, true].indexOf(this.music.skip) !== -1;
    if (this.music.music_id !== undefined) {
      await MylistAssistantHelper.update(this.music.music_id, this.music);
    } else {
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
