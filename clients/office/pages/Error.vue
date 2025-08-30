<template>
  <h1>{{ status }} {{ status_text }}</h1>
  <h2>{{ message }}</h2>
  <div>
    {{ page.props.flash.error }}<br>
    {{ page.props.flash.message }}
  </div>
</template>
<script lang="ts" setup>
import { usePage } from '@inertiajs/vue3';

const props = withDefaults(defineProps<{
  status?: number | string,
  status_text?: string,
  message?: string,
}>(), {

});

const page = usePage();

</script>
<style lang="scss" scoped>

</style>
