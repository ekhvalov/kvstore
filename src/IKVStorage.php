<?php
namespace KVStore;

/**
 * Interface IKVStore
 * @package KVStore
 */
interface IKVStorage
{
    /**
     * @param string $key
     * @param mixed|null $default
     * @return mixed|null
     */
    function get($key, $default = null);

    /**
     * @param string $key
     * @param mixed $value
     */
    function set($key, $value);

    /**
     * @param string $key
     */
    function drop($key);
}
