import Vue from 'vue';
import Buefy from 'buefy';
import VModal from 'vue-js-modal';
import VueHead from 'vue-head';
import App from './App.vue';
import router from './router';
import store from './store';

import TitleHelper from './helpers/TitleHelper';

// FontAwesome
import { library } from '@fortawesome/fontawesome-svg-core';
import { faMusic, faTrainSubway, faBook, faGamepad } from '@fortawesome/free-solid-svg-icons';
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome';

Vue.config.productionTip = false;

Vue.use(Buefy);
Vue.use(VModal);
Vue.use(VueHead);

// FontAwesome
library.add(faMusic, faTrainSubway, faBook, faGamepad);
Vue.component('font-awesome-icon', FontAwesomeIcon);

router.beforeEach((to, from, next) => {
  TitleHelper.setTitleByPath(to.path);

  next();
});

new Vue({
  router,
  store,
  render: h => h(App)
}).$mount('#app');
