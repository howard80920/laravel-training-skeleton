<template>
  <el-scrollbar>
    <el-menu @select="selectItem">
      <el-sub-menu v-for="item in menuList" :index="item.key">
        <template v-if="item.children" #title>
          <component :is="item.icon" />
          <span>{{ item.label }}</span>
        </template>
        <el-menu-item-group v-if="item.children">
          <el-menu-item v-for="subItem in item.children" :index="subItem.key" @click="selectItem(subItem)">
            {{ subItem.label }}
          </el-menu-item>
        </el-menu-item-group>
      </el-sub-menu>
    </el-menu>
  </el-scrollbar>
</template>
<script setup lang="ts">
import { usePage } from '@inertiajs/vue3';
import useMenu, { IMenuItem } from '../composables/useMenu';

const page = usePage();
const { menuList } = useMenu();
const selectedVal = ref('');
const requestName = computed(() => page.props.request?.name);

function selectItem(item: any) {

}


function updateMenuItem() {
  selectedVal.value = requestName.value;
}

watch(requestName, () => {
  updateMenuItem();
});

onMounted(() => {
  updateMenuItem();
});

</script>
