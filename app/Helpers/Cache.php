<?php

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
    
    public static function flush()
    {
        CacheEloquent::flush();
    }
}