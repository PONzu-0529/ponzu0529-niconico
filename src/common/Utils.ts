import router from 'vue-router';

export default class Utils {
  /**
   * Change Page
   * @param router this.$router
   * @param page Target Page
   * @param withVue with Vue
   */
  public static async changePage(router: router, page: string, withVue = true): Promise<void> {
    if (withVue) {
      router.push(page);
    } else {
      window.location.href = page;
    }
  }

  /**
   * Get Host with Protocol
   * @returns Protocol + Host
   */
  public static getHostWithProtocol(): string {
    return `${location.protocol}//${location.hostname}`;
  }
}
