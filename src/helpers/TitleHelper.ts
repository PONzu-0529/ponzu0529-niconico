export default class TitleHelper {
  public static setTitleByPath(path: string): void {
    const routes = [
      {
        path: '/',
        title: 'PONずの便利ツール箱'
      },
      {
        path: '/convert-transfers',
        title: '乗り換え変換ツール'
      },
      {
        path: '/create-bibliography',
        title: '参考文献つくーる'
      },
      {
        path: '/filter-in-pokemongo',
        title: 'ポケGO検索アシスト'
      },
      {
        path: '/mylist-assistant',
        title: 'マイリストアシスタント'
      },
      {
        path: '/test',
        title: 'テストページ'
      }
    ];

    const result = routes.filter(route => route.path === path);

    const elem = document.getElementById('ponzu-tools-title');

    if (elem === null) return;

    elem.innerText = result.length !== 0 ? result[0].title : 'ERROR';
  }
}