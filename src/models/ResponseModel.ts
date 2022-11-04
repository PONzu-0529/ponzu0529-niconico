import { VocaloidMusicStyle } from '@/models/VocaloidMusicModel'


export default interface ResponseStyle {
  status: 'success' | 'failuer',
  body: string | Array<VocaloidMusicStyle>
}
