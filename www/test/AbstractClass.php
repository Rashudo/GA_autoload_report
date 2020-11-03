<?php


namespace test;


use PHPUnit\Framework\TestCase;

class AbstractClass extends TestCase
{

    public function __construct(?string $name = null, array $data = [], $dataName = '')
    {
        parent::__construct($name, $data, $dataName);
        $this->initConst();
    }

    private function initConst(): void
    {
        $file = file_get_contents(str_replace('test', '', __DIR__) . '.env');
        $explode = explode(PHP_EOL, $file);
        if (count($explode) > 0) {
            array_map(function ($line) {
                $data = explode('=', $line);
                if ($data[0] && $data[1]) {
                    $const = trim($data[0]);
                    if (!defined($const)) {
                        define($const, trim($data[1]));
                    }
                }
            }, $explode);
        }
        if (!defined('MAIL_SERVER')) {
            define('MAIL_SERVER', '');
        }
        if (!defined('MAIL_USER')) {
            define('MAIL_USER', '');
        }
        if (!defined('MAIL_PASS')) {
            define('MAIL_PASS', '');
        }
        if (!defined('FROM_ADDRESS')) {
            define('FROM_ADDRESS', '');
        }
        if (!defined('DB_NAME')) {
            define('DB_NAME', '');
        }
        if (!defined('DB_HOST')) {
            define('DB_HOST', '');
        }
        if (!defined('DB_PORT')) {
            define('DB_PORT', '');
        }
        if (!defined('DB_LOGIN')) {
            define('DB_LOGIN', '');
        }
        if (!defined('DB_PASS')) {
            define('DB_PASS', '');
        }
    }
}