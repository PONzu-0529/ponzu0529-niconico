<template>
  <div class="l-content half">
    <div
      class="l-half-left-title"
      @click="leftClick"
    >変換元</div>
    <div
      class="l-half-right-title"
      @click="rightClick"
    >変換先</div>
    <template v-if="!(isSmartphone && !isLeft)">
      <div class="l-half-left-content">
        <div class="l-create-bibliography-content">
          <div class="l-create-bibliography-top">
            <select
              class="select-medium"
              v-model="baseType"
            >
              <option value="web">webページ</option>
              <option value="book">書籍</option>
              <option value="thesis">論文</option>
            </select>
          </div>
          <template v-if="baseType === 'web'">
            <div class="l-create-bibliography-main">
              <div class="l-create-bibliography-main-column">
                <div class="l-create-bibliography-main-key">URL</div>
                <div class="l-create-bibliography-main-value">
                  <input
                    type="url"
                    key="web.url"
                    v-model="web.url"
                  >
                </div>
              </div>
              <div class="l-create-bibliography-main-column">
                <div class="l-create-bibliography-main-key">Page</div>
                <div class="l-create-bibliography-main-value">
                  <input
                    type="text"
                    key="web.page_title"
                    v-model="web.page_title"
                  >
                </div>
              </div>
              <div class="l-create-bibliography-main-column">
                <div class="l-create-bibliography-main-key">Site</div>
                <div class="l-create-bibliography-main-value">
                  <input
                    type="text"
                    key="web.cite_title"
                    v-model="web.cite_title"
                  >
                </div>
              </div>
              <div class="l-create-bibliography-main-column">
                <div class="l-create-bibliography-main-key">View</div>
                <div class="l-create-bibliography-main-value">
                  <input
                    type="date"
                    key="web.read"
                    v-model="web.read"
                  >
                </div>
              </div>
            </div>
          </template>
          <template v-if="baseType === 'book'">
            <div class="l-create-bibliography-main">
              <div class="l-create-bibliography-main-column">
                <div class="l-create-bibliography-main-key">Title</div>
                <div class="l-create-bibliography-main-value">
                  <input
                    type="text"
                    key="book.title"
                    v-model="book.title"
                  >
                </div>
              </div>
              <div class="l-create-bibliography-main-column">
                <div class="l-create-bibliography-main-key">Author</div>
                <div class="l-create-bibliography-main-value">
                  <input
                    type="text"
                    key="book.authors[0]"
                    v-model="book.authors[0]"
                  >
                </div>
              </div>
              <div class="l-create-bibliography-main-column">
                <div class="l-create-bibliography-main-key">Create</div>
                <div class="l-create-bibliography-main-value">
                  <input
                    type="date"
                    key="book.created"
                    v-model="book.created"
                  >
                </div>
              </div>
              <div class="l-create-bibliography-main-column">
                <div class="l-create-bibliography-main-key">View</div>
                <div class="l-create-bibliography-main-value">
                  <input
                    type="date"
                    key="book.read"
                    v-model="book.read"
                  >
                </div>
              </div>
            </div>
          </template>
          <template v-if="baseType === 'thesis'">
            <div class="l-create-bibliography-main">
              <div class="l-create-bibliography-main-column">
                <div class="l-create-bibliography-main-key">Title</div>
                <div class="l-create-bibliography-main-value">
                  <input
                    type="text"
                    key="thesis.title"
                    v-model="thesis.title"
                  >
                </div>
              </div>
              <div class="l-create-bibliography-main-column">
                <div class="l-create-bibliography-main-key">Author</div>
                <div class="l-create-bibliography-main-value">
                  <input
                    type="text"
                    key="thesis.authors[0]"
                    v-model="thesis.authors[0]"
                  >
                </div>
              </div>
              <div class="l-create-bibliography-main-column">
                <div class="l-create-bibliography-main-key">Create</div>
                <div class="l-create-bibliography-main-value">
                  <input
                    type="date"
                    key="thesis.created"
                    v-model="thesis.created"
                  >
                </div>
              </div>
              <div class="l-create-bibliography-main-column">
                <div class="l-create-bibliography-main-key">View</div>
                <div class="l-create-bibliography-main-value">
                  <input
                    type="date"
                    key="thesis.read"
                    v-model="thesis.read"
                  >
                </div>
              </div>
            </div>
          </template>
          <div class="l-create-bibliography-option">
            <button
              class="btn-medium"
              v-if="baseType === 'web'"
              @click="encodeUrl"
            >Convert</button>
            <!-- <button
              class="btn-medium"
              v-if="baseType === 'web'"
              @click="getWebInfo"
            >Info</button> -->
            <button
              class="btn-medium"
              @click="clear"
            >Clear</button>
          </div>
        </div>
      </div>
    </template>
    <template v-if="!(isSmartphone && isLeft)">
      <div class="l-half-right-content">
        <div class="l-create-bibliography-content">
          <div class="l-create-bibliography-main right">
            <textarea v-model="output"></textarea>
          </div>
          <div class="l-create-bibliography-option">
            <button
              class="btn-medium"
              @click="copy"
            >Copy</button>
          </div>
        </div>
      </div>
    </template>
  </div>
</template>

<script lang="ts">
import { Component, Watch } from 'vue-property-decorator';
import dayjs from 'dayjs';
import Web from '@/Web';
import BaseView from '@/views/BaseView.vue';

@Component
export default class CreateBibliography extends BaseView {
  private baseType: 'web' | 'book' | 'thesis' = 'web';

  private convertType: 'text' = 'text';

  private web: WebStyle = {
    page_title: '',
    cite_title: '',
    url: '',
    read: dayjs().format('YYYY-MM-DD'),
  };

  private book: BookStyle = {
    title: '',
    authors: [''],
    created: dayjs('0000-00-00').format('YYYY-MM-DD'),
    read: dayjs().format('YYYY-MM-DD'),
  };

  private thesis: ThesisStyle = {
    title: '',
    authors: [''],
    created: dayjs('0000-00-00').format('YYYY-MM-DD'),
    read: dayjs().format('YYYY-MM-DD'),
  };

  @Watch('baseType')
  private onChangeType() {
    this.initAllStyle();
  }

  private get output(): string {
    switch (this.baseType) {
      case 'web':
        return [
          `『${this.web.page_title}』`,
          this.web.cite_title,
          this.web.url,
          this.web.read,
        ].join(', ');

      case 'book':
        return [
          `『${this.book.title}』`,
          this.book.authors.map((author) => {
            return author;
          }),
          this.book.created,
          this.book.read,
        ].join(', ');

      case 'thesis':
        return [
          `『${this.thesis.title}』`,
          this.thesis.authors.map((author) => {
            return author;
          }),
          this.thesis.created,
          this.thesis.read,
        ].join(', ');

      default:
        return '';
    }
  }

  private created() {
    this.initAllStyle();
  }

  private initAllStyle() {
    this.initWebStyle();
    this.initBookStyle();
    this.initThesisStyle();
  }

  private initWebStyle() {
    this.web.page_title = '';
    this.web.cite_title = '';
    this.web.url = '';
    this.web.read = dayjs().format('YYYY-MM-DD');
  }

  private initBookStyle() {
    this.book.title = '';
    this.book.authors = [''];
    this.book.created = dayjs('0000-00-00').format('YYYY-MM-DD');
    this.book.read = dayjs().format('YYYY-MM-DD');
  }

  private initThesisStyle() {
    this.thesis.title = '';
    this.thesis.authors = [''];
    this.thesis.created = dayjs('0000-00-00').format('YYYY-MM-DD');
    this.thesis.read = dayjs().format('YYYY-MM-DD');
  }

  /**
   * URL変換
   */
  private encodeUrl() {
    this.web.url = decodeURI(this.web.url);
  }

  /**
   * Web情報取得
   */
  private async getWebInfo() {
    const result = await Web.getWebInfo(this.web.url);

    if (typeof result !== 'boolean') {
      this.web.page_title = result;
    }
  }

  /**
   * クリア
   */
  private clear() {
    this.initAllStyle();
  }

  /**
   * コピー
   */
  private copy() {
    navigator.clipboard.writeText(this.output);
  }
}

interface WebStyle {
  page_title: string;
  cite_title: string;
  url: string;
  authors?: Array<string>;
  created?: string;
  read: string;
}

interface BookStyle {
  title: string;
  authors: Array<string>;
  state?: string;
  created: string;
  startPage?: number;
  endPage?: number;
  read: string;
}

interface ThesisStyle {
  title: string;
  authors: Array<string>;
  state?: string;
  created: string;
  startPage?: number;
  endPage?: number;
  read: string;
}
</script>
