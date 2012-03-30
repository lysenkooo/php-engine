<?php
/**
 * Registry class file
 *
 * @author Denis Lysenko
 */
namespace FW;
/**
 * Registry class provides global common interface for shared data access
 */
class Registry
{
    /**
     * @var array shared data
     */
    private static $_registry;
    /**
     * Get data from registry
     *
     * @static
     * @param string $key name of the requested data
     * @return mixed
     */
    static public function get($key)
    {
        return self::$_registry[$key];
    }
    /**
     * Put data in registry
     *
     * @static
     * @param array $array contains array of data that should be added to registry
     */
    static public function set($array)
    {
        foreach ($array as $key => $value) {
            self::$_registry[$key] = $value;
        }
    }
}