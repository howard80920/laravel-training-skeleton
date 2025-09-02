<template>
  <el-container style="height: 100%;">
    <Modal />
    <el-aside class="aside">
      <AsideMenu />
    </el-aside>
    <el-container>
      <el-header class="header">
        <MainHeader />
      </el-header>
      <el-main class="main">
        <slot />
      </el-main>
    </el-container>
  </el-container>
</template>
<script setup lang="ts">
import { Modal } from 'momentum-modal';
import AsideMenu from '../components/AsideMenu.vue';
import MainHeader from '../components/MainHeader.vue';

</script>
<style lang="scss" scoped>
.aside {
  background: var(--el-color-primary-light-7);
}
.header {
  background: var(--el-color-primary-light-5);
}
.main {
  background: var(--el-bg-color-page);
  padding: 8px;
}
</style>
