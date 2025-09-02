import { trans as t } from 'laravel-vue-i18n';

export interface IMenuItem {
  label: string;
  key: string;
  icon?: Component;
  href?: string;
  children?: Omit<IMenuItem, 'children'>[],
};

export function useMenu() {

  const menuList = computed<IMenuItem[]>(() => [

  ]);

  return {
    menuList,
  };
}

export default useMenu;
