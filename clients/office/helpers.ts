
export function asyncDo<T, E = any>(promise: Promise<T>): Promise<[undefined, T] | [E, undefined]> {
  return promise
  .then<[undefined, T]>((res) => [undefined, res])
  .catch((err) => [err, undefined]);
}

export function formatNumber(value: string | number, decimals: number = 2) {
  return isNaN(value as number) ? `${value}` : Number(value).toLocaleString('en-US', {
    minimumFractionDigits: decimals,
    maximumFractionDigits: decimals,
  });
}
