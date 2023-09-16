import Vue from 'vue';
import VueRouter, { RouteConfig } from 'vue-router';
import Home from '@/views/Home.vue';
import CheckTodofuken from '@/views/CheckTodofuken.vue';
import ConvertTransfers from '@/views/ConvertTransfers.vue';
import CreateBibliography from '@/views/CreateBibliography.vue';
import FilterInPokemonGo from '@/views/FilterInPokemonGo.vue';
import MoneyAssistant from '@/views/MoneyAssistant.vue';
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
    path: '/money-assistant',
    name: 'MoneyAssistant',
    component: MoneyAssistant
  },
  {
    path: '*',
    name: 'error',
    component: Error
  }
];

if (Utils.getEnv() === 'development') {
  const devRoutes: Array<RouteConfig> = [
    {
      path: '/test',
      name: 'Test',
      component: Test
    },
    {
      path: '/money-assistant-design',
      name: 'MoneyAssistantDesign',
      component: MoneyAssistant
    }
  ];

  routes.push(...devRoutes);
}

const router = new VueRouter({
  mode: 'history',
  base: process.env.BASE_URL,
  routes
});

export default router;
