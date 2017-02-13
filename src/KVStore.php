<?php
namespace KVStore;

use RecordsMan\IDBAdapter;
use RecordsMan\RecordsManException;

class KVStore implements IKVStore
{
    /** @var IDBAdapter $adapter */
    private static $adapter;

    /**
     * KVStore constructor.
     * @param IDBAdapter $adapter
     */
    public function __construct(IDBAdapter $adapter) {
        self::$adapter = $adapter;
    }

    /**
     * @inheritdoc
     */
    public function get($key, $default = null) {
        $sql = "SELECT `kvstore_value` FROM `kvstore_storage` WHERE `kvstore_key`=:key";
        $value = self::$adapter->fetchSingleValue($sql, [':key' => $key]);
        return ($value !== false) ? $value : $default;
    }

    /**
     * @inheritdoc
     * @throws RecordsManException
     */
    public function set($key, $value) {
        $sql = "INSERT INTO `kvstore_storage` (kvstore_key, kvstore_value) VALUES (:key, :value)";
        $sql.= "ON DUPLICATE KEY UPDATE `kvstore_value`=:value;";
        return self::$adapter->query($sql, [':key' => $key, ':value' => $value]);
    }

    /**
     * @inheritdoc
     */
    public function drop($key) {
        $sql = "DELETE FROM `kvstore_storage` WHERE `kvstore_key`=:key;";
        return self::$adapter->query($sql, [':key' => $key]);
    }
}
