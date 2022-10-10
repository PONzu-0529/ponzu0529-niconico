import Vue from 'vue'
import VueRouter, { RouteConfig } from 'vue-router'
import Home from '@/views/Home.vue'
import CheckTodofuken from '@/views/CheckTodofuken.vue'
import ConvertTransfers from '@/views/ConvertTransfers.vue'
import CreateBibliography from '@/views/CreateBibliography.vue'
import FilterInPokemonGo from '@/views/FilterInPokemonGo.vue'
import NiconicoCustomMylist from '@/views/NiconicoCustomMylist.vue'
import Error from '@/views/Error.vue'

Vue.use(VueRouter)

const routes: Array<RouteConfig> = [
  {
    path: '/',
    name: 'Home',
    component: Home
  },
  {
    path: '/check-todofuken',
    name: 'CheckTodofuken',
    component: CheckTodofuken
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
    path: '/niconico-custom-mylist',
    name: 'NiconicoCustomMylist',
    component: NiconicoCustomMylist
  },
  {
    path: '*',
    name: 'error',
    component: Error
  }
]

const router = new VueRouter({
  mode: 'history',
  base: process.env.BASE_URL,
  routes
})

export default router
