<?php
/**
 * Database class file
 *
 * @author Denis Lysenko
 */
namespace FW;
/**
 * Database class provides access to different databases (MySQL, SQLite) with common interface
 */
class Database
{
    /**
     * @var \PDO is the instance of PDO class
     */
    private static $_instance;
    /**
     * Singleton pattern that always returns instance of database class
     *
     * @static
     * @return \PDO
     */
    public static function getInstance()
    {
        if (!isset(self::$_instance)) {
            self::$_instance = new \PDO(Registry::get('pdo_string'), Registry::get('pdo_user'), Registry::get('pdo_password'));
            self::$_instance->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
            self::$_instance->exec('SET CHARSET utf8');
        }

        return self::$_instance;
    }
}