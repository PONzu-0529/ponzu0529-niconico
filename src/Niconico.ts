import _ from "lodash"
import axios, { AxiosRequestConfig } from "axios"

export default class User {
  private static get url(): string {
    switch (process.env.NODE_ENV) {
      case "development": {
        return "http://localhost"
      }

      case "production": {
        return "https://tools.ponzu0529.com"
      }

      default: {
        return "http://localhost"
      }
    }
  }

  static async getOfficialInfo(video_id: string): Promise<string | boolean> {
    const accessToken = localStorage.getItem("accessToken")

    if (!accessToken) return false

    const options: AxiosRequestConfig = {
      url: `${this.url}/api/niconico/get-official-info`,
      method: "POST",
      data: {
        accessToken: accessToken,
        videoId: video_id
      },
    }

    const result = await axios(options)

    if (_.get(result, 'data.status', '') !== 'success') {
      return false
    }

    return _.get(result, 'data.title.0', '')
  }

  static async readAllVideos(): Promise<Array<music> | boolean> {
    const accessToken = localStorage.getItem("accessToken")

    if (!accessToken) return false

    const options: AxiosRequestConfig = {
      url: `${this.url}/api/niconico/read-all-videos`,
      method: "POST",
      data: {
        accessToken: accessToken,
      },
    }

    const result = await axios(options)

    if (_.get(result, 'data.status', '') !== 'success') {
      return false
    }

    return _.get(result, 'data.videos', [])
  }

  static async createVideo(video: music): Promise<boolean> {
    const accessToken = localStorage.getItem("accessToken")

    if (!accessToken) return false

    const options: AxiosRequestConfig = {
      url: `${this.url}/api/niconico/create-video`,
      method: "POST",
      data: {
        accessToken: accessToken,
        videoId: video.video_id,
        title: video.title,
        favorite: video.favorite,
        skip: video.skip
      },
    }

    const result = await axios(options)

    if (_.get(result, 'data.status', '') !== 'success') {
      return false
    }

    return true
  }

  static async updateVideo(video: music): Promise<boolean> {
    const accessToken = localStorage.getItem("accessToken")

    if (!accessToken) return false

    // Validation
    if (!_.hasIn(video, 'id')) return false

    const options: AxiosRequestConfig = {
      url: `${this.url}/api/niconico/update-video`,
      method: "POST",
      data: {
        accessToken: accessToken,
        id: video.id,
        videoId: video.video_id,
        title: video.title,
        favorite: video.favorite,
        skip: video.skip
      },
    }

    const result = await axios(options)

    if (_.get(result, 'data.status', '') !== 'success') {
      return false
    }

    return true
  }
}

export interface music {
  id?: number,
  video_id: string,
  title: string,
  favorite: boolean,
  skip: boolean
}
