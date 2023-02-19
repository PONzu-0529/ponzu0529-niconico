export interface ResponseStyle<T = any> {
  status: 'success' | 'failuer',
  data: T
}
