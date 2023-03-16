import Utils from '@/common/Utils';
import ApiHelper from '@/common/ApiHelper';
import { MusicStyle } from '@/models/MylistAssistantModel';
import { NowPlayingStyle } from '@/interfaces/KiiteInfoStyle';
import { NiconicoInfo } from '@/interfaces/NiconicoInfoStyle';

export default class MylistAssistantHelper {
  public static async getAuth(): Promise<boolean> {
    return await ApiHelper.get(`${Utils.getHostWithProtocol()}/api/auth/mylist-assistant`);
  }

  public static async getAuthOfView(): Promise<boolean> {
    return await ApiHelper.get(`${Utils.getHostWithProtocol()}/api/auth/mylist-assistant?level=VIEW`);
  }

  public static async getAuthOfEdit(): Promise<boolean> {
    return await ApiHelper.get(`${Utils.getHostWithProtocol()}/api/auth/mylist-assistant?level=EDIT`);
  }

  public static async getAuthOfMasterEdit(): Promise<boolean> {
    return await ApiHelper.get(`${Utils.getHostWithProtocol()}/api/auth/mylist-assistant?level=MASTER_EDIT`);
  }

  public static async getAll(): Promise<Array<MusicStyle>> {
    return await ApiHelper.get(`${Utils.getHostWithProtocol()}/api/mylist-assistant`);
  }

  public static async getById(id: number): Promise<MusicStyle> {
    return await ApiHelper.get(`${Utils.getHostWithProtocol()}/api/mylist-assistant/${id}`);
  }

  public static async add(music: MusicStyle): Promise<void> {
    return await ApiHelper.post(`${Utils.getHostWithProtocol()}/api/mylist-assistant`, music);
  }

  public static async update(id: number, music: MusicStyle): Promise<void> {
    return await ApiHelper.put(`${Utils.getHostWithProtocol()}/api/mylist-assistant/${id}`, music);
  }

  public static async delete(id: number): Promise<void> {
    return await ApiHelper.delete(`${Utils.getHostWithProtocol()}/api/mylist-assistant/${id}`);
  }

  public static async getNiconicoInfo(id: string): Promise<NiconicoInfo> {
    return await ApiHelper.get(`${Utils.getHostWithProtocol()}/api/mylist-assistant/get-niconico-info?id=${id}`);
  }

  public static async getNowPlayingInfo(): Promise<NowPlayingStyle> {
    return await ApiHelper.get(`${Utils.getHostWithProtocol()}/api/mylist-assistant/get-now-playing-info`);
  }
}