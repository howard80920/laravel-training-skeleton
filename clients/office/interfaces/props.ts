
export interface PageProps {
  auth: {},
  flash: {
    success?: string,
    error?: string,
    message?: string,
  },
  request: {
    prefix: string,
    name: string,
    path: string,
    query: Record<string, any>,
    previous: string,
  },
  locales: Record<string, string>,
  locale: string,
}
