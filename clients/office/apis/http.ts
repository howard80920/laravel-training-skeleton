import axios, { AxiosRequestConfig, Method } from 'axios';
import { router } from '@inertiajs/vue3';

const apiTimeoutSec = 60;

type AjaxResponse<T> = {
  status: number,
  data: T,
};

export type ApiErrorCallback<T = any> = (errorBody: T) => void;

export async function $ajax<T = any>(
  method: Method,
  url: string,
  ...payload: any[]
): Promise<AjaxResponse<T>> {

  const requestData: AxiosRequestConfig = {
    url,
    method,
    headers: {
      'Content-Type': 'application/json',
      'X-Requested-With': 'XMLHttpRequest',
    },
    timeout: apiTimeoutSec * 1000,
  };

  if (method == 'get' || method == 'GET') {
    requestData.params = payload[0];
  } else {
    requestData.data   = payload[0];
    requestData.params = payload[1];
  }

  try {
    const { status, data } = await axios.request(requestData);
    return { status, data };
  } catch (err: any) {
    if (err.response) {
      throw err.response;
    }
    throw err;
  }
}

export function isResponseOK(
  err: any,
  result: any,
  alertError: boolean = false
) {
  if (err) {
    console.warn(err, result);
    if (err.status == 401) {
      router.visit('/office/login');
    }
    if (alertError) {
      // 錯誤處理
    }
    return false;
  }
  return true;
}
