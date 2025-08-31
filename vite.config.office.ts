import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import vue from '@vitejs/plugin-vue';
import AutoImport from 'unplugin-auto-import/vite';
import Components from 'unplugin-vue-components/vite';
import { ElementPlusResolver } from 'unplugin-vue-components/resolvers';
import Icons from 'unplugin-icons/vite';
import IconsResolver from 'unplugin-icons/resolver';
import cssInjectedByJsPlugin from 'vite-plugin-css-injected-by-js';

export default defineConfig({
  plugins: [
    laravel({
      hotFile: 'storage/office.hot', // Customize the "hot" file...
      buildDirectory: 'build/office', // Customize the build directory...
      input: ['clients/office/main.ts'],
      refresh: true,
    }),
    vue({
      template: {
        transformAssetUrls: {
          base: null,
          includeAbsolute: false,
        },
      },
    }),
    AutoImport({
      dts: 'clients/.types/auto-imports.d.ts', // typescript 宣告檔案位置
      imports: [
        'vue',
      ],
      resolvers: [
        ElementPlusResolver(),
        IconsResolver({
          prefix: 'icon',
          enabledCollections: [ 'mdi' ],  // https://icones.netlify.app/collection/mdi
        }),
      ],
    }),
    Components({
      dts: 'clients/.types/components.d.ts',
      resolvers: [
        ElementPlusResolver(),
        IconsResolver({
          prefix: 'icon',
          enabledCollections: [ 'mdi' ],  // https://icones.netlify.app/collection/mdi
        }),
      ],
    }),
    Icons({
      autoInstall: true,
      compiler: 'vue3',
      scale: 1,
    }),
    cssInjectedByJsPlugin(),
  ],
  resolve: {
    alias: {
      '@': '/clients',
    },
  },
  build: {
    manifest: 'assets.json', // Customize the manifest filename...
  },
});
