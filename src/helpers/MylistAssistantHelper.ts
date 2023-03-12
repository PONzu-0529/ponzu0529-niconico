import Utils from '@/common/Utils';
import ApiHelper from '@/common/ApiHelper';
import { MusicStyle } from '@/models/MylistAssistantModel';

export default class MylistAssistantHelper {
  public static async getAuth(): Promise<boolean> {
    return await ApiHelper.get(`${Utils.getHostWithProtocol()}/api/auth/mylist-assistant`);
  }

  public static async getAll(): Promise<Array<MusicStyle>> {
    return await ApiHelper.get(`${Utils.getHostWithProtocol()}/api/mylist-assistant`);
  }

  public static async getById(id: number): Promise<MusicStyle> {
    return await ApiHelper.get(`${Utils.getHostWithProtocol()}/api/mylist-assistant/${id}`);
  }

  public static async add(music: MusicStyle): Promise<void> {
    return await ApiHelper.post(
      `${Utils.getHostWithProtocol()}/api/mylist-assistant`,
      {
        title: music.title,
        niconico_id: music.niconico_id
      }
    );
  }

  public static async update(id: number, music: MusicStyle): Promise<void> {
    return await ApiHelper.put(
      `${Utils.getHostWithProtocol()}/api/mylist-assistant/${id}`,
      {
        title: music.title,
        niconico_id: music.niconico_id
      }
    );
  }

  public static async delete(id: number): Promise<void> {
    return await ApiHelper.delete(`${Utils.getHostWithProtocol()}/api/mylist-assistant/${id}`);
  }
}