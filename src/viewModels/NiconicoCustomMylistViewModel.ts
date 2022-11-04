import { ApiModel } from '@/models/ApiModel'
import { VocaloidMusicStyle } from '@/models/VocaloidMusicModel'
import Base from '@/viewModels/Base'
import { Component } from 'vue-property-decorator'

@Component({})
export default class NiconicoCustomMylistViewModel extends Base {
  public async getMusicList(): Promise<Array<VocaloidMusicStyle>> {
    const callApiResult = await ApiModel.callApi({
      url: `${ApiModel.get_host()}/api/v1/vocaloid-music/get-music-list`,
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
}
