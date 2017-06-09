<?php
/**
 * Created by PhpStorm.
 * User: worker
 * Date: 6/9/17
 * Time: 09:55
 */

namespace Cat\Helpers;

use Illuminate\Support\Facades\Cache as CacheEloquent;


class Cache
{
    public static function get($key, callable $provider, $paramsCallable = [], $mins = 1440)
    {
        
        $cacheElement = CacheEloquent::get($key);
        
        if ($cacheElement == null) {
            $cacheElement = call_user_func_array($provider, $paramsCallable);
            CacheEloquent::put($key, $cacheElement, $mins);
        }
        
        return $cacheElement;
    }
}