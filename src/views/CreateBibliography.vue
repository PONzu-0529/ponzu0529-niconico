<template>
  <div class="create-bibliography">
    <h1 class="title">参考文献つくーる</h1>
    <div class="flex-container">
      <div class="flex-item">
        <h2 class="subtitle">変換元</h2>
        <b-field>
          <b-select v-model="baseType">
            <option value="web">webページ</option>
            <option value="book">書籍</option>
            <option value="thesis">論文</option>
          </b-select>
        </b-field>
        <template v-if="baseType === 'web'">
          <b-field horizontal label="URL">
            <b-input type="url" key="web.url" v-model="web.url"></b-input>
          </b-field>
          <b-field horizontal label="ページ名" message="参照したページの名称">
            <b-input
              type="text"
              key="web.page_title"
              v-model="web.page_title"
            ></b-input>
          </b-field>
          <b-field
            horizontal
            label="サイト名"
            message="参照したページ元のサイトの名称"
          >
            <b-input
              type="text"
              key="web.cite_title"
              v-model="web.cite_title"
            ></b-input>
          </b-field>
          <b-field horizontal label="閲覧日">
            <b-input type="date" key="web.read" v-model="web.read"></b-input>
          </b-field>
        </template>
        <template v-if="baseType === 'book'">
          <b-field horizontal label="タイトル">
            <b-input
              type="text"
              key="book.title"
              v-model="book.title"
            ></b-input>
          </b-field>
          <b-field horizontal label="著者">
            <b-input
              type="text"
              key="book.authors[0]"
              v-model="book.authors[0]"
            ></b-input>
          </b-field>
          <b-field horizontal label="作成日">
            <b-input
              type="date"
              key="book.created"
              v-model="book.created"
            ></b-input>
          </b-field>
          <b-field horizontal label="閲覧日">
            <b-input type="date" key="book.read" v-model="book.read"></b-input>
          </b-field>
        </template>
        <template v-if="baseType === 'thesis'">
          <b-field horizontal label="タイトル">
            <b-input
              type="text"
              key="thesis.title"
              v-model="thesis.title"
            ></b-input>
          </b-field>
          <b-field horizontal label="著者">
            <b-input
              type="text"
              key="thesis.authors[0]"
              v-model="thesis.authors[0]"
            ></b-input>
          </b-field>
          <b-field horizontal label="作成日">
            <b-input
              type="date"
              key="thesis.created"
              v-model="thesis.created"
            ></b-input>
          </b-field>
          <b-field horizontal label="閲覧日">
            <b-input
              type="date"
              key="thesis.read"
              v-model="thesis.read"
            ></b-input>
          </b-field>
        </template>
        <b-field horizontal>
          <b-button v-if="baseType === 'web'" @click="encodeUrl">
            URL変換
          </b-button>
          <b-button v-if="baseType === 'web'" @click="getWebInfo">
            Web情報取得
          </b-button>
          <b-button @click="clear">クリア</b-button>
        </b-field>
      </div>
      <div class="flex-item">
        <h2 class="subtitle">変換先</h2>
        <b-field>
          <b-input type="textarea" v-model="output"></b-input>
        </b-field>
        <b-field horizontal>
          <b-button @click="copy">コピー</b-button>
        </b-field>
      </div>
    </div>
  </div>
</template>

<script lang="ts">
import { Vue, Component, Watch } from "vue-property-decorator"
import dayjs from "dayjs"
import Web from "@/Web"

@Component
export default class CreateBibliography extends Vue {
  private baseType: "web" | "book" | "thesis" = "web";

  private convertType: "text" = "text";

  private web: WebStyle = {
    page_title: "",
    cite_title: "",
    url: "",
    read: dayjs().format("YYYY-MM-DD"),
  };

  private book: BookStyle = {
    title: "",
    authors: [""],
    created: dayjs("0000-00-00").format("YYYY-MM-DD"),
    read: dayjs().format("YYYY-MM-DD"),
  };

  private thesis: ThesisStyle = {
    title: "",
    authors: [""],
    created: dayjs("0000-00-00").format("YYYY-MM-DD"),
    read: dayjs().format("YYYY-MM-DD"),
  };

  @Watch("baseType")
  private onChangeType() {
    this.initAllStyle()
  }

  private get output(): string {
    switch (this.baseType) {
      case "web":
        return [
          `『${this.web.page_title}』`,
          this.web.cite_title,
          this.web.url,
          this.web.read,
        ].join(", ")

      case "book":
        return [
          `『${this.book.title}』`,
          this.book.authors.map((author) => {
            return author
          }),
          this.book.created,
          this.book.read,
        ].join(", ")

      case "thesis":
        return [
          `『${this.thesis.title}』`,
          this.thesis.authors.map((author) => {
            return author
          }),
          this.thesis.created,
          this.thesis.read,
        ].join(", ")

      default:
        return ""
    }
  }

  private created() {
    this.initAllStyle()
  }

  private initAllStyle() {
    this.initWebStyle()
    this.initBookStyle()
    this.initThesisStyle()
  }

  private initWebStyle() {
    this.web.page_title = ""
    this.web.cite_title = ""
    this.web.url = ""
    this.web.read = dayjs().format("YYYY-MM-DD")
  }

  private initBookStyle() {
    this.book.title = ""
    this.book.authors = [""]
    this.book.created = dayjs("0000-00-00").format("YYYY-MM-DD")
    this.book.read = dayjs().format("YYYY-MM-DD")
  }

  private initThesisStyle() {
    this.thesis.title = ""
    this.thesis.authors = [""]
    this.thesis.created = dayjs("0000-00-00").format("YYYY-MM-DD")
    this.thesis.read = dayjs().format("YYYY-MM-DD")
  }

  /**
   * URL変換
   */
  private encodeUrl() {
    this.web.url = decodeURI(this.web.url)
  }

  /**
   * Web情報取得
   */
  private async getWebInfo() {
    const result = await Web.getWebInfo(this.web.url)

    if (typeof result !== "boolean") {
      this.web.page_title = result
    }
  }

  /**
   * クリア
   */
  private clear() {
    this.initAllStyle()
  }

  /**
   * コピー
   */
  private copy() {
    navigator.clipboard.writeText(this.output)
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
