export class VocaloidMusicModel implements VocaloidMusicStyle {
  id: number
  video_id: string
  title: string
  description: string
  vocal_id_list: Array<number>
  creater_id_list: Array<number>
  favorite_lank: 5 | 4 | 3 | 2 | 1 | 0 | -1

  public static getFavoriteLank(favoriteLankNumber: number): string {
    switch (favoriteLankNumber) {
      case 5:
        return '★★★★★'

      case 4:
        return '★★★★'

      case 3:
        return '★★★'

      case 2:
        return '★★'

      case 1:
        return '★'

      case -1:
        return 'スキップ'

      case 0:
      default:
        return '未設定'
    }
  }
}


export interface VocaloidMusicStyle {
  id: number,
  video_id: string,
  title: string,
  description: string,
  vocal_id_list: Array<number>,
  creater_id_list: Array<number>,
  favorite_lank: 5 | 4 | 3 | 2 | 1 | 0 | -1
}
