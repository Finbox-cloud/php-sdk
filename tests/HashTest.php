<?php


use Finbox\Sdk\Hash\Hash;
use PHPUnit\Framework\TestCase;


class HashTest extends TestCase
{
    public function testSuccessHash() {
        $hash = Hash::hash([
            'initials' => [
                'name' => 'Test client by API ',
                'surname' => null,
            ],
            'type' => 'individual',
            'phone' => '8(918) 299 - 21 -55',
            'amount' => 12,
            'term' => 0,
            'test' => [
                [ 'a' => 1 ],
                [ 'b' => 1 ],
            ]
        ], 'EUimAIPmVoyt4');

        $this->assertEquals('7c2549c3ecc3f1c289e4a3ea1b60d32c', $hash);
    }
}
