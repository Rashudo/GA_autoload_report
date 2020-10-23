<?php


namespace Crm_Getter\Traits;


trait SingletonTrait
{

    /**
     * @var static
     */
    private static $_instance;

    /**
     * forbid create
     * SingletonTrait constructor.
     */
    public function __construct()
    {

    }

    /**
     * @return static
     */
    public static function getInstance()
    {
        if (null === static::$_instance) {
            static::$_instance = new self();
        }
        return static::$_instance;
    }

    /**
     * forbid clone
     */
    public function __clone()
    {

    }

    /**
     * forbid deserialize
     */
    public function __wakeup()
    {

    }

    abstract public function run();
}