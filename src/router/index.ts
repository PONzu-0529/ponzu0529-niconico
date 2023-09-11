import Vue from 'vue';
import VueRouter, { RouteConfig } from 'vue-router';
import Home from '@/views/Home.vue';
import CheckTodofuken from '@/views/CheckTodofuken.vue';
import ConvertTransfers from '@/views/ConvertTransfers.vue';
import CreateBibliography from '@/views/CreateBibliography.vue';
import FilterInPokemonGo from '@/views/FilterInPokemonGo.vue';
import MylistAssistant from '@/views/MylistAssistant.vue';
import Test from '@/views/Test.vue';
import Error from '@/views/Error.vue';
import Utils from '@/common/Utils';

Vue.use(VueRouter);

const routes: Array<RouteConfig> = [
  {
    path: '/',
    name: 'Home',
    component: Home
  },
  {
    path: '/convert-transfers',
    name: 'ConvertTransfers',
    component: ConvertTransfers
  },
  {
    path: '/create-bibliography',
    name: 'CreateBibliography',
    component: CreateBibliography
  },
  {
    path: '/filter-in-pokemongo',
    name: 'FilterInPokemonGo',
    component: FilterInPokemonGo
  },
  {
    path: '/mylist-assistant',
    component: MylistAssistant
  },
  {
    path: '*',
    name: 'error',
    component: Error
  }
];

if (Utils.getEnv() === 'development') {
  routes.push({
    path: '/test',
    name: 'Test',
    component: Test
  });
}

const router = new VueRouter({
  mode: 'history',
  base: process.env.BASE_URL,
  routes
});

export default router;
