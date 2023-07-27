export default class MylistAssistantModel {}

export interface MusicStyle {
  music_id?: number;
  title: string
  niconico_id: string
  favorite: boolean
  skip: boolean
  memo: string
}

/**
 * CreateCustomMylist Style
 */
export interface CreateCustomMylistStyle {
  /** Count */
  count: number;

  /** Email */
  email: string;

  /** Password */
  password: string;

  /** Mylist Title */
  mylist_title: string;
}
