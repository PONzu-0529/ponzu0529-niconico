<template>
  <div class="home">
    <h1 class="title">PONずの便利ツール箱</h1>
    <Links />
  </div>
</template>

<script lang="ts">
import { Component, Vue } from 'vue-property-decorator'
import Links from '@/components/Links.vue'

@Component({
  components: {
    Links,
  },
})
export default class Home extends Vue {}
</script>
