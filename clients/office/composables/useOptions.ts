import { ComputedGetter } from 'vue';

export type OptionValue = any;

export type OptionItem = {
  label: string;
  value: OptionValue;
};

export function useOptions() {

  function getOptionLabel(options: OptionItem[], value: any) {
    if (value === undefined) return '';
    let label = 'Undefined:' + value;
    options.some((item) => {
      if (item.value == value) {
        label = item.label;
        return true;
      }
      return false;
    });

    return label;
  }

  function createOptionsPack(getter: ComputedGetter<OptionItem[]>) {
    const options = computed(getter);
    return reactive({
      options,
      getLabel: (value: any) => getOptionLabel(options.value, value),
    });
  }


  return {
    createOptionsPack,
    getOptionLabel,
  };
}

export default useOptions;
