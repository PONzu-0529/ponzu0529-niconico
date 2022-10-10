<template>
  <div class="error">
    <h1 class="title">ERROR!!!</h1>
    <p>ページが移動された可能性があります。</p>
    <Links />
  </div>
</template>

<script lang="ts">
import { Vue, Component } from "vue-property-decorator"
import Links from '@/components/Links.vue'

@Component({
  components: {
    Links,
  },
})
export default class Error extends Vue {}
</script>
