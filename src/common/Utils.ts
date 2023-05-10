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

  /**
   * Get Environment
   * @returns development or production (or test)
   */
  public static getEnv(): string {
    return process.env.NODE_ENV ?? 'development';
  }

  /**
   * Check Width for Smartphone
   * @returns true or false
   */
  public static isSmartphone(width: number = document.body.clientWidth): boolean {
    return width < 480;
  }

  public static overlay(): void {
    (<HTMLElement> document.getElementsByClassName('overlay')[0]).style.removeProperty('display');
  }

  public static clearOverlay(): void {
    (<HTMLElement> document.getElementsByClassName('overlay')[0]).style.display = 'none';
  }
}
