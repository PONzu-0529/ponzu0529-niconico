import 'reflect-metadata';
import Vue from 'vue';
import Buefy from 'buefy';
import VModal from 'vue-js-modal';
import VueHead from 'vue-head';
import App from './App.vue';
import router from './router';
import store from './store';

import TitleHelper from './helpers/TitleHelper';
import { ContainerHelper } from './helpers/ContainerHelper';

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

// Bind Services
// ContainerHelper.bind('SampleService1', SampleService1);

// Rebind Services for Mocks
if (process.env.is_served) {
  // ContainerHelper.rebind('SampleService1', SampleService1Mock);
}

router.beforeEach((to, from, next) => {
  TitleHelper.setTitleByPath(to.path);

  next();
});

new Vue({
  router,
  store,
  render: h => h(App)
}).$mount('#app');
