<?php


use PHPUnit\Framework\TestCase;
use Finbox\Sdk\Commands\ClientCreateCommand;
use Finbox\Sdk\Finbox;
use Finbox\Sdk\Types\ClientType;
use Finbox\Sdk\Request\Request;
use Finbox\Sdk\Result;
use Finbox\Sdk\Entities\ClientEntity;


class FinboxTest extends TestCase
{
    public function testSendSuccess()
    {
        $testClientResponse = [
            'id' => '1234',
            'initials' => [
                'name' => 'Test client name'
            ],
            'phone' => '79000000000',
        ];

        $request = Mockery::mock(Request::class, [
            'access_token',
            'secret_token',
            'test://test.domain'
        ])
            ->makePartial()
            ->shouldAllowMockingProtectedMethods();
        $request->shouldReceive('request')->andReturn(json_encode($testClientResponse));
        $instance = new Finbox(
            'access_token',
            'secret_token',
            'test://test.domain'
        );

        $reflectionClass = new \ReflectionClass($instance);
        $property = $reflectionClass->getProperty('request');
        $property->setAccessible(true);
        $property->setValue($instance, $request);

        $command = new ClientCreateCommand(
            ClientType::INDIVIDUAL,
            [
                'name' => 'Test',
            ],
            '79182992151'
        );

        $result = $instance->send($command);

        $this->assertInstanceOf(Result::class, $result);
        $this->assertEquals(true, $result->success);
        $this->assertInstanceOf(ClientEntity::class, $result->getResult());
    }
}
