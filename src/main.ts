import Vue from 'vue'
import Buefy from 'buefy'
import VModal from 'vue-js-modal'
import VueHead from 'vue-head'
import App from './App.vue'
import router from './router'
import store from './store'
import 'buefy/dist/buefy.css'

Vue.config.productionTip = false

Vue.use(Buefy)
Vue.use(VModal)
Vue.use(VueHead)

new Vue({
  router,
  store,
  render: h => h(App)
}).$mount('#app')
