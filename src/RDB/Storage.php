<?php
namespace KVStore\RDB;

use KVStore\IKVStorage;
use RecordsMan\IDBAdapter;
use RecordsMan\RecordsManException;

class Storage implements IKVStorage
{
    /** @var IDBAdapter $adapter */
    private $_adapter;

    /**
     * KVStore constructor.
     * @param IDBAdapter $adapter
     */
    public function __construct(IDBAdapter $adapter) {
        $this->_adapter = $adapter;
    }

    /**
     * @inheritdoc
     */
    public function get($key, $default = null) {
        $sql = "SELECT `kvstore_value` FROM `kvstore_storage` WHERE `kvstore_key`=:key";
        $value = $this->_adapter->fetchSingleValue($sql, [':key' => $key]);
        return ($value !== false) ? $value : $default;
    }

    /**
     * @inheritdoc
     * @throws RecordsManException
     */
    public function set($key, $value) {
        $sql = "INSERT INTO `kvstore_storage` (kvstore_key, kvstore_value) VALUES (:key, :value)";
        $sql.= "ON DUPLICATE KEY UPDATE `kvstore_value`=:value;";
        return $this->_adapter->query($sql, [':key' => $key, ':value' => $value]);
    }

    /**
     * @inheritdoc
     */
    public function drop($key) {
        $sql = "DELETE FROM `kvstore_storage` WHERE `kvstore_key`=:key;";
        return $this->_adapter->query($sql, [':key' => $key]);
    }
}
