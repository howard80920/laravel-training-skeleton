import { ref } from 'vue';

export function useLoader() {

  const isLoading = ref(false);

  function doWithLoading(asyncFunc: () => Promise<void>, forceLoading: boolean = false) {
    if (!forceLoading && isLoading.value) {
      return;
    }

    isLoading.value = true;
    asyncFunc()
    .catch((err) => console.error(err))
    .finally(() => isLoading.value = false);
  }

  return {
    isLoading,
    doWithLoading,
  };
}

export default useLoader;
