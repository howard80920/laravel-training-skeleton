<?php

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Contracts\Cache\LockTimeoutException;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\CursorPaginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;

if (!function_exists('query_paginate')) {
    function query_paginate(Builder $query, callable $transformFn = null, bool $toArray = false)
    {
        $paginator = $query->paginate(
            request('per_page', 10),
            ['*'],
            'page',
            request('page', 1)
        );

        if (!$toArray) {
            if ($transformFn) {
                /** @var Collection $paginator */
                $paginator->transform($transformFn);
            }
            return $paginator;
        }
        return paginate_array($paginator, $transformFn);
    }
}

if (!function_exists('paginate_array')) {
    function paginate_array(LengthAwarePaginator $paginator = null, callable $transformFn = null, array $opts = [])
    {
        $paginate = [
            'items' => [],
            'pagination' => null,
        ];
        if ($paginator) {
            $paginate['items'] = $transformFn
                ? $paginator->transform($transformFn)->all()
                : $paginator->items();
            $paginate['pagination'] = [
                'cur_page' => (int) $paginator->currentPage(),
                'per_page' => (int) $paginator->perPage(),
                'total'    => (int) $paginator->total(),
            ];
        }
        return $opts + $paginate;
    }
}

if (!function_exists('query_cursor_paginate')) {
    function query_cursor_paginate(Builder $query, callable $transformFn = null, bool $toArray = false)
    {
        $paginator = $query->cursorPaginate(
            request('per_page', 10),
            ['*'],
            'cursor',
            request('cursor')
        );

        if (!$toArray) {
            if ($transformFn) {
                /** @var Collection $paginator */
                $paginator->transform($transformFn);
            }
            return $paginator;
        }
        return cursor_paginate_array($paginator, $transformFn);
    }
}

if (!function_exists('cursor_paginate_array')) {
    function cursor_paginate_array(CursorPaginator $paginator = null, callable $transformFn = null, array $opts = [])
    {
        $paginate = [
            'items' => [],
            'cursor_pagination' => null,
        ];
        if ($paginator) {
            $paginate['cursor_pagination'] = [
                'prev_cursor' => $paginator->previousCursor()?->encode(),
                'next_cursor' => $paginator->nextCursor()?->encode(),
                'per_page'    => (int) $paginator->perPage(),
            ];
            $paginate['items'] = $transformFn
                ? $paginator->transform($transformFn)->all()
                : $paginator->items();
        }
        return $opts + $paginate;
    }
}

if (!function_exists('items_array')) {
    function items_array($items, array $extras = [])
    {
        return [ 'items' => $items ] + $extras;
    }
}

if (!function_exists('to_sub_query')) {
    function to_sub_query(Builder $query, string $tableName = null)
    {
        $tableName = $tableName ?: 'sub';
        return DB::table(DB::raw("({$query->toSql()}) AS {$tableName}"))->mergeBindings($query->getQuery());
    }
}

if (!function_exists('base64url_encode')) {
    function base64url_encode($data)
    {
        return rtrim(strtr(base64_encode($data), '+/', '-_'), '=');
    }
}

if (!function_exists('base64url_decode')) {
    function base64url_decode($data)
    {
        return base64_decode(str_pad(strtr($data, '-_', '+/'), strlen($data) % 4, '=', STR_PAD_RIGHT));
    }
}


if (!function_exists('get_request_host')) {
    function get_request_host(Request $request)
    {
        $origin    = $request->header('origin', '');
        $reqOrigin = parse_url($origin, PHP_URL_HOST);
        if (!$reqOrigin) {
            return $request->getSchemeAndHttpHost();
        }
        return (parse_url($origin, PHP_URL_SCHEME) ?: 'https') . '://' . $reqOrigin;
    }
}

if (!function_exists('get_request_start_time')) {
    function get_request_start_time(Request $request = null)
    {
        /** @var Request */
        $request = $request ?? request();
        return floatval($request->attributes->get(
            'request_start_time',
            defined('LARAVEL_START') ? constant('LARAVEL_START') : microtime(true)
        ));
    }
}

if (!function_exists('aes_encrypt')) {
    function aes_encrypt($data, $key, $iv)
    {
        $cipher  = 'aes-256-cbc';
        $encData = openssl_encrypt($data, $cipher, $key, OPENSSL_RAW_DATA, $iv);
        return base64url_encode($encData);
    }
}


if (!function_exists('aes_decrypt')) {
    function aes_decrypt($encData, $key, $iv)
    {
        $cipher  = 'aes-256-cbc';
        $decData = openssl_decrypt(base64url_decode($encData), $cipher, $key, OPENSSL_RAW_DATA, $iv);
        return $decData;
    }
}


if (!function_exists('get_cache_with_lock')) {
    function get_cache_with_lock(string $cacheKey, Closure $callback, int $lockSeconds = 5, int $lockWait = 2)
    {
        $data = Cache::get($cacheKey);
        if ($data !== null) {
            return $data;
        }

        $lock = Cache::lock("cache_lock:{$cacheKey}", $lockSeconds);
        try {
            if (!$lock->get()) {
                $lock->block($lockWait);
            }
            $data = Cache::remember($cacheKey, 600, $callback);
            return $data;
        } catch (LockTimeoutException $e) {
            report($e);
            return $callback();
        } finally {
            $lock?->release();
        }
    }
}

if (!function_exists('convert_array_to_utf8')) {
    function convert_array_to_utf8(array $array)
    {
        array_walk_recursive($array, function (&$val) {
            if (is_string($val) && !empty($val)) {
                $encoding = mb_detect_encoding($val, [ 'UTF-8', 'SJIS', 'BIG-5', 'GBK', 'ISO-8859-1' ], true);
                if ($encoding !== 'UTF-8') {
                    $val = mb_convert_encoding($val, 'UTF-8', $encoding);
                }
            }
        });
        return $array;
    }
}
