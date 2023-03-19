<?php

namespace Byte;

/**
 * Cache Model
 */
class Cache
{

    public function __construct()
    {
        $cacheDir = 'App/Cache';
        if (!file_exists($cacheDir)) {
            mkdir($cacheDir, 0777, true);
        }
        self::cleanCache();
    }
    /**
     * Checking cache has already value
     *
     * @param string $key
     * 
     * @return bool
     * 
     */
    public static function has($key)
    {
        $file = self::getCacheFile($key);
        return file_exists($file) && (filemtime($file) > time() - 3600);
    }
    /**
     * Getting value by key from cache
     *
     * @param string $key
     * 
     * @return mixed
     * 
     */
    public static function get($key)
    {
        $file = self::getCacheFile($key);
        return file_get_contents($file);
    }
    /**
     * Setting Cache file to some value by key
     *
     * @param string $key
     * @param mixed $value
     * 
     * @return string
     * 
     */
    public static function set($key, $value)
    {
        $file = self::getCacheFile($key);
        file_put_contents($file, $value);
        $cacheDir = 'App/Cache';
        $code = str_replace($cacheDir . '/', '', $file);
        return $code;
    }
    /**
     * Getting file from cache by key
     *
     * @param string $key
     * 
     * @return string
     * 
     */
    private static function getCacheFile($key)
    {
        $cacheDir = 'App/Cache';
        return $cacheDir . '/' . md5($key);
    }
    /**
     * Deleting cache by key
     *
     * @param string $key
     * 
     * @return bool
     * 
     */
    public static function deleteCache($key)
    {
        $file = self::getCacheFile($key);
        if (file_exists($file)) {
            if (!unlink($file)) {
                return false;
            } else {
                return true;
            }
        }
    }
    /**
     * Auto cleaning cache
     *
     * @return null
     * 
     */
    private static function cleanCache()
    {
        $cacheDir = 'App/Cache';
        $files = glob($cacheDir . '/*');
        foreach ($files as $file) {
            if (filemtime($file) < time() - 3600) {
                unlink($file);
            }
        }
    }
}
