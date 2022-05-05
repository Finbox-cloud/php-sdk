<?php

use PHPUnit\Framework\TestCase;

class Utils extends Finbox\Sdk\Hash\HashUtils\HashUtils
{
    static function call($method, ...$args)
    {
        return call_user_func([self::class, $method], ...$args);
    }
}

class HashUtilsTest extends TestCase
{
    public function testFlatten()
    {
        $res = Utils::call('_flatten', [
            'a' => [
                'b' => 1,
                'c' => 'test',
                'd' => [
                    'e' => ''
                ],
            ],
            'f' => true,
            'g' => false,
            'h' => null,
        ]);
        $this->assertEquals([
            'a.b' => 1,
            'a.c' => 'test',
            'a.d.e' => '',
            'f' => true,
            'g' => false,
            'h' => null,
        ], $res);
    }

    public function testFilterEmptyValues()
    {
        $res = Utils::call('_filterEmptyValues', [
            'a.b' => 1,
            'a.c' => 'test',
            'a.d.e' => '',
            'f' => true,
            'g' => false,
            'h' => null,
        ]);
        $this->assertEquals([
            'a.b' => 1,
            'a.c' => 'test',
            'f' => true,
            'g' => false,
        ], $res);
    }

    public function testConcatDataKeyItems()
    {
        $res = Utils::call('_concatDataKeyItems', [
            'a.b' => 1,
            'a.c' => 'test',
        ]);
        $this->assertEquals([
            'a.b:1',
            'a.c:test',
        ], $res);
    }

    public function testTrimValues()
    {
        $res = Utils::call('_trimValues', [
            'a.b' => ' ',
            'a.c' => 'test ',
            'a.d' => 'test test',
        ]);
        $this->assertEquals([
            'a.b' => '',
            'a.c' => 'test',
            'a.d' => 'test test',
        ], $res);
    }
}
