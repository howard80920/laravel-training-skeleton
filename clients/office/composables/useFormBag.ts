import { watch } from 'vue';
import { useForm } from '@inertiajs/vue3';

type FormValues = Record<string, any>;

type FormBagOptions<F> = {
  labelMap?: Record<keyof F, string>,
};

export function useFormBag<F extends FormValues = FormValues>(
  values: F | null,
  defaults: F,
  opts: FormBagOptions<F> = { }
) {
  const isEdit = !!values;
  const form   = useForm(values ? { ...defaults, ...values} : defaults);

  function formItemAttrs(key: keyof F) {
    const { errors } = form;
    return {
      'show-feedback': true,
      'feedback': (errors[key as string] ?? null) as string,
      'validation-status': errors[key as string] ? 'error' : undefined,
    };
  }

  watch(
    () => form.isDirty,
    () => {
      form.clearErrors();
    }
  );

  return {
    isEdit,
    form,
    formItemAttrs,
    reset: () => form.reset(),
  };
}

export default useFormBag;
