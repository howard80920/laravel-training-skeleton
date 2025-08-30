import { PageProps as InertiaPageProps } from '@inertiajs/core';
import type { PageProps as AppPageProps } from '../interfaces/props';

declare global {

}

declare module '@inertiajs/core' {
  interface PageProps extends InertiaPageProps, AppPageProps { }
}
