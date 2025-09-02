import { createApp, h, DefineComponent } from 'vue';
import { createPinia } from 'pinia';
import { createInertiaApp } from '@inertiajs/vue3';
import { i18nVue } from 'laravel-vue-i18n';
import { modal } from 'momentum-modal';
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers';

import './styles/main.scss';

const appName = document.getElementsByTagName('title')[0]?.innerText || 'Laravel';

const pageResolver = (name) => resolvePageComponent(
  `./pages/${name}.vue`,
  import.meta.glob<DefineComponent>('./pages/**/*.vue')
);

createInertiaApp({
  title: (title) => title ? `${title} - ${appName}` : appName,
  resolve: pageResolver,
  setup({ el, App, props, plugin }) {
    createApp({ render: () => h(App, props) })
      .use(createPinia())
      .use(i18nVue, {
        resolve: async (lang: string) => {
          const langs = import.meta.glob('./locales/*.json');
          return await langs[`./locales/${lang}.json`]();
        }
      })
      .use(modal, {
        resolve: pageResolver,
      })
      .use(plugin)
      .mount(el);
  },
  progress: {
    color: '#4B5563',
  },
});
