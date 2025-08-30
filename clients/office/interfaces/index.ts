
export interface PaginatorData<T = any> {
  items: T[],
  pagination: {
    per_page: number,
    cur_page: number,
    total: number,
  } | null,
}

export interface ItemListData<T = any> {
  items: T[],
}


export type OptionValue = any;

export type OptionItem = {
  label: string,
  value: OptionValue,
}
