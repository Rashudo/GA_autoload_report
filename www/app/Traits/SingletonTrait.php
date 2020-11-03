<?php

namespace Crm_Getter\Traits;

/**
 * Trait SingletonTrait
 * @package Crm_Getter\Traits
 */
trait SingletonTrait
{

    /**
     * @var self
     */
    private static $instance = null;

    /**
     * forbid create
     * SingletonTrait constructor.
     */
    private function __construct()
    {
    }

    /**
     * @return static
     */
    public static function getInstance()
    {
        if (!static::$instance) {
            static::$instance = new self();
        }
        return static::$instance;
    }

    /**
     * forbid clone
     */
    private function __clone()
    {
    }

    /**
     * forbid deserialize
     */
    private function __wakeup()
    {
    }
}
