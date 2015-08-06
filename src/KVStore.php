<?php
namespace KVStore;

use RecordsMan\IDBAdapter;
use RecordsMan\RecordsManException;

class KVStore
{
    /** @var IDBAdapter $adapter */
    private static $adapter;

    /**
     * @param IDBAdapter $adapter
     */
    public function __construct(IDBAdapter $adapter) {
        self::$adapter = $adapter;
    }

    /**
     * @param string $key
     * @param mixed|null $default
     * @return mixed|null
     */
    public static function get($key, $default = null) {
        $sql = "SELECT `kvstore_value` FROM `kvstore_storage` WHERE `kvstore_key`=:key;";
        $value = self::$adapter->fetchSingleValue($sql, [':key' => $key]);
        return ($value !== false) ? $value : $default;
    }

    /**
     * @param $key
     * @param $value
     * @return mixed
     * @throws RecordsManException
     */
    public static function set($key, $value) {
        $sql = "INSERT INTO `kvstore_storage` (kvstore_key, kvstore_value) VALUES (:key, :value)";
        $sql.= "ON DUPLICATE KEY UPDATE `kvstore_value`=:value;";
        return self::$adapter->query($sql, [':key' => $key, ':value' => $value]);
    }

    /**
     * @param string $key
     * @return mixed
     */
    public static function drop($key) {
        $sql = "DELETE FROM `kvstore_storage` WHERE `kvstore_key`=:key;";
        return self::$adapter->query($sql, [':key' => $key]);
    }

}
